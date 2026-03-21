<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\MedicoHorario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar estructura básica del request
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id'   => 'required|exists:users,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'motivo'      => 'nullable|string|max:500',
        ]);

        $medico     = User::findOrFail($validated['medico_id']);
        $fecha      = Carbon::parse($validated['fecha']);
        $horaInicio = Carbon::parse($validated['hora_inicio']);
        $horaFin    = $horaInicio->copy()->addHour();

        // 2. Verificar que el usuario es médico
        if ($medico->role !== 'medico') {
            return response()->json([
                'message' => 'El usuario seleccionado no es un médico.'
            ], 422);
        }

        // 3. Verificar que el médico esté activo
        if (!$medico->activo) {
            return response()->json([
                'message' => 'El médico no está disponible.'
            ], 422);
        }

        // 4. Verificar que el médico trabaja ese día
        // Carbon: 0=domingo, 1=lunes ... 6=sábado
        $diaSemana = $fecha->dayOfWeek;

        $horario = MedicoHorario::where('user_id', $medico->id)
            ->where('dia_semana', $diaSemana)
            ->first();

        if (!$horario) {
            return response()->json([
                'message' => 'El médico no atiende ese día de la semana.',
                'dias_disponibles' => $this->getDiasDisponibles($medico->id)
            ], 422);
        }

        // 5. Verificar que la hora está dentro del horario del médico
        $inicioHorario = Carbon::parse($horario->hora_inicio);
        $finHorario    = Carbon::parse($horario->hora_fin);

        // La cita debe iniciar y terminar dentro del horario
        if ($horaInicio->lt($inicioHorario) || $horaFin->gt($finHorario)) {
            return response()->json([
                'message' => "El médico atiende de {$horario->hora_inicio} a {$horario->hora_fin} ese día.",
            ], 422);
        }

        // 6. Verificar que no haya cita duplicada (conflicto de horario)
        $conflicto = Cita::where('medico_id', $medico->id)
            ->where('fecha', $fecha->toDateString())
            ->where(function ($query) use ($horaInicio, $horaFin) {
                // Detecta cualquier traslape, no solo mismo inicio exacto
                $query->whereBetween('hora_inicio', [
                    $horaInicio->format('H:i:s'),
                    $horaFin->subMinute()->format('H:i:s')
                ])->orWhereBetween('hora_fin', [
                    $horaInicio->addMinute()->format('H:i:s'),
                    $horaFin->format('H:i:s')
                ]);
            })
            ->whereNotIn('estado', ['cancelada'])
            ->exists();

        if ($conflicto) {
            return response()->json([
                'message' => 'El médico ya tiene una cita en ese bloque de tiempo.',
            ], 409);
        }

        // 7. Crear la cita
        $cita = Cita::create([
            'paciente_id' => $validated['paciente_id'],
            'medico_id'   => $medico->id,
            'fecha'       => $fecha->toDateString(),
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin'    => $horaFin->format('H:i:s'),
            'motivo'      => $validated['motivo'] ?? null,
            'estado'      => 'pendiente',
        ]);

        return response()->json([
            'message' => 'Cita agendada exitosamente.',
            'data'    => $cita->load('paciente', 'medico'),
        ], 201);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $citas = Cita::with(['paciente', 'medico'])
            ->when($user->role === 'medico', fn($q) => $q->where('medico_id', $user->id))
            ->when($request->fecha, fn($q) => $q->whereDate('fecha', $request->fecha))
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return response()->json(['data' => $citas]);
    }

    // Helper: retorna los días disponibles del médico
    private function getDiasDisponibles(int $medicoId): array
    {
        $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];

        return MedicoHorario::where('user_id', $medicoId)
            ->get()
            ->map(fn($h) => [
                'dia'         => $dias[$h->dia_semana],
                'hora_inicio' => $h->hora_inicio,
                'hora_fin'    => $h->hora_fin,
            ])
            ->toArray();
    }
}
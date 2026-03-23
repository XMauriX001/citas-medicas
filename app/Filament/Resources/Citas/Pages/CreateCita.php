<?php

namespace App\Filament\Resources\Citas\Pages;

use App\Filament\Resources\Citas\CitaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\MedicoHorario;
use App\Models\Cita;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class CreateCita extends CreateRecord
{
    protected static string $resource = CitaResource::class;

    protected function beforeValidate(): void
    {
        $data = $this->form->getState();
        
        // Validar que el día y hora están en el horario del médico
        if (isset($data['id_medico'], $data['fecha'], $data['hora_inicio'], $data['hora_fin'])) {
            $fecha = Carbon::parse($data['fecha']);
            $diaSemana = $fecha->dayOfWeek;
            $horaInicio = Carbon::parse($data['hora_inicio']);
            $horaFin = Carbon::parse($data['hora_fin']);

            // Verificar horario del médico
            $horario = MedicoHorario::where('id_medico', $data['id_medico'])
                ->where('dia_semana', $diaSemana)
                ->first();

            if (!$horario) {
                Notification::make()
                    ->danger()
                    ->title('Horario no disponible')
                    ->body('El médico no atiende este día de la semana.')
                    ->send();
                    
                $this->halt();
            }

            // Verificar que está dentro del rango
            $inicioHorario = Carbon::parse($horario->hora_inicio);
            $finHorario = Carbon::parse($horario->hora_fin);

            if ($horaInicio->lt($inicioHorario) || $horaFin->gt($finHorario)) {
                Notification::make()
                    ->danger()
                    ->title('Fuera de horario')
                    ->body("El médico atiende de {$horario->hora_inicio} a {$horario->hora_fin} este día.")
                    ->send();
                    
                $this->halt();
            }

            // Verificar conflictos de citas
            $conflicto = Cita::where('id_medico', $data['id_medico'])
                ->where('fecha', $fecha->toDateString())
                ->where(function ($query) use ($horaInicio, $horaFin) {
                    $query->where(function ($q) use ($horaInicio, $horaFin) {
                        $q->whereBetween('hora_inicio', [
                            $horaInicio->format('H:i:s'),
                            $horaFin->copy()->subMinute()->format('H:i:s')
                        ]);
                    })->orWhere(function ($q) use ($horaInicio, $horaFin) {
                        $q->whereBetween('hora_fin', [
                            $horaInicio->copy()->addMinute()->format('H:i:s'),
                            $horaFin->format('H:i:s')
                        ]);
                    })->orWhere(function ($q) use ($horaInicio, $horaFin) {
                        $q->where('hora_inicio', '<=', $horaInicio->format('H:i:s'))
                          ->where('hora_fin', '>=', $horaFin->format('H:i:s'));
                    });
                })
                ->whereNotIn('estado', ['cancelada'])
                ->exists();

            if ($conflicto) {
                Notification::make()
                    ->danger()
                    ->title('Conflicto de horario')
                    ->body('El médico ya tiene una cita en ese bloque de tiempo.')
                    ->send();
                    
                $this->halt();
            }
        }
    }
}
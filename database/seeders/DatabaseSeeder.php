<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\Paciente;
use App\Models\MedicoHorario; 
use App\Models\Cita; 
use App\Models\ExpedienteClinico;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Usuarios 
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@clinica.com',
            'role' => 'admin',
            'activo' => true,
        ]);

        User::factory()->create([
            'name' => 'Asistente 1',
            'email' => 'asistente1@clinica.com',
            'role' => 'asistente',
            'activo' => true,
        ]);

        User::factory()->create([
            'name' => 'Asistente 2',
            'email' => 'asistente2@clinica.com',
            'role' => 'asistente',
            'activo' => true,
        ]);

        // Crear 25 médicos
        $medicos = User::factory()->count(25)->create([
            'role' => 'medico',
            'activo' => true,
        ]);

        // Crear 40 pacientes
        $pacientes = Paciente::factory()->count(40)->create();

        // Crear expedientes para pacientes
        foreach ($pacientes as $paciente) {
            ExpedienteClinico::factory()->create([
                'id_paciente' => $paciente->id,
            ]);
        }

        // Separado por dias de la semana para cada medico
        foreach ($medicos as $medico) {
            MedicoHorario::factory()->create(['id_medico' => $medico->id, 'dia_semana' => 1]);
            MedicoHorario::factory()->create(['id_medico' => $medico->id, 'dia_semana' => 2]);
            MedicoHorario::factory()->create(['id_medico' => $medico->id, 'dia_semana' => 3]);
            MedicoHorario::factory()->create(['id_medico' => $medico->id, 'dia_semana' => 4]);
        }

        // Crear citas
        for ($i = 0; $i < 80; $i++) {
            try {
                Cita::factory()->create([
                    'id_paciente' => $pacientes->random()->id,
                    'id_medico' => $medicos->random()->id,
                ]);
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
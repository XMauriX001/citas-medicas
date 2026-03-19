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

    /**
     * Seed the application's database.
     */
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

        $medicos = User::factory()->count(25)->create([
            'role' => 'medico',
            'activo' => true,
        ]);

        $pacientes = Paciente::factory()->count(40)->create();

        // Datos
        foreach ($pacientes as $paciente) {
            ExpedienteClinico::factory()->create([
                'id_paciente' => $paciente->id,
            ]);
        }

        foreach ($medicos as $medico) {
            MedicoHorario::factory()->count(4)->create([
                'id_medico' => $medico->id,
            ]);
        }

        for ($i = 0; $i < 80; $i++) {
            Cita::factory()->create([
                'id_paciente' => $pacientes->random()->id,
                'id_medico' => $medicos->random()->id,
            ]);
        }
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MedicoHorario;

/**
 * @extends Factory<MedicoHorario>
 */
class MedicoHorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horarios = [
            ['hora_inicio' => '08:00:00', 'hora_fin' => '11:00:00'],
            ['hora_inicio' => '10:00:00', 'hora_fin' => '18:00:00'],
            ['hora_inicio' => '15:00:00', 'hora_fin' => '17:00:00'],
            ['hora_inicio' => '16:00:00', 'hora_fin' => '20:00:00'],
            ['hora_inicio' => '14:00:00', 'hora_fin' => '18:00:00'],
        ];

        $horario = fake()->randomElement($horarios);

        return [
            'dia_semana' => fake()->numberBetween(0, 5), //Hasta el sabado
            'hora_inicio' => $horario['hora_inicio'],
            'hora_fin' => $horario['hora_fin'],
        ];
    }
}

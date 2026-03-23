<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horaInicio = fake()->randomElement([
            '08:00:00', '09:00:00', '10:00:00', '11:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00','18:00:00',
            ]);

        $horaFinMap = [
            '08:00:00' => '09:00:00',
            '09:00:00' => '10:00:00',
            '10:00:00' => '11:00:00',
            '11:00:00' => '12:00:00',
            '14:00:00' => '15:00:00',
            '15:00:00' => '16:00:00',
            '16:00:00' => '17:00:00',
            '17:00:00' => '18:00:00',
            '18:00:00' => '19:00:00',
            ];

        return [
            'fecha' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFinMap[$horaInicio],
            'estado' => fake()->randomElement([
                'pendiente', 'confirmada', 'cancelada', 'completada',
            ]),
        ];
    }
}

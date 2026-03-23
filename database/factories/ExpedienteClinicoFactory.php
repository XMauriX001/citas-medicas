<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ExpedienteClinico;
use App\Models\Paciente;

/**
 * @extends Factory<ExpedienteClinico>
 */
class ExpedienteClinicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_paciente' => Paciente::factory(),
            'alergias' => fake()->randomElement([
                'Ninguna', 'Acetaminofen',
            ]),

            'antecedentes' => fake()->randomElement([
                'Ninguno', 'Hipertensión','Diabetes tipo 2',
            ]),

            'medicamentos_actuales' => fake()->randomElement([
                'Ninguno', 'Paracetamol','Ibuprofeno',
            ]),

            'tipo_sangre' => fake()->randomElement([
                'A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'
            ]),
        ];
    }
}

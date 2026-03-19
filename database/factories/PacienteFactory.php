<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Paciente;

/**
 * @extends Factory<Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'fecha_nacimiento' => fake()->date(),
            'dui' => fake()->unique()->numerify('########-#'),
            'telefono' => fake()->randomElement([
                fake()->numerify('8#######'),
            ]),
            'email' => fake()->safeEmail(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Cria um usuário junto
            'nationality' => $this->faker->country,
            'position' => $this->faker->randomElement(['Atacante', 'Meio-campo', 'Defensor', 'Goleiro']),
            'laterality' => $this->faker->randomElement(['Destro', 'Canhoto']),
            'height' => $this->faker->randomFloat(2, 1.5, 2.0),
            'weight' => $this->faker->numberBetween(60, 90),
            'medication' => $this->faker->optional()->word,
            'date_init' => $this->faker->date(),
            'date_end' => null,
            'date_of_birth' => $this->faker->date('d-m-Y', '-10 years'),
            'active' => $this->faker->boolean(80),
        ];
    }
}

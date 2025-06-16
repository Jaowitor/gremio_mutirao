<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'name_category' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'type_category' => $this->faker->randomElement(['10', '11', '12', '13', '14', '15', '16', '17']),
        ];
    }
}

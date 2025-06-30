<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Student;

class CategoryStudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'student_id' => Student::factory(),
        ];
    }
}
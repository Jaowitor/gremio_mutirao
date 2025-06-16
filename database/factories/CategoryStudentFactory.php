<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Student;

class CategoryStudentFactory extends Factory
{
    public function definition(): array
    {
        
        $student = Student::inRandomOrder()->first();

        $age = now()->diffInYears($student->date_of_birth);

        $category = Category::where('type_category', $age)->first();

        if (!$category) {
            $category = Category::inRandomOrder()->first();
        }

        return [
            'student_id' => $student->id,
            'category_id' => $category->id,
        ];
    }
}
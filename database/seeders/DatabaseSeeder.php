<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryStudent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    User::factory(10)->create();

    Student::factory(20)->create();

    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('root123'),
    ]);

        Category::factory(10)->create();
        $students = Student::all();
        $categories = Category::all();

        foreach ($students as $student) {
            // Calcula idade do estudante
            $age = now()->diffInYears($student->date_of_birth);

            // Seleciona categoria que combina com a idade
            $category = $categories->where('type_category', $age)->first();

            if ($category) {
                CategoryStudent::factory()->create([
                    'student_id' => $student->id,
                    'category_id' => $category->id,
                ]);
            }
        }

    }

}

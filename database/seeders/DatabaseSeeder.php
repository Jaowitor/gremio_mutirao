<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryStudent;
use App\Models\Training;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('root123'),
    ]);

    User::factory(20)->create();

    Student::factory(20)->create();



    Student::factory()->create([
        'user_id' => 1,
        'nationality' => 'Brasileiro',
        'position' => 'Goleiro',
        'laterality' => 'Destro',
        'height' => 1.80,
        'weight' => 80,
        'medication' => 'Nenhuma',
        'date_init' => '2023-01-01',
        'date_end' => '2023-12-31',
        'date_of_birth' => '1990-01-01',
        'active' => true
    ]);



        Category::factory(10)->create();

        CategoryStudent::factory(20)->create();
        
        Training::factory(10)->create();
    }

}

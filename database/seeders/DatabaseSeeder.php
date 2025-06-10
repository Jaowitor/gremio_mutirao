<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria 10 usuários genéricos
        \App\Models\User::factory(10)->create();

        // Cria 20 alunos (cada um já cria um usuário vinculado)
        Student::factory(20)->create();

        // Usuário de teste fixo
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('root123'),
        ]);
    }
}

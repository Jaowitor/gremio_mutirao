<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Importe o modelo User, se ainda não estiver
use Illuminate\Support\Facades\Hash; // Para definir uma senha explícita, se quiser

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Cria um usuário para login com credenciais conhecidas
        User::factory()->create([
            'name' => 'Admin Teste',
            'email' => 'admin@example.com',
            'password' => Hash::make('senha123'),
        ]);

        // Você também pode criar outros usuários aleatórios usando o factory, se desejar
        // User::factory(10)->create();
    }
}
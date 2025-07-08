<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserCommand extends Command
{
    /**
     * O nome e a assinatura do comando.
     */
    protected $signature = 'app:create-user';

    /**
     * A descrição do comando.
     */
    protected $description = 'Cria um novo usuário de forma interativa';

    /**
     * Executa o comando.
     */
    public function handle()
    {
        $this->info('Criando um novo usuário...');

        $name = $this->ask('Qual o nome do usuário?');
        $email = $this->ask('Qual o e-mail do usuário?');
        
        // Pergunta a senha de forma segura (não mostra o que é digitado)
        $password = $this->secret('Digite uma senha para o usuário?');

        // Validação simples
        if (empty($name) || empty($email) || empty($password)) {
            $this->error('Nome, e-mail e senha não podem estar vazios.');
            return Command::FAILURE;
        }

        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info('✅ Usuário "' . $name . '" criado com sucesso!');

        } catch (\Exception $e) {
            $this->error('Houve um erro ao criar o usuário: ' . $e->getMessage());
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DbCustomFresh extends Command
{
    /**
     * Adicionamos a opção --allow-prod aqui.
     * @var string
     */
    protected $signature = 'db:custom-fresh {--allow-prod : Permite a execução em ambiente de produção com confirmação explícita.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseta o banco de dados (MySQL, etc.) usando migrate:fresh e roda um seeder específico. PERIGOSO EM PRODUÇÃO.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Pega o valor da flag --allow-prod que o usuário passou (ou não)
        $allowInProduction = $this->option('allow-prod');

        // Se o ambiente for de produção E a flag --allow-prod NÃO foi passada, bloqueia a execução.
        if (app()->environment('production') && !$allowInProduction) {
            $this->error('OPERAÇÃO PERIGOSA CANCELADA: Este comando está bloqueado em produção.');
            $this->warn('Para executar mesmo assim (NÃO RECOMENDADO), use a flag: --allow-prod');
            return Command::FAILURE;
        }

        // Se chegou aqui, ou não é produção, ou a flag --allow-prod foi usada.
        // Mesmo assim, pedimos uma confirmação final.
        if (!$this->confirm('Você tem CERTEZA que deseja apagar TODAS as tabelas do seu banco de dados? Esta ação não pode ser desfeita.')) {
            $this->info('Operação cancelada pelo usuário.');
            return Command::SUCCESS;
        }

        $this->info('Iniciando o processo de reset do banco de dados...');

        // Executar o MIGRATE:FRESH
        $this->info('Executando "migrate:fresh"...');
        Artisan::call('migrate:fresh', ['--force' => true]);
        $this->line(Artisan::output());

        // Executar o SEEDER
        $this->info('Executando o UserSeeder...');
        Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
        $this->line(Artisan::output());

        $this->info('✅ Processo concluído com sucesso! O banco de dados foi resetado e populado.');

        return Command::SUCCESS;
    }
}
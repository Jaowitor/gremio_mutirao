<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ResetDB extends Command
{
    protected $signature = 'db:reset';
    protected $description = 'Reseta completamente o banco de dados SQLite e recarrega os fixtures';

    public function handle()
    {
        $this->info(' Resetando banco de dados SQLite...');

        // Caminho do arquivo do banco SQLite
        $databasePath = database_path('database.sqlite');

        // Removendo o banco se existir
        if (File::exists($databasePath)) {
            File::delete($databasePath);
            $this->info(' Banco de dados removido!');
        } else {
            $this->warn(' O banco já estava ausente, criando um novo.');
        }

        // Criando um novo arquivo SQLite vazio
        File::put($databasePath, '');
        $this->info(' Novo banco criado!');

        // Rodando migrations
        $this->info(' Rodando migrations...');
        Artisan::call('migrate');

        // Exibir todas as tabelas criadas
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;");
        $this->info(' Tabelas criadas:');
        foreach ($tables as $table) {
            $this->line("- " . $table->name);
        }

        // Rodando Seeders
        $this->info(' Carregando fixtures...');
        Artisan::call('db:seed');

        $this->info(' Banco resetado e pronto para uso!');
    }
}
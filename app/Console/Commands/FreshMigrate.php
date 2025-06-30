<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class FreshMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fresh-migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseta o banco de dados SQLite, remove o arquivo existente, roda as migrations e o UserSeeder.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(' Iniciando o processo de fresh-migrate do banco de dados SQLite...');

        // Caminho do arquivo do banco SQLite
        $databasePath = database_path('database.sqlite');

        // Removendo o banco se existir
        if (File::exists($databasePath)) {
            File::delete($databasePath);
            $this->info(' Arquivo do banco de dados existente removido!');
        } else {
            $this->warn(' O arquivo database.sqlite já estava ausente, criando um novo.');
        }

        // Criando um novo arquivo SQLite vazio
        File::put($databasePath, '');
        $this->info(' Novo arquivo database.sqlite vazio criado!');

        // Rodando apenas as migrations
        $this->info(' Rodando migrations...');
        // O segundo argumento [] é para argumentos/opções do comando `migrate`
        // O terceiro argumento `$this->getOutput()` direciona a saída do comando `migrate` para o console atual
        Artisan::call('migrate', [], $this->getOutput());

        // Exibir todas as tabelas criadas para confirmação
        try {
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;");
            $this->info(' Tabelas criadas:');
            foreach ($tables as $table) {
                // Filtra tabelas internas do SQLite como 'sqlite_sequence' ou 'migrations' se preferir
                // Corrigido: str_starts_wait para str_starts_with
                if (!str_starts_with($table->name, 'sqlite_')) {
                    $this->line("- " . $table->name);
                }
            }
        } catch (\Exception $e) {
            $this->error(' Erro ao listar tabelas: ' . $e->getMessage());
        }

        // Rodando apenas o UserSeeder
        $this->info(' Carregando apenas o UserSeeder...');
        // Chama o comando db:seed com a opção --class para especificar apenas o UserSeeder
        Artisan::call('db:seed', ['--class' => 'UserSeeder'], $this->getOutput());

        $this->info(' Banco de dados resetado, migrations aplicadas e UserSeeder carregado com sucesso!');

        return Command::SUCCESS; // Retorna sucesso para o console
    }
}

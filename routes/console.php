<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ResetDB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:reset', function () {
    $this->call(ResetDB::class);
})->purpose('Reseta completamente o banco de dados SQLite e recarrega os fixtures');

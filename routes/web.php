<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BreadcrumbsController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\StudentController;


Route::get('/', function () {
    return view('home');
});



Route::prefix('/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::get('/dashboard', [SistemaController::class, 'dashboard'])->name('dashboard')->middleware('auth');



Route::middleware('auth')->prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');

    Route::get('/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/', [StudentController::class, 'store'])->name('students.store');

    Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/{id}', [StudentController::class, 'update'])->name('students.update');

    Route::get('/{id}', [StudentController::class, 'show'])->name('students.show');


});


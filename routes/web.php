<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;


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


}
);



Route::middleware('auth')->prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
}
);

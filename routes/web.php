<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrequencyController;
use App\Http\Controllers\TrainingController;


Route::get('/', function () {
    return view('home');
});

Route::post('/screen-size', function (Request $request) {
    session([
        'screen_height' => $request->height,
        'screen_width' => $request->width
    ]);
    return response()->json(['success' => true]);
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
    Route::get('', [CategoryController::class, 'index'])->name('category.index');
    Route::get('create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('{category}/add_students',  [CategoryController::class, 'addStudentIndex'])->name('category.add_student');
    Route::post('{category}/add_students', [CategoryController::class, 'addStudentStore'])->name('category.add_student_store');
    Route::get('{category}/edit',[CategoryController::class, 'edit'])->name('category.edit');
    Route::put('{category}',[CategoryController::class, 'update'])->name('category.update');
    Route::delete('{category}',[CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('{category}',[CategoryController::class, 'show'])->name('category.show');
});



Route::middleware('auth')->prefix('frequency')->group(function () {
    // Rota para exibir a página de frequência para uma categoria específica
    Route::get('/{category}', [FrequencyController::class, 'index'])->name('frequency.index');

    // Rota para processar a atualização/criação em massa das frequências
    Route::post('/store-bulk', [FrequencyController::class, 'storeBulk'])->name('frequency.storeBulk');

    // NOVA ROTA: Rota para exibir o histórico de frequências de uma categoria
    Route::get('/{category}/history', [FrequencyController::class, 'showFrequencies'])->name('frequency.show');

    Route::get('/{category}/training/{training}/edit', [FrequencyController::class, 'editPendingFrequency'])->name('frequency.editPending');

});

Route::middleware('auth')->prefix('training')->group(function () {
    Route::get('/', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/create', [TrainingController::class, 'create'])->name('training.create');
    Route::post('/store', [TrainingController::class, 'store'])->name('training.store');
    Route::get('/{training}/edit', [TrainingController::class, 'edit'])->name('training.edit');
    Route::put('/{training}', [TrainingController::class, 'update'])->name('training.update');
    Route::get('/{training}/category', [TrainingController::class, 'showCategory'])->name('training.showCategory');
    Route::delete('/{training}', [TrainingController::class, 'destroy'])->name('training.destroy');
});



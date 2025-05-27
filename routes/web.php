<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function(){
    return 'joao';
});

Route::prefix()->group(function () {

});
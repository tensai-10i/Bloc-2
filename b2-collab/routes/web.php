<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ressources', [RessourcesController::class, 'index'])->name('resources.index');

Route::resource('category', CategoryController::class);

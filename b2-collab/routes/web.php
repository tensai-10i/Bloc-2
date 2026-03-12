<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/ressources', [RessourcesController::class, 'index'])->name('resources.index');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;


Route::get('/', function () {
<<<<<<< HEAD
    return view('index');
});
=======
    return view('welcome');
});

Route::get('/ressources', [RessourcesController::class, 'index'])->name('resources.index');
>>>>>>> 4a1d282dea329edb0c8042edc7b2a8ed23fa4321

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('index');
});

// Route Ressource
Route::resource('ressources', RessourcesController::class);

// Route Catégories
Route::resource('category', CategoryController::class);

// Route Pages légales
Route::get('/mentions-legales', function () {
    return view('legal.mentions');
})->name('mentions-legales');

Route::get('/cgu', function () {
    return view('legal.cgu');
})->name('cgu');

Route::get('/contact', function () {
    return view('legal.contact');
})->name('contact');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Profile Routes
Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';
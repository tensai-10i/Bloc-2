<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeRessourceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UserRoleController;

// Public pages
Route::get('/', function () {
    return view('index');
})->name('home');

// Resources  Categories TypeRessource
Route::resource('ressources', RessourcesController::class);
Route::resource('category', CategoryController::class);
Route::resource('type_ressource', TypeRessourceController::class);
// Legal and support pages
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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/gestion', 'admin.dashboard')->name('admin.dashboard');
    Route::get('/gestion/utilisateurs', [UserRoleController::class, 'index'])->name('admin.users.index');
    Route::patch('/gestion/utilisateurs/{user}/role', [UserRoleController::class, 'update'])->name('admin.users.update-role');
});

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::view('/moderation', 'moderator.dashboard')->name('moderator.dashboard');
});

// Authenticated profile management (current user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public user profile page
Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';

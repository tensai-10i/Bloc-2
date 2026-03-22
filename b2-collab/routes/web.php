<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeRessourceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserRoleController;

// Public pages
Route::get('/', function () {
    return view('index');
})->name('home');

// Legal and support pages
Route::get('/mentions-legales', fn() => view('legal.mentions'))->name('mentions-legales');
Route::get('/cgu', fn() => view('legal.cgu'))->name('cgu');
Route::get('/contact', fn() => view('legal.contact'))->name('contact');
Route::get('/support', fn() => view('support'))->name('support');

// Public user profile page
Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile.show');

// ── Auth required ────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Ressources (toutes les routes protégées)
    Route::resource('ressources', RessourcesController::class);
    Route::post('/ressources/{ressource}/comments', [CommentController::class, 'store'])
        ->name('ressources.comments.store');

    // Categories & Types
    Route::resource('category', CategoryController::class);
    Route::resource('type_ressource', TypeRessourceController::class);

    // Dashboard & Profile
    Route::get('/dashboard', fn() => view('dashboard'))->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Admin ────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/gestion', 'admin.dashboard')->name('admin.dashboard');
    Route::get('/gestion/utilisateurs', [UserRoleController::class, 'index'])->name('admin.users.index');
    Route::patch('/gestion/utilisateurs/{user}/role', [UserRoleController::class, 'update'])->name('admin.users.update-role');
});

// ── Moderator ────────────────────────────────────────────
Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::view('/moderation', 'moderator.dashboard')->name('moderator.dashboard');
});

require __DIR__.'/auth.php';

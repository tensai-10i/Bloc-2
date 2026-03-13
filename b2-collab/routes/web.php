<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // User management routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit-role', [UserController::class, 'editRole'])->name('admin.users.edit-role');
    Route::patch('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.update-role');
});

// Moderator routes
Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator', function () {
        return 'Espace Modérateur';
    })->name('moderator.dashboard');
});

// User Profile Routes
Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\RessourcesApiController;
use App\Http\Controllers\Api\TypeRessourceApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Toutes les routes ici reçoivent automatiquement le middleware "api".
| Retournent du JSON — utilisées par l'application React Native.
*/

// Auth publique
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

// Routes publiques (lecture seule)
Route::get('/ressources',              [RessourcesApiController::class, 'index']);
Route::get('/ressources/{id}',         [RessourcesApiController::class, 'show']);
Route::get('/ressources/{id}/comments',[RessourcesApiController::class, 'comments']);
Route::get('/categories',              [CategoryApiController::class, 'index']);
Route::get('/categories/{id}',         [CategoryApiController::class, 'show']);
Route::get('/types-ressources',        [TypeRessourceApiController::class, 'index']);
Route::get('/types-ressources/{id}',   [TypeRessourceApiController::class, 'show']);

// Routes protégées par token Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me',      [AuthController::class, 'me']);
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail']);
    Route::get('/users',        [AuthController::class, 'users']);
    Route::put('/users/{id}/role', [AuthController::class, 'updateUserRole']);

    // Ressources (écriture)
    Route::post('/ressources',           [RessourcesApiController::class, 'store']);
    Route::put('/ressources/{id}',       [RessourcesApiController::class, 'update']);
    Route::delete('/ressources/{id}',    [RessourcesApiController::class, 'destroy']);
    Route::post('/ressources/{id}/moderate', [RessourcesApiController::class, 'moderate']);
    Route::post('/ressources/{id}/comments', [RessourcesApiController::class, 'addComment']);

    // Catégories (écriture)
    Route::post('/categories',           [CategoryApiController::class, 'store']);
    Route::put('/categories/{id}',       [CategoryApiController::class, 'update']);
    Route::delete('/categories/{id}',    [CategoryApiController::class, 'destroy']);
});

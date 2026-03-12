<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('index');
});


Route::get('ressources', [RessourcesController::class, 'index'])
    ->name('ressources.index');

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

Route::resource('category', CategoryController::class);

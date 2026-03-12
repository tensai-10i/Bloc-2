<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/mentions-legales', function () {
    return view('legal.mentions');
})->name('mentions-legales');

Route::get('/cgu', function () {
    return view('legal.cgu');
})->name('cgu');

Route::get('/contact', function () {
    return view('legal.contact');
})->name('contact');
<?php

use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::name('auth.')->group(function () {
    Route::view('/login', 'pages.auth.login')->name('login');
    Route::view('/register', 'pages.auth.register')->name('register');
});

// Profile routes (authenticated)
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::view('/', 'pages.profile')->name('view');
    Route::put('/update', fn() => '')->name('update');
    Route::delete('/delete', fn() => '')->name('delete');
});

// Role request (authenticated)
Route::prefix('role/request')->name('role.')->middleware('auth')->group(function () {
    Route::put('/speaker', fn() => '')->name('to-speaker');
    Route::put('/organizer', fn() => '')->name('to-organizer');
    Route::put('/user', fn() => '')->name('to-user');
});

// Fallback route
Route::fallback(fn() => view('pages.not-found'))->name('not-found');

// Route Modules
require __DIR__ . '/user.php';
require __DIR__ . '/speaker.php';
require __DIR__ . '/organizer.php';

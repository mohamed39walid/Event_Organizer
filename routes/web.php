<?php

use Illuminate\Support\Facades\Route;

// Auth routes (login/register)
Route::view('/login', 'pages.auth.login')->name('login');
Route::view('/register', 'pages.auth.register')->name('register');

// Profile management (only for authenticated users)
Route::prefix('profile')->name(value: 'profile.')->middleware('auth')->group(function () {
    Route::view('/', 'pages.shared.profile')->name('view');
    Route::put('/update', fn() => '')->name('update');
    Route::delete('/delete', fn() => '')->name('delete');
});

// Role change requests (authenticated users only)
Route::prefix('role/request')->name('role.')->middleware('auth')->group(function () {
    Route::put('/speaker', fn() => '')->name('to-speaker');
    Route::put('/organizer', fn() => '')->name('to-organizer');
    Route::put('/user', fn() => '')->name('to-user');
});

Route::view('/my-tickets', 'pages.user.my-tickets')->name('my-tickets');
Route::view('/events', 'pages.shared.events')->name('events');
Route::view('/home', 'pages.shared.home')->name('home');

// Fallback route for 404 not found
Route::fallback(fn() => view('pages.shared.not-found'))->name('not-found');

// Include route groups
require __DIR__ . '/user.php';
require __DIR__ . '/speaker.php';
require __DIR__ . '/organizer.php';




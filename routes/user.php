<?php

use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'user' role
Route::middleware(app()->environment('local') ? [] : ['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // Ticket booking actions
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::post('/book', fn() => view('pages.user.book-ticket'))->name('book');
        Route::delete('/{id}/unbook', fn() => '')->name('unbook');
    });

    // User views
    Route::view('/my-tickets', 'pages.user.my-tickets')->name('my-tickets');
    Route::view('/events', 'pages.shared.events')->name('events');
    Route::view('/home', 'pages.shared.home')->name('home');
});

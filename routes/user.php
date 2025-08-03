<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::post('/book', fn() => view('pages.book-ticket'))->name('book');
        Route::delete('/{id}/unbook', fn() => '')->name('unbook');
    });

    Route::view('/my-tickets', 'pages.my-tickets')->name('my-tickets');
    Route::view('/events', 'pages.events')->name('events');
    Route::view('/', 'pages.home')->name('home');
});

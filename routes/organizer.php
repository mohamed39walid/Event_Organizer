<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {

    // Event Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', fn() => '')->name('index');
        Route::post('/', fn() => '')->name('store');
        Route::put('/{id}', fn() => '')->name('update');
        Route::delete('/{id}', fn() => '')->name('destroy');

        // Related to individual events
        Route::get('/{id}/tickets', fn() => '')->name('tickets');
        Route::get('/{id}/proposals', fn() => '')->name('proposals');
        Route::post('/{id}/sessions', fn() => view('pages.organizer.event-sessions'))->name('sessions');
    });

    // Proposal Moderation
    Route::prefix('proposals')->name('proposals.')->group(function () {
        Route::put('/{id}/approve', fn() => '')->name('approve');
        Route::put('/{id}/reject', fn() => '')->name('reject');
    });

    // Misc
    Route::view('/review-proposals', 'pages.organizer.review-proposals')->name('review-proposals');
});

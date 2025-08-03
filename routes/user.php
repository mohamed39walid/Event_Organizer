<?php

use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'user' role
Route::middleware(app()->environment('local') ? [] : ['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // Ticket booking actions
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::post('/{id}/book', function ($id) {
            return redirect()->back()->with('success', 'Booked Successfully');
        })->name('book');

        Route::delete('/{id}/unbook', fn() => '')->name('unbook');
    });
});

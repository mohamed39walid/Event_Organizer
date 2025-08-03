<?php

use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'organizer' role
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {

    // Event management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', fn() => '')->name('index');                              // List all events
        Route::post('/', fn() => '')->name('store');                             // Create event
        Route::put('/{id}', fn() => '')->name('update');                         // Update event
        Route::delete('/{id}', fn() => '')->name('destroy');                     // Delete event
        Route::get('/{id}/tickets', fn() => '')->name('tickets');                // View event tickets
        Route::get('/{id}/proposals', fn() => '')->name('proposals');            // View proposals for event
        Route::post('/{id}/sessions', fn() => view('pages.organizer.event-sessions'))->name('sessions'); // Manage sessions
    });

    // Proposal review actions
    Route::prefix('proposals')->name('proposals.')->group(function () {
        Route::put('/{id}/approve', fn() => '')->name('approve');               // Approve a proposal
        Route::put('/{id}/reject', fn() => '')->name('reject');                 // Reject a proposal
    });

    // View for reviewing all proposals
    Route::view('/review-proposals', 'pages.organizer.review-proposals')->name('review-proposals');
});

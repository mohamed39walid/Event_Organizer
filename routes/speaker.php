<?php

use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'speaker' role
Route::middleware(app()->environment('local') ? [] : ['auth', 'role:speaker'])->prefix('speaker')->name('speaker.')->group(function () {

    // Proposal management for speakers
    Route::prefix('proposals')->name('proposals.')->group(function () {
        Route::get('/', fn() => view('pages.proposals'))->name('index');         // View proposals
        Route::post('/', fn() => view('pages.proposals'))->name('create');       // Submit new proposal
        Route::delete('/{id}', fn() => '')->name('delete');                      // Delete proposal
    });
});

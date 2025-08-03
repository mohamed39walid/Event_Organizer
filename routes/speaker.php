<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:speaker'])->group(function () {
    Route::view('/speaker/dashboard', 'speaker.dashboard')->name('speaker.dashboard');
    Route::view('/speaker/proposals', 'speaker.proposals')->name('speaker.proposals');
});

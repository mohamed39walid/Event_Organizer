<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:organizer'])->group(function () {
    Route::view('/organizer/dashboard', 'organizer.dashboard')->name('organizer.dashboard');
    Route::view('/organizer/review-proposals', 'organizer.review-proposals')->name('organizer.review-proposals');
});

<?php

use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

// Auth routes (login/register)

// Profile management (only for authenticated users)
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::view('/', 'pages.shared.profile')->name('view');
    Route::put('/update',  [UserController::class, 'update'])->name('update');
    Route::delete('/delete', [UserController::class, 'destroy'])->name('delete');
});

// Role change requests (authenticated users only)
Route::prefix('role/request')->name('role.')->middleware('auth')->group(function () {
    Route::put('/speaker', fn() => '')->name('to-speaker');
    Route::put('/organizer', fn() => '')->name('to-organizer');
    Route::put('/user', fn() => '')->name('to-user');
});


Route::get('/event', [OrganizerController::class, 'events'])->name('events');
Route::get('/{id}/event', [OrganizerController::class, 'eventDetails'])->name('event-details');
Route::get('/', [OrganizerController::class, 'homeEvents'])->name('home');

// Fallback route for 404 not found
Route::get('/not-found', fn() => view('pages.shared.not-found'))->name('not-found');
Route::fallback(function () {
    return redirect()->route('not-found');
});

// Include route groups
require __DIR__ . '/user.php';
require __DIR__ . '/speaker.php';
require __DIR__ . '/organizer.php';

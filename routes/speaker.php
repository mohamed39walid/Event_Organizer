<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:speaker'])->prefix('speaker')->name('speaker.')->group(function () {

    Route::prefix('proposals')->name('proposals.')->group(function () {
        Route::get('/', fn() => view('pages.speaker.proposals'))->name('index');
        Route::post('/', fn() => view('pages.speaker.proposals'))->name('create');
        Route::delete('/{id}', fn() => '')->name('delete');
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('pages.not-found');
});
    
Route::get('/test-success', function () {
    return redirect('/')->with('success', 'Test success message!');
});

Route::get('/test-error', function () {
    return redirect('/')->with('error', 'Test error message!');
});

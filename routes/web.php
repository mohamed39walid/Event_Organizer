<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('pages.not-found');
})->name('not-found');

Route::get('/test-success', function () {
return redirect('/')->with('success', 'Test success message!');
})->name('test-success');

Route::get('/test-error', function () {
    return redirect('/')->with('error', 'Test error message!');
})->name('test-error');


Route::get('/login', function () {
    return view(view: 'auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/my-events', function () {
    return view('pages.my-events');
})->name('my-events');

Route::get('/events', function () {
    return view('pages.events');
})->name('events');

Route::get('/my-tickets', function () {
    return view('pages.my-tickets');
})->name('my-tickets');

Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

Route::get('/proposals', function () {
    return view('pages.proposals');
})->name('proposals');

Route::get('/create-proposal', function () {
    return view('pages.create-proposal');
})->name('create-proposal');

Route::get('/choose-speakers', function () {
    return view('pages.choose-speakers');
})->name('choose-speakers');

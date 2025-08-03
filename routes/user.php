<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'pages.auth.login')->name('login');
Route::view('/register', 'pages.auth.register')->name('register');
Route::view('/', 'pages.home')->name('home');
Route::view('/events', 'pages.events')->name('events');
Route::view('/my-tickets', 'pages.my-tickets')->middleware(['auth', 'role:user'])->name('my-tickets');

Route::fallback(fn() => view('pages.not-found'))->name('not-found');

<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'user' role
Route::controller(UserController::class)->middleware("guest")->group(function () {
    Route::get("/register", "register")->name("register");
    Route::post("/register", "handleregister")->name("handleregister");
    Route::get("/login", "login")->name("login");
    Route::post("/login", "handlelogin")->name("handlelogin");
});
Route::controller(UserController::class)->middleware("auth")->group(function () {
    Route::post("/logout", "logout")->name("logout");
});
Route::middleware(app()->environment('local') ? [] : ['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {


    // Ticket booking actions
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::post('/{id}/book', function ($id) {
            return redirect()->back()->with('success', 'Booked Successfully');
        })->name('book');

        Route::delete('/{id}/unbook', fn() => '')->name('unbook');
    });
});

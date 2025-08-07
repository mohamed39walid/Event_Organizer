<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// // Routes accessible only by users with the 'user' role
// Route::controller(UserController::class)->middleware("guest")->group(function () {
//     Route::get("/register", "register")->name("register");
//     Route::post("/register", "handleregister")->name("handleregister");
//     Route::get("/login", "login")->name("login");
//     Route::post("/login", "handlelogin")->name("handlelogin");
// });
// Route::controller(UserController::class)->middleware("auth")->group(function () {
//     Route::post("/logout", "logout")->name("logout");
// });
// // Route::middleware(app()->environment('local') ? [] : ['auth', 'role:user', 'role:speaker'])->prefix('user')->name('user.')->group(function () {

    
// // });
// Route::prefix('tickets')->name('tickets.')->group(function () {
//     Route::controller(TicketController::class)->middleware(["auth","role:user,speaker"])->group(function (){
//         Route::post("/book/{id}","BookTicket")->name("BookTicket");
//         Route::delete('unbook/{id}', "UnBookTicket")->name('UnBookTicket');
//         Route::get("/my-tickets","mytickets")->name("my-tickets");
//     });
// });

// Routes accessible only by guests
Route::controller(UserController::class)->middleware("guest")->group(function () {
    Route::get("/register", "register")->name("register");
    Route::post("/register", "handleregister")->name("handleregister");
    Route::get("/login", "login")->name("login");
    Route::post("/login", "handlelogin")->name("handlelogin");
});

// Routes accessible only by authenticated users - ADD PREVENT-BACK-HISTORY HERE
Route::controller(UserController::class)->middleware(["auth", "prevent-back-history"])->group(function () {
    Route::post("/logout", "logout")->name("logout");
});

// Ticket routes - ADD PREVENT-BACK-HISTORY HERE TOO
Route::prefix('tickets')->name('tickets.')->group(function () {
    Route::controller(TicketController::class)->middleware(["auth", "role:user,speaker", "prevent-back-history"])->group(function () {
        Route::post("/book/{id}", "BookTicket")->name("BookTicket");
        Route::delete('unbook/{id}', "UnBookTicket")->name('UnBookTicket');
        Route::get("/my-tickets", "mytickets")->name("my-tickets");
    });
});
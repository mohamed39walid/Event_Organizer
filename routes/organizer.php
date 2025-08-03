<?php

use App\Http\Controllers\OrganizerController;
use App\Http\Requests\OrganizerForm;
use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'organizer' role
// Route::middleware(app()->environment('local') ? [] : ['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {

// Event management
Route::prefix('events')->name('events.')->group(function () {

    //  Form Events Routes
    Route::get('/createevent', [OrganizerController::class, 'CreateEvent'])->name('CreateEvent');   //Event Form
    Route::post('/storeevent', [OrganizerController::class, 'StoreEvent'])->name('StoreEvent');     // Store event

    //  Edit Events Routes
    Route::get('/editevent', [OrganizerController::class, 'EditEvent'])->name('EditEvent');     // Edit Event Form
    Route::put('/{id}', [OrganizerController::class, 'UpdateEvent'])->name('UpdateEvent');      // Update event

    // Delete Route
    Route::delete('/{id}', [OrganizerController::class, 'DeleteEvent'])->name('destroy');       // Delete event

    Route::get('/{id}/tickets', fn() => '')->name('tickets');                                       // View event tickets
    Route::get('/{id}/proposals', fn() => '')->name('proposals');                                   // View proposals for event
    Route::post('/{id}/sessions', fn() => view('pages.organizer.event-sessions'))->name('sessions'); // Manage sessions
});

// Proposal review actions
Route::prefix('proposals')->name('proposals.')->group(function () {
    Route::put('/{id}/approve', fn() => '')->name('approve');               // Approve a proposal
    Route::put('/{id}/reject', fn() => '')->name('reject');                 // Reject a proposal
});

// View for reviewing all proposals
Route::view('/review-proposals', 'pages.organizer.review-proposals')->name('review-proposals');
// });

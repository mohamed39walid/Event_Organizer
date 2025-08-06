
<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProposalsController;
use App\Http\Requests\OrganizerForm;
use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'organizer' role
// Route::middleware(app()->environment('local') ? [] : ['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {

// Event management
Route::get('/my-events', [OrganizerController::class, 'OrganizerEvents'])->name('organizer-events');               // List all events
Route::prefix('events')->name('events.')->group(function () {


    //  Form Events Routes
    Route::get('/createevent', [EventController::class, 'CreateEvent'])->name('create-event');   //Event Form
    Route::post('/storeevent', [EventController::class, 'StoreEvent'])->name('store-event');

    //  Edit Events Routes
    Route::put('/{id}', [EventController::class, 'UpdateEvent'])->name('update-event');      // Update event

    // Delete Route
    Route::delete('/{id}', [EventController::class, 'DeleteEvent'])->name('destroy');       // Delete event

    Route::get('/{id}/tickets', fn() => '')->name('tickets');                                       // View event tickets
    Route::post('/{id}/sessions', fn() => view('pages.organizer.event-sessions'))->name('sessions'); // Manage sessions
    Route::get('/{id}/proposals', [OrganizerController::class, 'SpecificProposal'])->name('proposals');                                   // View proposals for event

    // Proposal review actions
    Route::prefix('proposals')->name('proposals.')->group(function () {
        Route::put('/{id}/approve', [ProposalsController::class, 'AcceptProposal'])->name('approve');    // Approve a proposal
        Route::put('/{id}/reject', [ProposalsController::class, 'RejectProposal'])->name('reject');                 // Reject a proposal
    });
});


    // View for reviewing all proposals
    // Route::get('/proposals', [ProposalsController::class, 'AllProposals'])->name('review-proposals');
// });

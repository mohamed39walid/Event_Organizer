
<?php

use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProposalsController;
use App\Http\Requests\OrganizerForm;
use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'organizer' role
// Route::middleware(app()->environment('local') ? [] : ['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {

    // Event management
    Route::prefix('events')->name('events.')->group(function () {
        // View Event Route
        // Route::get('/', [OrganizerController::class, 'OrganizerEvents'])->name('events');               // List all events

        //  Form Events Routes
        Route::get('/createevent', [OrganizerController::class, 'CreateEvent'])->name('CreateEvent');   //Event Form                             
        Route::post('/storeevent', [OrganizerController::class, 'StoreEvent'])->name('StoreEvent');     // Store event

        //  Edit Events Routes
        Route::get('/editevent', [OrganizerController::class, 'EditEvent'])->name('EditEvent');     // Edit Event Form
        Route::put('/{id}', [OrganizerController::class, 'UpdateEvent'])->name('UpdateEvent');      // Update event

        // Delete Route
        Route::delete('/{id}', [OrganizerController::class, 'DeleteEvent'])->name('destroy');       // Delete event

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

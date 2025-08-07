<?php

use App\Http\Controllers\ProposalsController;
use Illuminate\Support\Facades\Route;

// Routes accessible only by users with the 'speaker' role
// Route::middleware(app()->environment('local') ? [] : ['auth', 'role:speaker'])->prefix('speaker')->name('speaker.')->group(function () {

//     // Proposal management for speakers
//     Route::prefix('proposals')->name('proposals.')->group(function () {
//         Route::get('/', fn() => view('pages.proposals'))->name('index');         // View proposals
//         Route::post('/', fn() => view('pages.proposals'))->name('create');       // Submit new proposal
//         Route::delete('/{id}', fn() => '')->name('delete');                      // Delete proposal
//     });
// });


 
Route::controller(ProposalsController::class)->name("speaker.")->middleware("role:speaker")->group(function () {
    Route::get("/my-proposals", "GetSpeakerProposals")->name("my-proposals");
    Route::post("/proposal/{id}", "CreateProposal")->name("createproposal"); //the id here is event id
    Route::delete("/deleteproposal/{id}", "DeleteProposal")->name("deleteproposal"); //the id here is proposal id
});

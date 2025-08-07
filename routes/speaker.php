<?php

use App\Http\Controllers\ProposalsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:speaker','prevent-back-history'])
->controller(ProposalsController::class)->name("speaker.")->prefix("proposals")->group(function () {

    Route::get("/my-proposals", "GetSpeakerProposals")->name("my-proposals");
    Route::post("/proposal/{id}", "CreateProposal")->name("createproposal");
    Route::delete("/deleteproposal/{id}", "DeleteProposal")->name("deleteproposal");
});

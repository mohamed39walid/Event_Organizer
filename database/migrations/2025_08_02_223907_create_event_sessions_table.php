<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("event_id");
            $table->unsignedBigInteger("speaker_id");
            $table->unsignedBigInteger("proposal_id");
            $table->dateTime("start_date");
            $table->dateTime("end_date");

            //realtions
            $table->foreign("event_id")->references("id")->on("events")->onUpdate('cascade')->onDelete("cascade");
            $table->foreign("speaker_id")->references("id")->on("users")->onUpdate('cascade')->onDelete("cascade");
            $table->foreign("proposal_id")->references("id")->on("proposals")->onUpdate('cascade')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_sessions');
    }
};

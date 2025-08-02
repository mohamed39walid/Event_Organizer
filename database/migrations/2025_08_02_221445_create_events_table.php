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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("event_name");
            $table->string("location");
            $table->dateTime("start_date");
            $table->dateTime("end_date");
            $table->integer("available_tickets");
            $table->string("status");
            $table->unsignedBigInteger("organizer_id");
            $table->foreign("organizer_id")->references("id")->on("users")->onUpdate('cascade')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

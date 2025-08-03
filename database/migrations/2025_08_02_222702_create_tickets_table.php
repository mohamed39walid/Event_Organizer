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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->enum("checked_in",['no','yes']);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("event_id");

            //realtions
            $table->foreign("user_id")->references("id")->on("users")->onUpdate('cascade')->onDelete("cascade");
            $table->foreign("event_id")->references("id")->on("events")->onUpdate('cascade')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("cv");
            $table->enum("status",['pending','rejected','approved']);
            $table->unsignedBigInteger("speaker_id");
            $table->unsignedBigInteger("event_id");
            $table->foreign("speaker_id")->references("id")->on("users")->onUpdate('cascade')->onDelete("cascade");
            $table->foreign("event_id")->references("id")->on("events")->onUpdate('cascade')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};

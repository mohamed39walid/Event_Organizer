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
        Schema::table('events', function (Blueprint $table) {
            // Add latitude and longitude columns
            $table->decimal('latitude', 10, 8)->nullable()->after('event_name');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Reverse the changes
            $table->string('location')->nullable()->after('event_name');
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};

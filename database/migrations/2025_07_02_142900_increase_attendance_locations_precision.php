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
        Schema::table('attendance_locations', function (Blueprint $table) {
            // Increase precision for GPS coordinates
            // From decimal(10,8) to decimal(15,12) for latitude
            // From decimal(11,8) to decimal(15,12) for longitude
            $table->decimal('latitude', 15, 12)->change();
            $table->decimal('longitude', 15, 12)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_locations', function (Blueprint $table) {
            // Revert back to original precision
            $table->decimal('latitude', 10, 8)->change();
            $table->decimal('longitude', 11, 8)->change();
        });
    }
}; 
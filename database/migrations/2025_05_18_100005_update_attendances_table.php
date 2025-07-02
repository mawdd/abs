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
        Schema::table('attendances', function (Blueprint $table) {
            $table->boolean('check_in_location_valid')->default(false)->after('check_in_location');
            $table->boolean('check_out_location_valid')->default(false)->after('check_out_location');
            $table->boolean('is_holiday')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['check_in_location_valid', 'check_out_location_valid', 'is_holiday']);
        });
    }
}; 
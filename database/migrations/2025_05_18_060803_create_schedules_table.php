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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('day_of_week'); // 0 (Sunday) - 6 (Saturday)
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_exception')->default(false); // For non-recurring schedules
            $table->date('exception_date')->nullable(); // Date for exceptions
            $table->timestamps();

            // Ensure one regular schedule per teacher per day of week
            $table->unique(['user_id', 'day_of_week', 'is_exception', 'exception_date'], 'unique_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

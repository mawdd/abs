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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->json('check_in_location')->nullable(); // latitude, longitude data
            $table->json('check_out_location')->nullable(); // latitude, longitude data
            $table->string('check_in_device_info')->nullable();
            $table->string('check_out_device_info')->nullable();
            $table->string('status')->default('pending'); // pending, present, late, absent
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure one record per user per day
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

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
        Schema::create('teaching_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_room_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->datetime('start_time');
            $table->datetime('end_time')->nullable();
            $table->json('start_location')->nullable(); // GPS coordinates
            $table->json('end_location')->nullable(); // GPS coordinates
            $table->boolean('start_location_valid')->default(false);
            $table->boolean('end_location_valid')->default(false);
            $table->string('start_device_info')->nullable();
            $table->string('end_device_info')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_sessions');
    }
}; 
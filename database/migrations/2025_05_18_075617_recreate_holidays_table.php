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
        // Drop the existing holidays table
        Schema::dropIfExists('holidays');
        
        // Create a new holidays table with the correct structure
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->text('description')->nullable();
            $table->date('date');
            $table->boolean('is_recurring')->default(false);
            $table->boolean('is_national_holiday')->default(true);
            $table->timestamps();
            
            // Add a unique constraint to prevent duplicate holidays on the same date
            $table->unique(['date', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};

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
        // First drop the foreign key constraint
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropForeign('holidays_created_by_foreign');
        });
        
        Schema::table('holidays', function (Blueprint $table) {
            // Drop the unique constraint on date
            $table->dropUnique('holidays_date_unique');
            
            // Rename 'name' to 'title'
            $table->renameColumn('name', 'title');
            
            // Drop columns that are no longer needed
            $table->dropColumn(['type', 'is_active', 'created_by']);
            
            // Add new columns
            $table->boolean('is_recurring')->default(false)->after('description');
            $table->boolean('is_national_holiday')->default(true)->after('is_recurring');
            
            // Add a new unique constraint
            $table->unique(['date', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('holidays', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique('holidays_date_title_unique');
            
            // Rename 'title' back to 'name'
            $table->renameColumn('title', 'name');
            
            // Drop the new columns
            $table->dropColumn(['is_recurring', 'is_national_holiday']);
            
            // Add back the old columns
            $table->enum('type', ['national', 'school', 'special_event'])->default('school');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable();
            
            // Add back the unique constraint on date
            $table->unique('date');
        });
    }
};

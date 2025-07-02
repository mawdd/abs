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
        Schema::table('teacher_profiles', function (Blueprint $table) {
            // Tambahkan kolom qualification jika belum ada
            if (!Schema::hasColumn('teacher_profiles', 'qualification')) {
                $table->string('qualification')->nullable()->after('user_id');
            }
            
            // Pastikan kolom-kolom lain yang diperlukan juga ada
            if (!Schema::hasColumn('teacher_profiles', 'bio')) {
                $table->text('bio')->nullable()->after('qualification');
            }
            
            if (!Schema::hasColumn('teacher_profiles', 'specialization')) {
                $table->string('specialization')->nullable()->after('bio');
            }
            
            if (!Schema::hasColumn('teacher_profiles', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('specialization');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_profiles', function (Blueprint $table) {
            // Kita tidak hapus kolom-kolom ini karena mungkin diperlukan oleh bagian lain aplikasi
        });
    }
};

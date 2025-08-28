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
        Schema::table('employees', function (Blueprint $table) {
            $table->boolean('is_job_seeker')->default(false)->after('user_id');
            $table->boolean('profile_completed')->default(false)->after('is_job_seeker');
            
            // Performance indexes
            $table->index('is_job_seeker');
            $table->index('profile_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['is_job_seeker']);
            $table->dropIndex(['profile_completed']);
            $table->dropColumn(['is_job_seeker', 'profile_completed']);
        });
    }
};

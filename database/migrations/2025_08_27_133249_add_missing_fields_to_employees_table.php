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
            $table->text('skills')->nullable()->after('position');
            $table->enum('experience_level', ['entry', 'mid_level', 'senior', 'expert'])->nullable()->after('skills');
            $table->enum('preferred_work_type', ['full_time', 'part_time', 'contract', 'freelance'])->nullable()->after('experience_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['skills', 'experience_level', 'preferred_work_type']);
        });
    }
};

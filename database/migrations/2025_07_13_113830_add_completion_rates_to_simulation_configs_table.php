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
        Schema::table('simulation_configs', function (Blueprint $table) {
            $table->integer('completion_rate')->default(70)->after('auto_complete'); // 70% completion
            $table->integer('in_progress_rate')->default(20)->after('completion_rate'); // 20% in progress
            $table->integer('comment_only_rate')->default(10)->after('in_progress_rate'); // 10% comment only
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('simulation_configs', function (Blueprint $table) {
            $table->dropColumn(['completion_rate', 'in_progress_rate', 'comment_only_rate']);
        });
    }
};

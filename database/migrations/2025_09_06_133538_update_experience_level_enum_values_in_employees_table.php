<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add a temporary column to store the new values
        Schema::table('employees', function (Blueprint $table) {
            $table->string('experience_level_temp')->nullable()->after('experience_level');
        });

        // Map old values to new values in the temporary column
        DB::table('employees')->where('experience_level', 'entry')->update(['experience_level_temp' => 'none']);
        DB::table('employees')->where('experience_level', 'mid_level')->update(['experience_level_temp' => '3_5_years']);
        DB::table('employees')->where('experience_level', 'senior')->update(['experience_level_temp' => '5_plus_years']);
        DB::table('employees')->where('experience_level', 'expert')->update(['experience_level_temp' => '5_plus_years']);

        // Drop the old column and rename the temp column
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('experience_level');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('experience_level', ['none', '1_3_years', '3_5_years', '5_plus_years'])->nullable()->after('skills');
        });

        // Copy data from temp column to new column
        DB::table('employees')->update(['experience_level' => DB::raw('experience_level_temp')]);

        // Drop the temporary column
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('experience_level_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add temporary column for old values
        Schema::table('employees', function (Blueprint $table) {
            $table->string('experience_level_temp')->nullable()->after('experience_level');
        });

        // Map new values back to old values
        DB::table('employees')->where('experience_level', 'none')->update(['experience_level_temp' => 'entry']);
        DB::table('employees')->where('experience_level', '1_3_years')->update(['experience_level_temp' => 'entry']);
        DB::table('employees')->where('experience_level', '3_5_years')->update(['experience_level_temp' => 'mid_level']);
        DB::table('employees')->where('experience_level', '5_plus_years')->update(['experience_level_temp' => 'senior']);

        // Drop new column and recreate with old enum values
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('experience_level');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('experience_level', ['entry', 'mid_level', 'senior', 'expert'])->nullable()->after('skills');
        });

        // Copy data back
        DB::table('employees')->update(['experience_level' => DB::raw('experience_level_temp')]);

        // Drop temporary column
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('experience_level_temp');
        });
    }
};

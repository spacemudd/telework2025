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
        // Create pivot table
        Schema::create('company_user', function (Blueprint $table) {
            $table->id();
            $table->string('company_id', 36); // UUID length
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['owner', 'admin', 'member'])->default('owner');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            
            $table->unique(['company_id', 'user_id']);
            $table->index(['user_id', 'is_primary']);
            $table->index(['company_id', 'role']);
            
            // Add foreign key constraint for company_id
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        // Add new fields to companies table
        Schema::table('companies', function (Blueprint $table) {
            $table->string('owner_email')->nullable()->after('email');
            $table->boolean('migration_completed')->default(false)->after('owner_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove new fields from companies table
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['owner_email', 'migration_completed']);
        });

        // Drop pivot table
        Schema::dropIfExists('company_user');
    }
};

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
        Schema::create('employee_talent_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('employee_id');
            $table->unsignedBigInteger('talent_category_id');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('talent_category_id')->references('id')->on('talent_categories')->onDelete('cascade');
            
            // Performance indexes
            $table->index('employee_id');
            $table->index('talent_category_id');
            $table->unique(['employee_id', 'talent_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_talent_categories');
    }
};

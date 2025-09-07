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
        Schema::create('talent_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 255);
            $table->string('name_en', 255);
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('icon', 100);
            $table->string('color', 7);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_categories');
    }
};

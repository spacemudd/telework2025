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
        Schema::create('company_audit_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id');
            $table->string('recipient_email');
            $table->string('subject')->nullable();
            $table->text('body_snippet')->nullable();
            $table->string('status')->default('sent'); // e.g., sent, failed
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_audit_records');
    }
};

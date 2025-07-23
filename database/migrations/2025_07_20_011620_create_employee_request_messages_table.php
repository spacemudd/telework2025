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
        Schema::create('employee_request_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_request_id');
            $table->morphs('sender'); // adds sender_type and sender_id
            $table->text('message');
            $table->timestamps();

            $table->foreign('employee_request_id')->references('id')->on('employee_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_request_messages');
    }
};

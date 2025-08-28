<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('interview_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->text('question_text_ar')->nullable();
            $table->integer('question_order');
            $table->string('response_audio_url')->nullable();
            $table->text('response_text')->nullable();
            $table->integer('recording_duration')->nullable(); // in seconds
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_questions');
    }
};

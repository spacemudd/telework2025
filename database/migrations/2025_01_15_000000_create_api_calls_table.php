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
        Schema::create('api_calls', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->nullable();
            $table->string('api_provider')->default('openai'); // openai, anthropic, etc.
            $table->string('endpoint'); // task_generation, response_generation, etc.
            $table->string('model')->nullable(); // gpt-4, gpt-3.5-turbo, etc.
            $table->integer('tokens_used');
            $table->decimal('cost_per_token', 10, 8);
            $table->decimal('total_cost', 10, 4);
            $table->text('request_prompt')->nullable();
            $table->text('response_content')->nullable();
            $table->json('metadata')->nullable(); // Additional data like temperature, max_tokens, etc.
            $table->string('status')->default('success'); // success, failed, rate_limited, etc.
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'created_at']);
            $table->index(['api_provider', 'created_at']);
            $table->index(['endpoint', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_calls');
    }
}; 
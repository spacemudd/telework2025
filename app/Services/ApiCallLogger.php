<?php

namespace App\Services;

use App\Models\ApiCall;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class ApiCallLogger
{
    /**
     * Log an API call with cost calculation
     */
    public static function log(
        Company $company,
        string $endpoint,
        int $tokensUsed,
        string $model = 'gpt-3.5-turbo',
        string $apiProvider = 'openai',
        ?string $requestPrompt = null,
        ?string $responseContent = null,
        array $metadata = [],
        string $status = 'success',
        ?string $errorMessage = null
    ): ApiCall {
        // Calculate cost based on model and tokens
        $costPerToken = self::getCostPerToken($model, $apiProvider);
        $totalCost = $tokensUsed * $costPerToken;

        try {
            $apiCall = ApiCall::create([
                'company_id' => $company->id,
                'api_provider' => $apiProvider,
                'endpoint' => $endpoint,
                'model' => $model,
                'tokens_used' => $tokensUsed,
                'cost_per_token' => $costPerToken,
                'total_cost' => $totalCost,
                'request_prompt' => $requestPrompt,
                'response_content' => $responseContent,
                'metadata' => $metadata,
                'status' => $status,
                'error_message' => $errorMessage,
            ]);

            Log::info('API call logged', [
                'company_id' => $company->id,
                'company_name' => $company->name,
                'endpoint' => $endpoint,
                'tokens_used' => $tokensUsed,
                'total_cost' => $totalCost,
                'model' => $model,
            ]);

            return $apiCall;
        } catch (\Exception $e) {
            Log::error('Failed to log API call', [
                'company_id' => $company->id,
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Get cost per token based on model and provider
     */
    private static function getCostPerToken(string $model, string $provider): float
    {
        $costs = [
            'openai' => [
                'gpt-4' => 0.03 / 1000, // $0.03 per 1K tokens
                'gpt-4-turbo' => 0.01 / 1000, // $0.01 per 1K tokens (input only - this is simplified)
                'gpt-3.5-turbo' => 0.0015 / 1000, // $0.50 input + $1.50 output per 1M tokens (averaged)
                'gpt-3.5-turbo-16k' => 0.003 / 1000, // $0.003 per 1K tokens
            ],
            'anthropic' => [
                'claude-3-opus' => 0.015 / 1000, // $0.015 per 1K tokens
                'claude-3-sonnet' => 0.003 / 1000, // $0.003 per 1K tokens
                'claude-3-haiku' => 0.00025 / 1000, // $0.00025 per 1K tokens
            ],
        ];

        return $costs[$provider][$model] ?? 0.002 / 1000; // Default to GPT-3.5 pricing
    }

    /**
     * Log a task generation API call
     */
    public static function logTaskGeneration(
        Company $company,
        int $tokensUsed,
        string $model = 'gpt-3.5-turbo',
        ?string $requestPrompt = null,
        ?string $responseContent = null,
        array $metadata = []
    ): ApiCall {
        return self::log(
            company: $company,
            endpoint: 'task_generation',
            tokensUsed: $tokensUsed,
            model: $model,
            requestPrompt: $requestPrompt,
            responseContent: $responseContent,
            metadata: $metadata
        );
    }

    /**
     * Log a response generation API call
     */
    public static function logResponseGeneration(
        Company $company,
        int $tokensUsed,
        string $model = 'gpt-3.5-turbo',
        ?string $requestPrompt = null,
        ?string $responseContent = null,
        array $metadata = []
    ): ApiCall {
        return self::log(
            company: $company,
            endpoint: 'response_generation',
            tokensUsed: $tokensUsed,
            model: $model,
            requestPrompt: $requestPrompt,
            responseContent: $responseContent,
            metadata: $metadata
        );
    }

    /**
     * Log a failed API call
     */
    public static function logFailedCall(
        Company $company,
        string $endpoint,
        string $errorMessage,
        string $model = 'gpt-3.5-turbo',
        array $metadata = []
    ): ApiCall {
        return self::log(
            company: $company,
            endpoint: $endpoint,
            tokensUsed: 0,
            model: $model,
            metadata: $metadata,
            status: 'failed',
            errorMessage: $errorMessage
        );
    }
} 
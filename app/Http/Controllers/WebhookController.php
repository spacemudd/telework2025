<?php

namespace App\Http\Controllers;

use App\Models\EmailEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleResendWebhook(Request $request)
    {
        $payload = $request->all();
        
        try {
            // Extract company_id from tags
            $tags = $payload['tags'] ?? [];
            $companyId = null;
            foreach ($tags as $tag) {
                if (str_starts_with($tag, 'company_id:')) {
                    $companyId = (int) substr($tag, 11);
                    break;
                }
            }

            if (!$companyId) {
                Log::warning('Received Resend webhook without company_id tag', ['payload' => $payload]);
                return response()->json(['message' => 'No company_id found in tags'], 400);
            }

            EmailEvent::create([
                'company_id' => $companyId,
                'email_id' => $payload['email_id'],
                'event' => $payload['type'],
                'email_to' => $payload['to'],
                'subject' => $payload['subject'],
                'status' => $payload['type'], // or map to your own status
                'tags' => $payload['tags'] ?? [],
                'metadata' => array_filter([
                    'user_agent' => $payload['user_agent'] ?? null,
                    'clicked_url' => $payload['clicked_url'] ?? null,
                    'device' => $payload['device'] ?? null,
                    'geo' => $payload['geo'] ?? null,
                    'os' => $payload['os'] ?? null,
                ]),
            ]);

            return response()->json(['message' => 'Webhook processed successfully']);
        } catch (\Exception $e) {
            Log::error('Error processing Resend webhook', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);
            return response()->json(['message' => 'Error processing webhook'], 500);
        }
    }
} 
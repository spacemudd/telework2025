<?php
// app/Listeners/LogSentEmails.php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use App\Models\CompanyAuditRecord;
use App\Models\Company;

class LogSentEmails
{
    public function handle(MessageSent $event)
    {
        $email = $event->message->getTo();
        $subject = $event->message->getSubject();
        $body = $event->message->getBody();
        $plainTextBody = '';

        if (method_exists($body, 'getParts')) {
            foreach ($body->getParts() as $part) {
                if (stripos($part->getMediaType(), 'text/plain') !== false) {
                    $plainTextBody = $part->getBody();
                    break;
                }
            }
        } else {
            $plainTextBody = $body;
        }

        $bodySnippet = substr((string) $plainTextBody, 0, 500);

        if (!$email) {
            return;
        }

        foreach ($email as $address => $details) {
            // Try to find company based on email (optional matching logic)
            $company = Company::where('email', $address)->first();

            if ($company) {
                CompanyAuditRecord::create([
                    'company_id' => $company->id,
                    'recipient_email' => $address,
                    'subject' => $subject,
                    'body_snippet' => $bodySnippet,
                    'status' => 'sent',
                ]);
            }
        }
    }
}

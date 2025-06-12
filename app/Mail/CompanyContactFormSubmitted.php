<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Enterprise Contact Form Submission',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.company.contact-form',
            with: [
                'data' => $this->data,
            ],
        );
    }
} 
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $company;
    public $email;
    public $password;
    public $role;

    /**
     * Create a new message instance.
     */
    public function __construct($company, $email, $password, $role)
    {
        $this->company = $company;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('words.team_invitation_subject', ['company' => $this->company->name]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.company_welcome',
            with: [
                'company' => is_object($this->company) && property_exists($this->company, 'name') ? $this->company->name : (string) $this->company,
                'company_code' => is_object($this->company) && property_exists($this->company, 'code') ? $this->company->code : null,
                'email' => $this->email,
                'password' => $this->password,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

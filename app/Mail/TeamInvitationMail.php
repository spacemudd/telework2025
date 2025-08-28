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
        
        // Set processed values for the template
        $this->companyName = $this->getCompanyName();
        $this->companyCode = $this->getCompanyCode();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $companyName = $this->getCompanyName();
        return new Envelope(
            subject: "دعوة للانضمام إلى منصة العمل عن بُعد - {$companyName}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.team_invitation',
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

    /**
     * Build the view data for the message.
     *
     * @return array
     */
    public function buildViewData()
    {
        return [
            'companyName' => $this->getCompanyName(),
            'companyCode' => $this->getCompanyCode(),
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * Extract company name safely
     */
    private function getCompanyName(): string
    {
        // Debug: Log what we're receiving
        \Log::info('Company data type: ' . gettype($this->company));
        \Log::info('Company data: ' . json_encode($this->company));
        
        // Handle JSON string (when model is serialized for queue)
        if (is_string($this->company) && str_starts_with($this->company, '{')) {
            $decoded = json_decode($this->company, true);
            if (is_array($decoded) && isset($decoded['name'])) {
                return $decoded['name'];
            }
        }
        
        if (is_object($this->company)) {
            // Try to access the name property directly
            if (isset($this->company->name)) {
                return $this->company->name;
            }
            // Fallback to property_exists check
            if (property_exists($this->company, 'name')) {
                return $this->company->name;
            }
            // Try getter method
            if (method_exists($this->company, 'getName')) {
                return $this->company->getName();
            }
        }
        
        // If it's a string, return as is
        if (is_string($this->company)) {
            return $this->company;
        }
        
        // If it's an array with name key
        if (is_array($this->company) && isset($this->company['name'])) {
            return $this->company['name'];
        }
        
        // Fallback
        return 'Unknown Company';
    }

    /**
     * Extract company code safely
     */
    private function getCompanyCode(): ?string
    {
        // Handle JSON string (when model is serialized for queue)
        if (is_string($this->company) && str_starts_with($this->company, '{')) {
            $decoded = json_decode($this->company, true);
            if (is_array($decoded) && isset($decoded['code'])) {
                return $decoded['code'];
            }
        }
        
        if (is_object($this->company)) {
            if (property_exists($this->company, 'code')) {
                return $this->company->code;
            }
            if (method_exists($this->company, 'getCode')) {
                return $this->company->getCode();
            }
        }
        
        // If it's an array with code key
        if (is_array($this->company) && isset($this->company['code'])) {
            return $this->company['code'];
        }
        
        return null;
    }
}

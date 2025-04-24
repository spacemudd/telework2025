<?php

namespace App\Notifications;

use App\Mail\CompanyWelcomeMail;
use Illuminate\Notifications\Notification;

class CompanyWelcomeNotification extends Notification
{
    protected $companyName;
    protected $username;
    protected $password;

    public function __construct($companyName, $username, $password)
    {
        $this->companyName = $companyName;
        $this->username = $username;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new CompanyWelcomeMail(
            $this->companyName,
            $this->username,
            $this->password
        ))
            ->to($notifiable->email)
            ->bcc([
                'shafiqalshaar@adv-line.com',
            ]);
    }
}

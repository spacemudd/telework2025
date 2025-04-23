<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        return (new MailMessage)
            ->subject('مرحبًا بكم في منصة شركة هدف للتوظيف!')
            ->greeting('مرحبًا ' . $notifiable->name)
            ->line('شكراً على تعاقدكم مع شركة هدف للتوظيف. لقد تم تأسيس حساب لكم على منصة العمل عن بعد الخاصة بشركة هدف للتوظيف.')
            ->line('مرفق لكم بيانات الدخول:')
            ->line('اسم المستخدم: ' . $this->username)
            ->line('كلمة المرور: ' . $this->password)
            ->action('تسجيل الدخول إلى النظام', url('/login'))
            ->salutation('مع تحيات فريق شركة هدف للتوظيف');
    }
}

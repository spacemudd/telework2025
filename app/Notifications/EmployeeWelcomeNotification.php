<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeWelcomeNotification extends Notification
{
    use Queueable;

    protected $companyName;
    protected $linkedAt;
    protected $username;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($companyName, $linkedAt, $username, $password)
    {
        $this->companyName = $companyName;
        $this->linkedAt = $linkedAt;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('مرحبًا بك في نظام العمل عن بعد')
            ->greeting('مرحبًا ' . $notifiable->name)
            ->line('نفيدكم بأنه تم ربطكم بخدمة العمل عن بعد لصالح شركة ' . $this->companyName . ' اعتباراً من ' . $this->linkedAt . '.')
            ->line('مرفق لكم بيانات الدخول للتمكن من متابعة مهامكم على النظام:')
            ->line('اسم المستخدم: ' . $this->username)
            ->line('كلمة المرور: ' . $this->password)
            ->action('تسجيل الدخول إلى النظام', url('/login'))
            ->salutation('مع تحيات فريق الدعم.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

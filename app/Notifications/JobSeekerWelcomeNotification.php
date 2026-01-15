<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobSeekerWelcomeNotification extends Notification
{
    use Queueable;

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
            ->subject('مرحبًا بك في منصة العمل عن بعد')
            ->greeting('مرحبًا ' . $notifiable->name)
            ->line('شكرًا لتسجيلك في منصة العمل عن بعد. يسعدنا انضمامك معنا.')
            ->line('يمكنك تسجيل الدخول لإكمال إعداد ملفك الشخصي والاطلاع على فرص العمل المتاحة.')
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

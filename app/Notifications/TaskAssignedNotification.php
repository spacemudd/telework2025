<?php

namespace App\Notifications;

use App\Mail\TaskAssignedMail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected int $taskId;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
        $this->onQueue('emails');
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
    public function toMail(object $notifiable): TaskAssignedMail
    {
        $task = Task::with(['employee', 'employee.company'])->findOrFail($this->taskId);
        return (new TaskAssignedMail($task))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->taskId,
        ];
    }
} 
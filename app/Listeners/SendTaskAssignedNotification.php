<?php

namespace App\Listeners;

use App\Events\TaskAssignedEvent;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskAssignedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // Queue this listener to the emails queue for rate limiting
        $this->onQueue('emails');
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssignedEvent $event): void
    {
        $task = $event->task;
        
        // Load the employee relationship if not already loaded
        if (!$task->relationLoaded('employee')) {
            $task->load('employee');
        }
        
        // Check if employee exists and has a user account
        if ($task->employee && $task->employee->user) {
            $task->employee->user->notify(new TaskAssignedNotification($task));
        }
    }
} 
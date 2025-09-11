<?php

namespace App\Listeners;

use App\Events\TaskAssignedEvent;
use App\Notifications\TaskAssignedNotification;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskAssignedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The maximum number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'emails';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssignedEvent $event): void
    {
        $task = Task::with(['employee.user'])->find($event->taskId);

        if (!$task || !$task->employee || !$task->employee->user) {
            return;
        }

        $task->employee->user->notify(new TaskAssignedNotification($event->taskId));
    }
} 
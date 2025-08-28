<?php

namespace App\Events;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $taskId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }
} 
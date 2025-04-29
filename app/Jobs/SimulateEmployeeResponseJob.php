<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SimulateEmployeeResponseJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasks = \App\Models\Task::where('is_simulated', true)
            ->where('status', 'pending')
            ->get();

        foreach ($tasks as $task) {
            $response = \Illuminate\Support\Facades\Http::withToken(config('services.openai.key'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a remote employee completing a task.'],
                        ['role' => 'user', 'content' => "Write a brief confirmation message as if you just completed the task: '{$task->title}'"],
                    ],
                ]);

            $content = $response->json('choices.0.message.content') ?? 'تم إنجاز هذه المهمة.';

            $task->update([
                'status' => 'completed',
            ]);

            $task->messages()->create([
                'message' => $content,
                'sender_type' => \App\Models\Employee::class,
                'sender_id' => $task->employee_id,
                'is_simulated' => true,
            ]);
        }
    }
}

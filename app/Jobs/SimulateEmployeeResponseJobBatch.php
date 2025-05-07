<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SimulateEmployeeResponseJobBatch implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $tasks;

    /**
     * Create a new job instance.
     */
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->tasks as $task) {
            $content = $this->generateResponse($task->title);

            TaskComment::create([
                'task_id' => $task->id,
                'user_id' => $task->employee->user_id,
                'comment' => $content,
            ]);

            $task->update(['status' => 'completed']);

            usleep(250000); // optional delay to avoid rate limits
        }
    }

    protected function generateResponse(string $title): string
    {
        $response = Http::timeout(10)->withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'أنت موظف عمل عن بعد وترد على مهمة تم تنفيذها.'],
                ['role' => 'user', 'content' => "المهمة: {$title}. ماذا تكتب كرد مختصر يدل أنك أنجزتها؟"],
            ],
            'temperature' => 0.4,
        ]);

        return $response->json('choices.0.message.content') ?? 'تم تنفيذ المهمة بنجاح.';
    }
}

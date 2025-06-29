<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SimulateEmployeeResponseJobBatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tasks;
    
    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;
    
    /**
     * The maximum number of seconds the job can run.
     */
    public $timeout = 300;

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
            try {
                $content = $this->generateResponse($task->title);

                TaskComment::create([
                    'task_id' => $task->id,
                    'user_id' => $task->employee->user_id,
                    'comment' => $content,
                ]);

                $task->update(['status' => 'completed']);

                // Add delay between API calls to avoid rate limits
                usleep(500000); // 0.5 seconds
                
            } catch (Exception $e) {
                Log::error('Failed to simulate employee response for task ' . $task->id, [
                    'error' => $e->getMessage(),
                    'task_id' => $task->id,
                    'task_title' => $task->title
                ]);
                
                // Create a fallback comment even if API fails
                TaskComment::create([
                    'task_id' => $task->id,
                    'user_id' => $task->employee->user_id,
                    'comment' => 'تم تنفيذ المهمة بنجاح.',
                ]);

                $task->update(['status' => 'completed']);
            }
        }
    }

    protected function generateResponse(string $title): string
    {
        try {
            $response = Http::timeout(15)
                ->retry(2, 1000) // Retry 2 times with 1 second delay
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('services.openai.key'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'أنت موظف عمل عن بعد وترد على مهمة تم تنفيذها.'],
                        ['role' => 'user', 'content' => "المهمة: {$title}. ماذا تكتب كرد مختصر يدل أنك أنجزتها؟"],
                    ],
                    'temperature' => 0.4,
                    'max_tokens' => 150,
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                return $content ?: 'تم تنفيذ المهمة بنجاح.';
            } else {
                Log::warning('OpenAI API returned non-successful response', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return $this->getFallbackResponse($title);
            }
            
        } catch (Exception $e) {
            Log::error('OpenAI API call failed', [
                'error' => $e->getMessage(),
                'task_title' => $title
            ]);
            
            return $this->getFallbackResponse($title);
        }
    }
    
    /**
     * Get a fallback response when API fails
     */
    protected function getFallbackResponse(string $title): string
    {
        $fallbackResponses = [
            'تم تنفيذ المهمة بنجاح.',
            'تم إكمال المهمة المطلوبة.',
            'تم الانتهاء من المهمة.',
            'تم تسليم المهمة في الوقت المحدد.',
            'تم إنجاز المهمة بشكل مرضي.',
        ];
        
        return $fallbackResponses[array_rand($fallbackResponses)];
    }
}

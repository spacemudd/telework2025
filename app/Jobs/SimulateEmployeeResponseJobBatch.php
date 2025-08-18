<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\TaskComment;
use App\Models\SimulationConfig;
use App\Services\ApiCallLogger;
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
                // Get company's simulation config
                $config = $task->employee->company->config;
                
                // Determine the action based on probability
                $action = $this->determineTaskAction($config);
                
                // Generate appropriate response and update task
                $this->handleTaskAction($task, $action);
                
                // Add delay between API calls to avoid rate limits
                usleep(500000); // 0.5 seconds
                
            } catch (Exception $e) {
                Log::error('Failed to simulate employee response for task ' . $task->id, [
                    'error' => $e->getMessage(),
                    'task_id' => $task->id,
                    'task_title' => $task->title
                ]);
                
                // Fallback behavior
                $this->handleTaskAction($task, 'fallback');
            }
        }
    }

    private function determineTaskAction($config): string
    {
        $random = rand(1, 100);
        
        if ($random <= $config->completion_rate) {
            return 'complete';
        } elseif ($random <= $config->completion_rate + $config->in_progress_rate) {
            return 'in_progress';
        } elseif ($random <= $config->completion_rate + $config->in_progress_rate + $config->comment_only_rate) {
            return 'comment_only';
        } else {
            // No action - task remains in current state
            return 'no_action';
        }
    }

    private function handleTaskAction(Task $task, string $action): void
    {
        switch ($action) {
            case 'complete':
                $this->completeTask($task);
                break;
            case 'in_progress':
                $this->moveToInProgress($task);
                break;
            case 'comment_only':
                $this->addProgressComment($task);
                break;
            case 'no_action':
                // Task remains in current state, no comment
                break;
            case 'fallback':
                $this->fallbackResponse($task);
                break;
        }
    }

    private function completeTask(Task $task): void
    {
        $content = $this->generateResponse($task->title, 'completed');
        
        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $task->employee->user_id,
            'comment' => $content,
        ]);

        $task->update(['status' => 'completed']);
    }

    private function moveToInProgress(Task $task): void
    {
        $content = $this->generateResponse($task->title, 'in_progress');
        
        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $task->employee->user_id,
            'comment' => $content,
        ]);

        $task->update(['status' => 'in_progress']);
    }

    private function addProgressComment(Task $task): void
    {
        $content = $this->generateResponse($task->title, 'progress_update');
        
        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $task->employee->user_id,
            'comment' => $content,
        ]);

        // Status remains the same
    }

    private function fallbackResponse(Task $task): void
    {
        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $task->employee->user_id,
            'comment' => 'تم تنفيذ المهمة بنجاح.',
        ]);

        $task->update(['status' => 'completed']);
    }

    protected function generateResponse(string $title, string $responseType): string
    {
        $prompts = [
            'completed' => 'أنت موظف عمل عن بعد وقد أكملت المهمة التالية بنجاح.',
            'in_progress' => 'أنت موظف عمل عن بعد وقد بدأت العمل على المهمة التالية ولكن لم تكملها بعد.',
            'progress_update' => 'أنت موظف عمل عن بعد وتقدم تحديث عن تقدمك في المهمة التالية دون تغيير حالتها.',
        ];

        $userPrompts = [
            'completed' => "المهمة: {$title}. اكتب رداً مختصراً يدل على أنك أكملت المهمة بنجاح.",
            'in_progress' => "المهمة: {$title}. اكتب رداً مختصراً يدل على أنك بدأت العمل عليها ولكن لم تكملها بعد.",
            'progress_update' => "المهمة: {$title}. اكتب رداً مختصراً عن التقدم الذي أحرزته في المهمة.",
        ];

        try {
            $response = Http::timeout(15)
                ->retry(2, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('services.openai.key'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => $prompts[$responseType]],
                        ['role' => 'user', 'content' => $userPrompts[$responseType]],
                    ],
                    'temperature' => 0.7, // Increase for more variety
                    'max_tokens' => 150,
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                
                // Log the API call
                $tokensUsed = $response->json('usage.total_tokens', 0);
                $company = $task->employee->company;
                
                try {
                    ApiCallLogger::logResponseGeneration(
                        company: $company,
                        tokensUsed: $tokensUsed,
                        model: 'gpt-3.5-turbo',
                        requestPrompt: $userPrompts[$responseType],
                        responseContent: $content,
                        metadata: [
                            'task_id' => $task->id,
                            'task_title' => $title,
                            'response_type' => $responseType,
                            'employee_id' => $task->employee->id,
                            'response_status' => $response->status(),
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error('Failed to log API call for response generation', [
                        'company_id' => $company->id,
                        'task_id' => $task->id,
                        'error' => $e->getMessage(),
                    ]);
                }
                
                return $content ?: $this->getFallbackResponse($responseType);
            }
            
        } catch (Exception $e) {
            Log::error('OpenAI API call failed', [
                'error' => $e->getMessage(),
                'task_title' => $title,
                'response_type' => $responseType
            ]);
        }
        
        return $this->getFallbackResponse($responseType);
    }
    
    /**
     * Get a fallback response when API fails
     */
    protected function getFallbackResponse(string $responseType): string
    {
        $responses = [
            'completed' => [
                'تم تنفيذ المهمة بنجاح.',
                'تم إكمال المهمة المطلوبة.',
                'تم الانتهاء من المهمة.',
                'تم تسليم المهمة في الوقت المحدد.',
                'تم إنجاز المهمة بشكل مرضي.',
            ],
            'in_progress' => [
                'بدأت العمل على المهمة وسأكملها قريباً.',
                'المهمة قيد التنفيذ حالياً.',
                'أعمل على المهمة وأحرز تقدماً جيداً.',
                'المهمة في طور التنفيذ.',
                'بدأت بالمهمة وسأنتهي منها خلال فترة قصيرة.',
            ],
            'progress_update' => [
                'أعمل على المهمة وأحرز تقدماً مستمراً.',
                'التقدم في المهمة يسير بشكل طبيعي.',
                'أواصل العمل على المهمة.',
                'هناك تقدم ملحوظ في المهمة.',
                'المهمة تتقدم بوتيرة جيدة.',
            ],
        ];
        
        return $responses[$responseType][array_rand($responses[$responseType])];
    }
}

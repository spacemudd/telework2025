<?php

namespace App\Jobs;

use App\Events\TaskAssignedEvent;
use App\Models\Employee;
use App\Models\Task;
use App\Services\ApiCallLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GenerateSimulatedTasksForDateJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected Employee $employee;
    protected int $maxTasks;
    protected Carbon $targetDate;

    public function __construct(Employee $employee, int $maxTasks, Carbon $targetDate)
    {
        $this->employee = $employee;
        $this->maxTasks = $maxTasks;
        $this->targetDate = $targetDate;
    }

    public function handle(): void
    {
        Log::info('Generating simulated tasks for specific date.', [
            'employee_id' => $this->employee->id,
            'target_date' => $this->targetDate->format('Y-m-d'),
            'max_tasks' => $this->maxTasks,
        ]);

        $taskCount = rand(1, $this->maxTasks);

        $requestPrompt = "أنشئ {$taskCount} مهام مناسبة لموظف {$this->employee->position}. كل مهمة تحتوي على عنوان ووصف. الرد يكون بصيغة JSON كمصفوفة: [{\"title\": \"...\", \"description\": \"...\"}, ...]";
        
        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a Saudi Arabian-based company assigning tasks to Saudi remote workers.'],
                    ['role' => 'user', 'content' => $requestPrompt],
                ],
            ]);

        $content = $response->json('choices.0.message.content');
        
        // Log the API call
        $tokensUsed = $response->json('usage.total_tokens', 0);
        $company = $this->employee->company;
        
        try {
            ApiCallLogger::logTaskGeneration(
                company: $company,
                tokensUsed: $tokensUsed,
                model: 'gpt-4-turbo',
                requestPrompt: $requestPrompt,
                responseContent: $content,
                metadata: [
                    'employee_id' => $this->employee->id,
                    'employee_position' => $this->employee->position,
                    'task_count' => $taskCount,
                    'response_status' => $response->status(),
                    'target_date' => $this->targetDate->format('Y-m-d'),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to log API call for task generation', [
                'company_id' => $company->id,
                'employee_id' => $this->employee->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Strip ```json ... ``` formatting if present
        $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));

        $data = json_decode($content, true);

        if (isset($data['title'], $data['description'])) {
            $data = [$data];
        } elseif (!is_array($data)) {
            Log::error('Failed to decode OpenAI response for employee ID ' . $this->employee->id, [
                'raw_response' => $response->json('choices.0.message.content'),
            ]);
            return;
        }

        foreach ($data as $taskData) {
            if (!isset($taskData['title'], $taskData['description'])) {
                continue;
            }

            // Generate random timestamp during working hours (8 AM to 5 PM GMT+3) for the target date
            $randomWorkingHour = rand(8, 17); // 8 AM to 5 PM local time
            $randomMinute = rand(0, 59);
            $randomSecond = rand(0, 59);
            
            // Create timestamp for the target date in GMT+3 timezone (Asia/Riyadh)
            $randomTimestamp = $this->targetDate->copy()
                ->setTimezone('Asia/Riyadh')
                ->setTime($randomWorkingHour, $randomMinute, $randomSecond);

            $task = Task::create([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'due_date' => $this->targetDate->copy()->addDays(rand(1, 5)),
                'priority' => collect(['low', 'medium', 'high'])->random(),
                'employee_id' => $this->employee->id,
                'company_id' => $this->employee->company_id,
                'issx' => true,
                'status' => 'pending',
                'created_at' => $randomTimestamp,
                'updated_at' => $randomTimestamp,
            ]);

            // Fire the task assigned event to send email notification
            event(new TaskAssignedEvent($task));
        }
    }
} 
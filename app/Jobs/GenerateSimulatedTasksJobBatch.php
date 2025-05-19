<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateSimulatedTasksJobBatch implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected Employee $employee;
    protected int $maxTasks;

    public function __construct(Employee $employee, int $maxTasks)
    {
        $this->employee = $employee;
        $this->maxTasks = $maxTasks;
    }

    public function handle(): void
    {
        Log::info('Generating simulated tasks job batch.');

        $taskCount = rand(1, $this->maxTasks);

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a Saudi Arabian-based company assigning tasks to Saudi remote workers.'],
                    ['role' => 'user', 'content' => "أنشئ {$taskCount} مهام مناسبة لموظف {$this->employee->position}. كل مهمة تحتوي على عنوان ووصف. الرد يكون بصيغة JSON كمصفوفة: [{\"title\": \"...\", \"description\": \"...\"}, ...]"],
                ],
            ]);

        $data = json_decode($response->json('choices.0.message.content'), true);

        if (!is_array($data)) {
            Log::error('Failed to decode OpenAI response for employee ID ' . $this->employee->id, [
                'raw_response' => $response->json('choices.0.message.content'),
            ]);
            return;
        }

        foreach ($data as $taskData) {
            if (!isset($taskData['title'], $taskData['description'])) {
                continue;
            }

            Task::create([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'due_date' => now()->addDays(rand(1, 5)),
                'priority' => collect(['low', 'medium', 'high'])->random(),
                'employee_id' => $this->employee->id,
                'company_id' => $this->employee->company_id,
                'issx' => true,
                'status' => 'pending',
            ]);
        }
    }
}

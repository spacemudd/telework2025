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

        for ($i = 0; $i < $taskCount; $i++) {
            $response = Http::withToken(config('services.openai.key'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a Saudi Arabian-based company assigning tasks to Saudi remote workers.'],
                        ['role' => 'user', 'content' => 'قم بإنشاء عنوان مهمة سهلة جدًا للمبتدئين قصير ووصف بجملة واحدة مناسب لموظف ' . $this->employee->position . ' عن بعد. يجب أن يكون الرد بصيغة JSON فقط: { "title": "", "description": "" }'],
                    ],
                ]);

            $data = $response->json('choices.0.message.content');

            $taskData = json_decode($data, true);

            if (!is_array($taskData) || !isset($taskData['title'], $taskData['description'])) {
                $taskData = [
                    'title' => 'مهمة افتراضية',
                    'description' => 'تم إنشاء هذه المهمة للاختبار.',
                ];
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

            usleep(250000);
        }
    }
}

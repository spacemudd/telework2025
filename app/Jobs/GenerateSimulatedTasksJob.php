<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\SimulationConfig;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GenerateSimulatedTasksJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The company instance.
     *
     * @var Company
     */
    protected ?Company $company;

    /**
     * Create a new job instance.
     *
     * @param Company|null $company
     */
    public function __construct(?Company $company = null)
    {
        $this->company = $company;
    }

    public function handle(): void
    {
        $configs = SimulationConfig::with('company.employees');
        if ($this->company) {
            $configs = $configs->where('company_id', $this->company->id);
        }
        $configs = $configs->get();

        foreach ($configs as $config) {
            $company = $config->company;

            if (!$company || !$company->config->is_enabled) {
                continue;
            }

            foreach ($company->employees as $employee) {
                for ($i = 0; $i < $config->tasks_per_day; $i++) {
                    $response = Http::withToken(config('services.openai.key'))
                        ->post('https://api.openai.com/v1/chat/completions', [
                            'model' => 'gpt-4',
                            'messages' => [
                                ['role' => 'system', 'content' => 'You are a Saudi Arabian-based company assigning tasks to Saudi remote workers.'],
                                ['role' => 'user', 'content' => '
                                قم بإنشاء عنوان مهمة سهلة جدًا للمبتدئين قصير ووصف بجملة واحدة مناسب لموظف '.$employee->position.' عن بعد. يجب أن يكون الرد بصيغة JSON فقط: { "title": "", "description": "" }'],
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
                        'employee_id' => $employee->id,
                        'company_id' => $company->id,
                        'issx' => true,
                        'status' => 'pending',
                    ]);
                }
            }
        }
    }
}

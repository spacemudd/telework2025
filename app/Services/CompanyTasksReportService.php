<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyTasksReportService
{
    public function generateCsvReport(Company $company, array $tasksByEmployee): string
    {
        $csvFileName = "company_tasks_report_{$company->id}_{$company->code}_" . now()->format('Y_m_d') . ".csv";
        $csvPath = "reports/{$csvFileName}";
        
        // Create CSV content with UTF-8 BOM for Excel compatibility
        $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM
        
        // Headers
        $csvContent .= "الموظف,نوع المهمة,عنوان المهمة,الأولوية,الحالة,تاريخ الاستحقاق\n";
        
        foreach ($tasksByEmployee as $employeeName => $tasks) {
            // New Tasks
            foreach ($tasks['assigned'] as $task) {
                $csvContent .= $this->formatCsvLine($employeeName, 'مهمة جديدة', $task);
            }
            
            // Updated Tasks
            foreach ($tasks['updated'] as $task) {
                $csvContent .= $this->formatCsvLine($employeeName, 'مهمة محدثة', $task);
            }
            
            // Completed Tasks
            foreach ($tasks['completed'] as $task) {
                $csvContent .= $this->formatCsvLine($employeeName, 'مهمة مكتملة', $task);
            }
        }
        
        // Store the CSV file
        Storage::put($csvPath, $csvContent);
        
        return $csvPath;
    }
    
    private function formatCsvLine(string $employeeName, string $taskType, $task): string
    {
        return sprintf(
            "%s,%s,%s,%s,%s,%s\n",
            $this->escapeCsvField($employeeName),
            $this->escapeCsvField($taskType),
            $this->escapeCsvField($task->title),
            $this->escapeCsvField(__("words.{$task->priority}")),
            $this->escapeCsvField(__("words.{$task->status}")),
            $this->escapeCsvField(\Carbon\Carbon::parse($task->due_date)->translatedFormat('l j F Y'))
        );
    }
    
    private function escapeCsvField(string $field): string
    {
        if (strpos($field, ',') !== false || strpos($field, '"') !== false || strpos($field, "\n") !== false) {
            return '"' . str_replace('"', '""', $field) . '"';
        }
        return $field;
    }
    
    public function getStatistics(array $tasksByEmployee): array
    {
        $totalNew = 0;
        $totalUpdated = 0;
        $totalCompleted = 0;
        
        foreach ($tasksByEmployee as $tasks) {
            $totalNew += count($tasks['assigned']);
            $totalUpdated += count($tasks['updated']);
            $totalCompleted += count($tasks['completed']);
        }
        
        return [
            'new' => $totalNew,
            'updated' => $totalUpdated,
            'completed' => $totalCompleted,
        ];
    }
} 
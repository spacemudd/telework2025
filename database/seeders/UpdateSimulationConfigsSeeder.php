<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SimulationConfig;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class UpdateSimulationConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Updating existing simulation configs with new completion rate fields...');

        // Update all existing simulation configs with default values
        $updatedConfigs = SimulationConfig::where('completion_rate', null)
            ->orWhere('in_progress_rate', null)
            ->orWhere('comment_only_rate', null)
            ->update([
                'completion_rate' => 70,
                'in_progress_rate' => 20,
                'comment_only_rate' => 10,
            ]);

        $this->command->info("Updated {$updatedConfigs} simulation configs with completion rates.");

        // Create simulation configs for companies that don't have them
        $companiesWithoutConfig = Company::whereDoesntHave('config')->get();
        
        foreach ($companiesWithoutConfig as $company) {
            $company->config()->create([
                'tasks_per_day' => 1,
                'auto_complete' => true,
                'is_enabled' => true, // Enable simulation by default
                'completion_rate' => 70,
                'in_progress_rate' => 20,
                'comment_only_rate' => 10,
            ]);
        }

        $this->command->info("Created simulation configs for {$companiesWithoutConfig->count()} companies.");

        // Display summary
        $this->command->info('Summary of completion rates:');
        $this->command->table(
            ['Configuration', 'Percentage', 'Description'],
            [
                ['Completion Rate', '70%', 'Tasks marked as completed'],
                ['In Progress Rate', '20%', 'Tasks moved to in-progress'],
                ['Comment Only Rate', '10%', 'Tasks with progress comments only'],
                ['No Action Rate', '0%', 'Tasks that remain unchanged'],
            ]
        );

        $this->command->info('✅ All simulation configs updated successfully!');
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interview>
 */
class InterviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'employee_id' => \App\Models\Employee::factory(),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'language' => $this->faker->randomElement(['en', 'ar']),
            'interview_data' => ['questions' => []],
            'started_at' => now(),
            'completed_at' => now(),
        ];
    }
}

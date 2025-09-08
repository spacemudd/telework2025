<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\EmployeeExperience;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobSeekerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_seeker_dashboard_shows_correct_progress_percentage()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);

        // Initial state - only profile details (30%)
        $response = $this->actingAs($user)->get(route('employee.job-seeker-dashboard', ['locale' => 'ar']));
        $response->assertStatus(200);
        $response->assertSee('30%');
        
        // Add experience (30% + 30% = 60%)
        EmployeeExperience::create([
            'employee_id' => $employee->id,
            'company_name' => 'Test Company',
            'job_title' => 'Test Title',
            'description' => 'Test description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);
        
        $response = $this->actingAs($user)->get(route('employee.job-seeker-dashboard', ['locale' => 'ar']));
        $response->assertStatus(200);
        $response->assertSee('60%');
        
        // Add education (60% + 30% = 90%)
        EmployeeEducation::create([
            'employee_id' => $employee->id,
            'title' => 'Test Degree',
            'institute_name' => 'Test University',
            'certificate_type' => 'Test Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);
        
        $response = $this->actingAs($user)->get(route('employee.job-seeker-dashboard', ['locale' => 'ar']));
        $response->assertStatus(200);
        $response->assertSee('90%');
        
        // Complete interview (90% + 10% = 100%)
        Interview::create([
            'user_id' => $user->id,
            'employee_id' => $employee->id,
            'status' => 'completed',
            'language' => 'en',
            'interview_data' => ['questions' => []],
            'started_at' => now(),
            'completed_at' => now(),
        ]);
        
        $response = $this->actingAs($user)->get(route('employee.job-seeker-dashboard', ['locale' => 'ar']));
        $response->assertStatus(200);
        $response->assertSee('100%');
    }
    
    public function test_job_seeker_dashboard_shows_correct_step_states()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);

        $response = $this->actingAs($user)->get(route('employee.job-seeker-dashboard', ['locale' => 'ar']));
        
        // Step 1: Profile details - always completed
        $response->assertSee('تفاصيل الملف الشخصي');
        $response->assertSee('مكتمل');
        
        // Step 2: Experiences - initially not completed
        $response->assertSee('الخبرات المهنية');
        $response->assertSee('ابدأ الآن');
        
        // Step 3: Education - initially not completed
        $response->assertSee('التعليم والشهادات');
        $response->assertSee('ابدأ الآن');
        
        // Step 4: Interview - initially not completed
        $response->assertSee('إجراء أول مقابلة');
        $response->assertSee('ابدأ الآن');
        
        // Complete experiences
        EmployeeExperience::create([
            'employee_id' => $employee->id,
            'company_name' => 'Test Company',
            'job_title' => 'Test Title',
            'description' => 'Test description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);
        
        $response = $this->actingAs($user)->get(route('employee.job-seeker-dashboard', ['locale' => 'ar']));
        $response->assertSee('الخبرات المهنية');
        $response->assertSee('مكتمل');
    }
}

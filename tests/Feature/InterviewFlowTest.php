<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Interview;
use App\Models\Company;
use App\Services\InterviewService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class InterviewFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $employee;
    protected $company;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a company
        $this->company = Company::create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'is_active' => true,
        ]);

        // Create a user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'locale' => 'ar',
        ]);

        // Create an employee
        $this->employee = Employee::create([
            'company_id' => $this->company->id,
            'user_id' => $this->user->id,
            'name' => 'Test Employee',
            'email' => 'test@example.com',
            'identity_number' => '1234567890',
            'is_job_seeker' => true,
            'profile_completed' => true,
        ]);
    }

    public function test_interview_flow_with_existing_interview()
    {
        // Mock the InterviewService
        $mockService = Mockery::mock(InterviewService::class);
        $this->app->instance(InterviewService::class, $mockService);

        // Create an existing interview
        $existingInterview = Interview::create([
            'user_id' => $this->user->id,
            'employee_id' => $this->employee->id,
            'status' => 'in_progress',
            'language' => 'ar',
        ]);

        // Act as the user
        $this->actingAs($this->user);

        // Test the start route - should redirect to existing interview
        $response = $this->get('/ar/interview/start');
        $response->assertRedirect();
        
        // Follow the redirect
        $response = $this->followRedirects();
        
        // Should end up at the conduct route
        $this->assertStringContainsString('/ar/interview/' . $existingInterview->id, $response->getTargetUrl());
    }

    public function test_interview_conduct_with_valid_id()
    {
        // Create an interview
        $interview = Interview::create([
            'user_id' => $this->user->id,
            'employee_id' => $this->employee->id,
            'status' => 'pending',
            'language' => 'ar',
        ]);

        // Act as the user
        $this->actingAs($this->user);

        // Test the conduct route directly
        $response = $this->get('/ar/interview/' . $interview->id);
        
        // Should be successful
        $response->assertStatus(200);
        $response->assertViewIs('interview.conduct');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

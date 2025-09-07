<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Interview;
use App\Models\Company;
use App\Services\InterviewService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;

class InterviewControllerTest extends TestCase
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

    public function test_start_creates_new_interview_for_job_seeker()
    {
        // Mock the InterviewService
        $mockService = Mockery::mock(InterviewService::class);
        $mockService->shouldReceive('generateQuestions')->once();
        
        $this->app->instance(InterviewService::class, $mockService);

        // Act as the user
        $this->actingAs($this->user);

        // Make request to start interview
        $response = $this->get('/ar/interview/start');

        // Assert redirect to conduct interview
        $response->assertRedirect();
        
        // Check that an interview was created
        $this->assertDatabaseHas('interviews', [
            'user_id' => $this->user->id,
            'employee_id' => $this->employee->id,
            'status' => 'pending',
            'language' => 'ar',
        ]);
    }

    public function test_start_redirects_existing_interview_to_conduct()
    {
        // Create an existing interview
        $existingInterview = Interview::create([
            'user_id' => $this->user->id,
            'employee_id' => $this->employee->id,
            'status' => 'in_progress',
            'language' => 'ar',
        ]);

        // Act as the user
        $this->actingAs($this->user);

        // Make request to start interview
        $response = $this->get('/ar/interview/start');

        // Assert redirect to conduct the existing interview
        $response->assertRedirect();
        $this->assertStringContainsString('/ar/interview/' . $existingInterview->id, $response->getTargetUrl());
    }

    public function test_start_denies_access_for_non_job_seeker()
    {
        // Update employee to not be a job seeker
        $this->employee->update(['is_job_seeker' => false]);

        // Act as the user
        $this->actingAs($this->user);

        // Make request to start interview
        $response = $this->get('/ar/interview/start');

        // Assert redirect to dashboard with error
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Access denied');
    }

    public function test_conduct_displays_interview_for_valid_id()
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

        // Make request to conduct interview
        $response = $this->get('/ar/interview/' . $interview->id);

        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('interview.conduct');
    }

    public function test_conduct_returns_error_for_invalid_id()
    {
        // Act as the user
        $this->actingAs($this->user);

        // Make request with invalid interview ID
        $response = $this->get('/ar/interview/invalid-id');

        // Assert redirect to dashboard with error
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Interview not found');
    }

    public function test_conduct_redirects_completed_interview()
    {
        // Create a completed interview
        $interview = Interview::create([
            'user_id' => $this->user->id,
            'employee_id' => $this->employee->id,
            'status' => 'completed',
            'language' => 'ar',
        ]);

        // Act as the user
        $this->actingAs($this->user);

        // Make request to conduct interview
        $response = $this->get('/ar/interview/' . $interview->id);

        // Assert redirect to dashboard
        $response->assertRedirect();
        $response->assertSessionHas('info', 'تم إكمال هذه المقابلة بالفعل.');
    }

    public function test_conduct_denies_access_for_other_user_interview()
    {
        // Create another user and employee
        $otherUser = User::create([
            'name' => 'Other User',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $otherEmployee = Employee::create([
            'company_id' => $this->company->id,
            'user_id' => $otherUser->id,
            'name' => 'Other Employee',
            'email' => 'other@example.com',
            'identity_number' => '0987654321',
            'is_job_seeker' => true,
        ]);

        // Create an interview for the other user
        $interview = Interview::create([
            'user_id' => $otherUser->id,
            'employee_id' => $otherEmployee->id,
            'status' => 'pending',
            'language' => 'ar',
        ]);

        // Act as the first user
        $this->actingAs($this->user);

        // Make request to conduct the other user's interview
        $response = $this->get('/ar/interview/' . $interview->id);

        // Assert 403 Forbidden
        $response->assertStatus(403);
    }

    public function test_store_response_handles_route_parameters_correctly()
    {
        // Create an interview
        $interview = Interview::create([
            'user_id' => $this->user->id,
            'employee_id' => $this->employee->id,
            'status' => 'pending',
            'language' => 'ar',
        ]);

        // Create a question
        $question = \App\Models\InterviewQuestion::create([
            'interview_id' => $interview->id,
            'question_text' => 'Test question',
            'question_text_ar' => 'سؤال تجريبي',
            'question_order' => 1,
        ]);

        // Act as the user
        $this->actingAs($this->user);

        // Create a test audio file
        $file = \Illuminate\Http\UploadedFile::fake()->create('test.mp3', 1000, 'audio/mpeg');

        // Make request to store response
        $response = $this->post('/ar/interview/' . $interview->id . '/questions/' . $question->id . '/response', [
            'audio_file' => $file,
            'recording_duration' => 30,
        ]);

        // Assert successful response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeExperience;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_create_experience()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'is_job_seeker' => true
        ]);

        $response = $this->actingAs($user)->post(route('employee.experiences.store', ['locale' => 'ar']), [
            'company_name' => 'Test Company',
            'job_title' => 'Software Developer',
            'description' => 'Test description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('employee_experiences', [
            'company_name' => 'Test Company',
            'job_title' => 'Software Developer',
        ]);
    }

    public function test_employee_can_update_own_experience()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        $experience = EmployeeExperience::create([
            'employee_id' => $employee->id,
            'company_name' => 'Original Company',
            'job_title' => 'Original Title',
            'description' => 'Original description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user)->put(route('employee.experiences.update', ['locale' => 'ar', 'experience' => $experience->id]), [
            'company_name' => 'Updated Company',
            'job_title' => 'Senior Developer',
            'description' => 'Updated description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('employee_experiences', [
            'id' => $experience->id,
            'company_name' => 'Updated Company',
            'job_title' => 'Senior Developer',
        ]);
    }

    public function test_employee_cannot_update_other_employee_experience()
    {
        $user1 = User::factory()->create();
        $company1 = Company::factory()->create();
        $employee1 = Employee::factory()->create([
            'user_id' => $user1->id,
            'company_id' => $company1->id,
            'is_job_seeker' => true
        ]);
        
        $user2 = User::factory()->create();
        $company2 = Company::factory()->create();
        $employee2 = Employee::factory()->create([
            'user_id' => $user2->id,
            'company_id' => $company2->id,
            'is_job_seeker' => true
        ]);
        
        $employee1 = Employee::factory()->create([
            'user_id' => $user1->id,
            'is_job_seeker' => true
        ]);
        
        $employee2 = Employee::factory()->create([
            'user_id' => $user2->id,
            'is_job_seeker' => true
        ]);
        
        $experience = EmployeeExperience::create([
            'employee_id' => $employee2->id,
            'company_name' => 'Original Company',
            'job_title' => 'Original Title',
            'description' => 'Original description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user1)->put(route('employee.experiences.update', ['locale' => 'ar', 'experience' => $experience->id]), [
            'company_name' => 'Hacked Company',
            'job_title' => 'Hacker',
            'description' => 'Hacked description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response->assertStatus(403);
    }
    
    public function test_employee_cannot_delete_other_employee_experience()
    {
        $user1 = User::factory()->create();
        $company1 = Company::factory()->create();
        $employee1 = Employee::factory()->create([
            'user_id' => $user1->id,
            'company_id' => $company1->id,
            'is_job_seeker' => true
        ]);
        
        $user2 = User::factory()->create();
        $company2 = Company::factory()->create();
        $employee2 = Employee::factory()->create([
            'user_id' => $user2->id,
            'company_id' => $company2->id,
            'is_job_seeker' => true
        ]);
        
        $employee1 = Employee::factory()->create([
            'user_id' => $user1->id,
            'is_job_seeker' => true
        ]);
        
        $employee2 = Employee::factory()->create([
            'user_id' => $user2->id,
            'is_job_seeker' => true
        ]);
        
        $experience = EmployeeExperience::create([
            'employee_id' => $employee2->id,
            'company_name' => 'Original Company',
            'job_title' => 'Original Title',
            'description' => 'Original description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user1)->delete(route('employee.experiences.destroy', ['locale' => 'ar', 'experience' => $experience->id]));

        $response->assertStatus(403);
        $this->assertDatabaseHas('employee_experiences', [
            'id' => $experience->id,
        ]);
    }
    
    public function test_employee_can_delete_own_experience()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        $experience = EmployeeExperience::create([
            'employee_id' => $employee->id,
            'company_name' => 'Test Company',
            'job_title' => 'Test Title',
            'description' => 'Test description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user)->delete(route('employee.experiences.destroy', ['locale' => 'ar', 'experience' => $experience->id]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('employee_experiences', [
            'id' => $experience->id,
        ]);
    }
    
    public function test_employee_profile_completeness_updates_with_experience()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        // Initially employee has no experiences
        $this->assertFalse($employee->hasExperiences());
        
        // Create an experience
        $experience = EmployeeExperience::create([
            'employee_id' => $employee->id,
            'company_name' => 'Test Company',
            'job_title' => 'Test Title',
            'description' => 'Test description',
            'start_date' => '2020-01-01',
            'end_date' => '2022-12-31',
            'is_current' => false,
        ]);
        
        // Now employee should have experiences
        $this->assertTrue($employee->fresh()->hasExperiences());
    }
}

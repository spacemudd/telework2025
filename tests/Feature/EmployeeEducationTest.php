<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeEducationTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_create_education()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);

        $response = $this->actingAs($user)->post(route('employee.educations.store', ['locale' => 'ar']), [
            'title' => 'Computer Science',
            'institute_name' => 'Test University',
            'certificate_type' => 'Bachelor',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('employee_educations', [
            'title' => 'Computer Science',
            'institute_name' => 'Test University',
            'certificate_type' => 'Bachelor',
        ]);
    }

    public function test_employee_can_update_own_education()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        $education = EmployeeEducation::create([
            'employee_id' => $employee->id,
            'title' => 'Original Degree',
            'institute_name' => 'Original University',
            'certificate_type' => 'Original Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user)->put(route('employee.educations.update', ['locale' => 'ar', 'education' => $education->id]), [
            'title' => 'Updated Degree',
            'institute_name' => 'Updated University',
            'certificate_type' => 'Updated Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('employee_educations', [
            'id' => $education->id,
            'title' => 'Updated Degree',
            'institute_name' => 'Updated University',
            'certificate_type' => 'Updated Certificate',
        ]);
    }

    public function test_employee_cannot_update_other_employee_education()
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
        
        $education = EmployeeEducation::create([
            'employee_id' => $employee2->id,
            'title' => 'Original Degree',
            'institute_name' => 'Original University',
            'certificate_type' => 'Original Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user1)->put(route('employee.educations.update', ['locale' => 'ar', 'education' => $education->id]), [
            'title' => 'Hacked Degree',
            'institute_name' => 'Hacked University',
            'certificate_type' => 'Hacked Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response->assertStatus(403);
    }
    
    public function test_certificate_type_filtering_works()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        // Create PMP certificate
        EmployeeEducation::create([
            'employee_id' => $employee->id,
            'title' => 'Project Management Professional',
            'institute_name' => 'PMI',
            'certificate_type' => 'PMP',
            'start_date' => '2020-01-01',
            'end_date' => '2023-12-31',
            'is_current' => false,
        ]);
        
        // Create other certificate
        EmployeeEducation::create([
            'employee_id' => $employee->id,
            'title' => 'Computer Science',
            'institute_name' => 'University',
            'certificate_type' => 'Bachelor',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);
        
        // Test filtering by certificate type
        $pmpCertificates = EmployeeEducation::withCertificate('PMP')->get();
        $this->assertEquals(1, $pmpCertificates->count());
        $this->assertEquals('Project Management Professional', $pmpCertificates->first()->title);
        
        $bachelorCertificates = EmployeeEducation::withCertificate('Bachelor')->get();
        $this->assertEquals(1, $bachelorCertificates->count());
        $this->assertEquals('Computer Science', $bachelorCertificates->first()->title);
    }
    
    public function test_employee_can_delete_own_education()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        $education = EmployeeEducation::create([
            'employee_id' => $employee->id,
            'title' => 'Test Degree',
            'institute_name' => 'Test University',
            'certificate_type' => 'Test Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user)->delete(route('employee.educations.destroy', ['locale' => 'ar', 'education' => $education->id]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('employee_educations', [
            'id' => $education->id,
        ]);
    }
    
    public function test_employee_cannot_delete_other_employee_education()
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
        
        $education = EmployeeEducation::create([
            'employee_id' => $employee2->id,
            'title' => 'Original Degree',
            'institute_name' => 'Original University',
            'certificate_type' => 'Original Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);

        $response = $this->actingAs($user1)->delete(route('employee.educations.destroy', ['locale' => 'ar', 'education' => $education->id]));

        $response->assertStatus(403);
        $this->assertDatabaseHas('employee_educations', [
            'id' => $education->id,
        ]);
    }
    
    public function test_employee_profile_completeness_updates_with_education()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        // Initially employee has no educations
        $this->assertFalse($employee->hasEducations());
        
        // Create an education
        $education = EmployeeEducation::create([
            'employee_id' => $employee->id,
            'title' => 'Test Degree',
            'institute_name' => 'Test University',
            'certificate_type' => 'Test Certificate',
            'start_date' => '2016-01-01',
            'end_date' => '2020-12-31',
            'is_current' => false,
        ]);
        
        // Now employee should have educations
        $this->assertTrue($employee->fresh()->hasEducations());
    }
    
    public function test_current_education_handles_end_date_correctly()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_job_seeker' => true
        ]);
        
        $response = $this->actingAs($user)->post(route('employee.educations.store', ['locale' => 'ar']), [
            'title' => 'Current Degree',
            'institute_name' => 'Current University',
            'certificate_type' => 'Master',
            'start_date' => '2023-01-01',
            'is_current' => true,
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('employee_educations', [
            'title' => 'Current Degree',
            'is_current' => true,
            'end_date' => null,
        ]);
    }
}

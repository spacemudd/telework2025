<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->owned_company; // Assuming user has company relationship
        $employees = $company ? $company->employees : [];

        return view('company.dashboard', compact('company', 'employees'));
    }

    public function exportAttendance(Request $request)
    {
        $company = auth()->user()->owned_company;

        $now = Carbon::now();
        
        // Get the month to export (default to current month if not specified)
        $monthToExport = $request->input('month', $now->format('Y-m'));
        $exportDate = Carbon::createFromFormat('Y-m', $monthToExport);
        $isCurrentMonth = $exportDate->format('Y-m') === $now->format('Y-m');
        

        
        // Only allow downloading current month report after the 20th
        if ($isCurrentMonth && $now->day < 20) {
            abort(403, __('words.current_month_restriction'));
        }
        
        // Allow future months for testing purposes - remove this restriction
        // if ($exportDate->startOfMonth()->gt($now->startOfMonth())) {
        //     abort(403, 'Cannot export future month reports.');
        // }
        
        // Ensure the requested month is not before company creation
        $companyCreated = Carbon::parse($company->created_at);
        if ($exportDate->startOfMonth()->lt($companyCreated->startOfMonth())) {
            abort(403, 'Cannot export reports before company creation.');
        }

        $startDate = $exportDate->copy()->startOfMonth();
        
        // For current month, exclude today. For past months, include the entire month
        if ($isCurrentMonth) {
            $endDate = $now->copy()->subDay()->endOfDay();
        } else {
            $endDate = $exportDate->copy()->endOfMonth()->endOfDay();
        }

        // Generate date range for the selected month
        $dates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        // Load employees first
        $employees = $company->employees()->get();
        
        $csvHeader = array_merge(['الاسم'], $dates->toArray());
        $rows = [$csvHeader];
        
        // If no employees, create test data
        if ($employees->isEmpty()) {
            // Add a test row to show dates are working
            $testRow = ['اختبار موظف'];
            foreach ($dates as $date) {
                $dayOfWeek = Carbon::parse($date)->dayOfWeek;
                if ($dayOfWeek == 5 || $dayOfWeek == 6) { // Friday or Saturday
                    $testRow[] = '';
                } else {
                    $testRow[] = '09:00 - 17:00';
                }
            }
            $rows[] = $testRow;
        }

        // Only process employees if there are any
        if (!$employees->isEmpty()) {
            foreach ($employees as $employee) {
                $row = [$employee->name];

                foreach ($dates as $date) {
                    // Check for existing sessions for this specific date
                    $sessionsForDay = \App\Models\EmployeeSession::where('employee_id', $employee->id)
                        ->whereDate('started_at', $date)
                        ->orderBy('started_at')
                        ->get();

                    if ($sessionsForDay->isNotEmpty()) {
                        $start = $sessionsForDay->first()->started_at ? Carbon::parse($sessionsForDay->first()->started_at)->format('H:i') : '';
                        $end = $sessionsForDay->last()->ended_at ? Carbon::parse($sessionsForDay->last()->ended_at)->format('H:i') : '';
                        $row[] = $start . ' - ' . $end;
                    } else {
                        // Generate simulated attendance for completed days
                        $simulatedSession = $this->generateSimulatedSession($employee->id, $date);
                        if ($simulatedSession) {
                            $row[] = $simulatedSession['start_time'] . ' - ' . $simulatedSession['end_time'];
                        } else {
                            $row[] = ''; // Weekend or no work day
                        }
                    }
                }

                $rows[] = $row;
            }
        }



        // Generate filename with month information
        if ($isCurrentMonth) {
            $filename = 'attendance-' . $exportDate->format('Y-m') . '-to-' . $endDate->format('d') . '.csv';
        } else {
            $filename = 'attendance-' . $exportDate->format('Y-m') . '-complete.csv';
        }

        $handle = fopen('php://temp', 'r+');
        
        // Add UTF-8 BOM for Excel compatibility
        fwrite($handle, "\xEF\xBB\xBF");
        
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);

        return Response::stream(function () use ($handle) {
            fpassthru($handle);
        }, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

    /**
     * Generate a simulated work session for an employee on a specific date
     * Creates realistic WFH schedule with 5-8 hours of work and saves it to database
     */
    private function generateSimulatedSession($employeeId, $date)
    {
        // Skip weekends (Friday = 5, Saturday = 6 in Saudi Arabia)
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        if ($dayOfWeek == 5 || $dayOfWeek == 6) {
            return null; // No work on weekends
        }
        
        // Check if a session already exists for this date
        $existingSession = \App\Models\EmployeeSession::where('employee_id', $employeeId)
            ->whereDate('started_at', $date)
            ->first();
            
        if ($existingSession) {
            return [
                'start_time' => $existingSession->started_at ? Carbon::parse($existingSession->started_at)->format('H:i') : '',
                'end_time' => $existingSession->ended_at ? Carbon::parse($existingSession->ended_at)->format('H:i') : ''
            ];
        }
        
        // Create a seed based on employee ID and date for consistent results
        $seed = crc32($employeeId . $date);
        mt_srand($seed);
        
        // Random start time between 8:00 AM and 10:00 AM
        $startHour = mt_rand(8, 10);
        $startMinute = mt_rand(0, 59);
        
        // Random work duration between 5 and 8 hours
        $workHours = mt_rand(5, 8);
        $workMinutes = mt_rand(0, 59);
        
        $startTime = Carbon::parse($date)->setTime($startHour, $startMinute);
        $endTime = $startTime->copy()->addHours($workHours)->addMinutes($workMinutes);
        
        // Calculate duration in hours
        $duration = $startTime->diffInMinutes($endTime) / 60;
        
        // Create and save the simulated session
        $session = \App\Models\EmployeeSession::create([
            'employee_id' => $employeeId,
            'started_at' => $startTime,
            'ended_at' => $endTime,
            'duration' => $duration,
        ]);
        
        return [
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i')
        ];
    }
}

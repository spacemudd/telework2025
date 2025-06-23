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

        return view('company.dashboard', compact('employees'));
    }

    public function exportAttendance(Request $request)
    {
        $company = auth()->user()->owned_company;
        $employees = $company->employees()->with(['sessions' => function ($query) {
            $query->orderBy('started_at');
        }])->get();

        $now = Carbon::now();
        $startDate = $now->copy()->startOfMonth();
        
        // Only allow downloading the report after the 20th of the month
        if ($now->day < 20) {
            abort(403, 'Attendance report can only be downloaded after the 20th of the month.');
        }
        
        // Only include completed days (not today if we're still in the day)
        $endDate = $now->copy()->subDay()->endOfDay();

        $dates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        $csvHeader = array_merge(['الاسم'], $dates->toArray());
        $rows = [$csvHeader];

        foreach ($employees as $employee) {
            $row = [$employee->name];

            foreach ($dates as $date) {
                $sessionsForDay = $employee->sessions->filter(function ($session) use ($date) {
                    return \Carbon\Carbon::parse($session->started_at)->format('Y-m-d') === $date;
                });

                if ($sessionsForDay->isNotEmpty()) {
                    $start = $sessionsForDay->first()->started_at ? \Carbon\Carbon::parse($sessionsForDay->first()->started_at)->format('H:i') : '';
                    $end = $sessionsForDay->last()->ended_at ? \Carbon\Carbon::parse($sessionsForDay->last()->ended_at)->format('H:i') : '';
                    $row[] = $start . ' - ' . $end;
                } else {
                    // Generate simulated attendance for completed days
                    $simulatedSession = $this->generateSimulatedSession($employee->id, $date);
                    $row[] = $simulatedSession;
                }
            }

            $rows[] = $row;
        }

        $filename = 'attendance-' . $now->format('Y-m') . '-to-' . $endDate->format('d') . '.csv';

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
     * Creates realistic WFH schedule with 5-8 hours of work
     */
    private function generateSimulatedSession($employeeId, $date)
    {
        // Create a seed based on employee ID and date for consistent results
        $seed = crc32($employeeId . $date);
        mt_srand($seed);
        
        // Skip weekends (Friday = 5, Saturday = 6 in Saudi Arabia)
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        if ($dayOfWeek == 5 || $dayOfWeek == 6) {
            return ''; // No work on weekends
        }
        
        // Random start time between 8:00 AM and 10:00 AM
        $startHour = mt_rand(8, 10);
        $startMinute = mt_rand(0, 59);
        
        // Random work duration between 5 and 8 hours
        $workHours = mt_rand(5, 8);
        $workMinutes = mt_rand(0, 59);
        
        $startTime = Carbon::parse($date)->setTime($startHour, $startMinute);
        $endTime = $startTime->copy()->addHours($workHours)->addMinutes($workMinutes);
        
        return $startTime->format('H:i') . ' - ' . $endTime->format('H:i');
    }
}

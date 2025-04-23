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
        $endDate = $now->copy()->day(20)->endOfDay();

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
                    $row[] = '';
                }
            }

            $rows[] = $row;
        }

        $filename = 'attendance-' . $now->format('Y-m') . '-to-20.csv';

        $handle = fopen('php://temp', 'r+');
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

}

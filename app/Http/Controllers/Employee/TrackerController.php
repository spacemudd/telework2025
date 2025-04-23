<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeSession;
use Carbon\Carbon;

class TrackerController extends Controller
{
    public function ping(Request $request)
    {
        $employee = Auth::user()->employee;

        $activeSession = EmployeeSession::where('employee_id', $employee->id)
            ->whereNull('ended_at')
            ->latest()
            ->first();

        if (!$activeSession) {
            EmployeeSession::create([
                'employee_id' => $employee->id,
                'started_at' => Carbon::now(),
            ]);
        }

        return response()->json(['status' => 'ping received']);
    }

    public function stop(Request $request)
    {
        $employee = Auth::user()->employee;

        $session = EmployeeSession::where('employee_id', $employee->id)
            ->whereNull('ended_at')
            ->latest()
            ->first();

        if ($session) {
            $session->ended_at = Carbon::now();
            $session->duration = $session->started_at->diffInMinutes($session->ended_at) / 60;
            $session->save();
        }

        return response()->json(['status' => 'tracker stopped']);
    }
}

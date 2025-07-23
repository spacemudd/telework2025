<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeRequestMessageController extends Controller
{
    public function store(Request $request, EmployeeRequest $employeeRequest)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Create the message
        $message = $employeeRequest->messages()->create([
            'message' => $request->message,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
        ]);

        // Update request status
        if ($request->has('close')) {
            $employeeRequest->update([
                'status' => 'closed',
            ]);
        } else {
            $employeeRequest->update([
                'status' => 'responded',
            ]);
        }

        return redirect()->route('admin.employee-requests.show', $employeeRequest->id)
            ->with('success', 'تم إرسال الرد بنجاح.');
    }
}

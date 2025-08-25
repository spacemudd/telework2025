<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use App\Mail\EmployeeRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmployeeRequestsController extends Controller
{
    public function index()
    {
        $company = $this->getCurrentCompany();
        $requests = $company->employeeRequests()
            ->latest()
            ->paginate(10);
        return view('company.employee_requests.index', compact('requests'));
    }

    public function create()
    {
        $company = auth()->user()->owned_company;
        
        if (!$company) {
            return redirect()->route('onboarding.company')->with('error', 'يرجى إكمال إعداد الشركة أولاً');
        }
        
        return view('company.employee_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:100',
            'note' => 'nullable|string|max:1000',
        ]);

        $company = $this->getCurrentCompany();

        $employeeRequest = $company->employeeRequests()->create([
            'job_title' => $request->job_title,
            'quantity' => $request->quantity,
            'note' => $request->note,
            'status' => 'pending',
        ]);

        // Add initial message
        $employeeRequest->messages()->create([
            'message' => "طلب موظف جديد:\nالمسمى الوظيفي: {$request->job_title}\nالعدد: {$request->quantity}\n" . 
                        ($request->note ? "ملاحظة: {$request->note}" : ""),
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
        ]);

        // Send notification email to sara@hadaf-hq.com
        Mail::to('sara@hadaf-hq.com')
            ->queue(new EmployeeRequestNotification($employeeRequest));

        return redirect()->route('company.employee-requests.index')
            ->with('success', __('words.request_submitted_successfully'));
    }

    public function show($id)
    {
        $company = $this->getCurrentCompany();
        
        $request = $company->employeeRequests()
            ->with(['messages.sender'])
            ->findOrFail($id);

        return view('company.employee_requests.show', compact('request'));
    }

    private function getCurrentCompany()
    {
        $user = auth()->user();
        $selectedCompanyId = session('selected_company_id');
        
        if ($selectedCompanyId) {
            $company = $user->companies()->where('company_id', $selectedCompanyId)->first();
            if ($company) {
                return $company;
            }
        }
        
        // Fallback to primary company or first available company
        $company = $user->primaryCompany;
        if (!$company && $user->companies()->exists()) {
            $company = $user->companies()->first();
        }
        
        if (!$company) {
            abort(403, 'You are not associated with any company.');
        }
        
        return $company;
    }
}

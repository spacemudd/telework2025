<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeCvController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB Max
        ]);

        $employee = auth()->user()->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile not found.');
        }

        $file = $request->file('cv');
        $extension = $file->getClientOriginalExtension();
        $fileName = 'cvs/' . $employee->id . '/cv_' . time() . '.' . $extension;

        try {
            $path = Storage::disk('s3')->put($fileName, file_get_contents($file));
            
            if ($path) {
                // Delete old CV if exists
                if ($employee->cv_path) {
                    Storage::disk('s3')->delete($employee->cv_path);
                }
                
                $employee->update(['cv_path' => $fileName]);
                
                return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
                                 ->with('success', __('words.cv_uploaded_successfully'));
            } else {
                 return redirect()->back()->with('error', 'Failed to upload CV to S3.');
            }
        } catch (\Exception $e) {
            \Log::error('CV Upload failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while uploading your CV. Please try again.');
        }
    }

    public function view()
    {
        $employee = auth()->user()->employee;

        if (!$employee || !$employee->cv_path) {
            return redirect()->back()->with('error', 'CV not found.');
        }

        try {
            $url = Storage::disk('s3')->temporaryUrl(
                $employee->cv_path,
                now()->addMinutes(5)
            );
            return redirect($url);
        } catch (\Exception $e) {
            \Log::error('CV view failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not retrieve CV. Please try again.');
        }
    }

    public function delete()
    {
        $employee = auth()->user()->employee;

        if (!$employee || !$employee->cv_path) {
            return redirect()->back()->with('error', 'CV not found.');
        }

        try {
            Storage::disk('s3')->delete($employee->cv_path);
            $employee->update(['cv_path' => null]);

            return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
                             ->with('success', 'CV deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('CV deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting your CV. Please try again.');
        }
    }
}

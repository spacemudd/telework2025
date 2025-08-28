<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\InterviewQuestion;
use App\Models\InterviewSession;
use App\Services\InterviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InterviewController extends Controller
{
    use AuthorizesRequests;
    
    protected InterviewService $interviewService;

    public function __construct(InterviewService $interviewService)
    {
        $this->interviewService = $interviewService;
    }

    public function start()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee || !$employee->is_job_seeker) {
            return redirect()->route('dashboard')->with('error', 'Access denied');
        }

        // Debug locale information
        \Log::info('Interview start method - Locale debug', [
            'request_locale' => request()->segment(1),
            'laravel_localization_locale' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale(),
            'app_locale' => app()->getLocale(),
            'user_locale' => $user->locale,
            'session_locale' => session('locale'),
            'url' => request()->url()
        ]);

        // Check if user already has a pending or in-progress interview
        $existingInterview = $employee->interviews()
            ->whereIn('status', ['pending', 'in_progress'])
            ->first();

        if ($existingInterview) {
            return redirect()->route('interview.conduct', $existingInterview);
        }

        // Get the current locale from LaravelLocalization
        $currentLocale = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
        
        \Log::info('Creating interview with locale', ['locale' => $currentLocale]);
        
        // Create new interview with the current UI locale
        $interview = Interview::create([
            'user_id' => $user->id,
            'employee_id' => $employee->id,
            'status' => 'pending',
            'language' => $currentLocale,
        ]);

        // Generate questions based on talent categories
        $this->interviewService->generateQuestions($interview);

        return redirect()->route('interview.conduct', $interview);
    }

    public function conduct(Interview $interview)
    {
        // Add debugging
        \Log::info('Interview conduct method called', [
            'interview_id' => $interview->id,
            'user_id' => auth()->id(),
            'locale' => app()->getLocale(),
            'interview_language' => $interview->language
        ]);

        $this->authorize('view', $interview);

        // Temporarily set the app locale to match the interview language
        $originalLocale = app()->getLocale();
        app()->setLocale($interview->language);

        if ($interview->status === 'pending') {
            $interview->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        $questions = $interview->questions;
        $currentQuestion = $questions->where('response_audio_url', null)->first();

        // Add more debugging
        \Log::info('Interview data prepared', [
            'questions_count' => $questions->count(),
            'current_question' => $currentQuestion ? $currentQuestion->id : null,
            'interview_status' => $interview->status,
            'current_app_locale' => app()->getLocale()
        ]);

        $view = view('interview.conduct', compact('interview', 'questions', 'currentQuestion'));
        
        // Restore the original locale
        app()->setLocale($originalLocale);
        
        return $view;
    }

    public function storeResponse(Request $request, Interview $interview, InterviewQuestion $question)
    {
        $this->authorize('update', $interview);

        \Log::info('Interview response submission started', [
            'interview_id' => $interview->id,
            'question_id' => $question->id,
            'user_id' => auth()->id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav,m4a,webm,ogg,mp4|max:10240', // Accept more audio/video formats
            'recording_duration' => 'required|integer|min:1|max:300', // 5 minutes max
        ]);

        try {
            $audioFile = $request->file('audio_file');
            
            // Get the original file extension
            $originalExtension = $audioFile->getClientOriginalExtension();
            if (empty($originalExtension)) {
                // Fallback: determine extension from MIME type
                $mimeType = $audioFile->getMimeType();
                $extension = ($mimeType === 'audio/webm' || $mimeType === 'video/webm') ? 'webm' :
                            (($mimeType === 'audio/ogg') ? 'ogg' :
                            (($mimeType === 'audio/mp4' || $mimeType === 'video/mp4') ? 'm4a' :
                            (($mimeType === 'audio/wav') ? 'wav' : 'mp3')));
            } else {
                $extension = $originalExtension;
            }
            
            $fileName = 'interviews/' . $interview->id . '/' . $question->id . '_' . time() . '.' . $extension;
            
            \Log::info('Attempting to store audio file', [
                'file_name' => $fileName,
                'file_size' => $audioFile->getSize(),
                'mime_type' => $audioFile->getMimeType(),
                'original_extension' => $originalExtension,
                'final_extension' => $extension
            ]);

            // Check S3 configuration
            $s3Config = config('filesystems.disks.s3');
            \Log::info('S3 configuration check', [
                'driver' => $s3Config['driver'] ?? 'not_set',
                'bucket' => $s3Config['bucket'] ?? 'not_set',
                'region' => $s3Config['region'] ?? 'not_set',
                'key_set' => !empty($s3Config['key']),
                'secret_set' => !empty($s3Config['secret'])
            ]);

            // Store in S3 (configured in filesystems.php)
            try {
                $path = Storage::disk('s3')->putFileAs(
                    dirname($fileName),
                    $audioFile,
                    basename($fileName)
                );
                \Log::info('Audio file stored successfully in S3', ['path' => $path]);
            } catch (\Exception $s3Error) {
                \Log::warning('S3 storage failed, falling back to local storage', [
                    's3_error' => $s3Error->getMessage(),
                    'falling_back_to_local' => true
                ]);
                
                // Fallback to local storage
                $path = Storage::disk('local')->putFileAs(
                    'interviews/' . $interview->id,
                    $audioFile,
                    $question->id . '_' . time() . '.' . $extension
                );
                \Log::info('Audio file stored successfully in local storage', ['path' => $path]);
            }

            $question->update([
                'response_audio_url' => $path,
                'recording_duration' => $request->recording_duration,
                'answered_at' => now(),
            ]);

            // Check if all questions are answered
            $unansweredQuestions = $interview->questions()->whereNull('response_audio_url')->count();
            
            if ($unansweredQuestions === 0) {
                $interview->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Response recorded successfully',
                'next_question' => $interview->questions()->whereNull('response_audio_url')->first(),
                'is_completed' => $unansweredQuestions === 0,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to store interview response', [
                'interview_id' => $interview->id,
                'question_id' => $question->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                's3_config' => config('filesystems.disks.s3')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to record response: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function complete(Interview $interview)
    {
        $this->authorize('update', $interview);

        $interview->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('employee.job-seeker-dashboard')
            ->with('success', 'Interview completed successfully!');
    }

    public function reRecord(Request $request, Interview $interview, InterviewQuestion $question)
    {
        $this->authorize('update', $interview);

        // Delete old audio file
        if ($question->response_audio_url) {
            Storage::disk('s3')->delete($question->response_audio_url);
        }

        $question->update([
            'response_audio_url' => null,
            'response_text' => null,
            'recording_duration' => null,
            'answered_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Question reset for re-recording',
        ]);
    }

    public function testLocale()
    {
        return response()->json([
            'request_segment_1' => request()->segment(1),
            'laravel_localization_locale' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale(),
            'app_locale' => app()->getLocale(),
            'user_locale' => auth()->user()->locale ?? 'NULL',
            'session_locale' => session('locale'),
            'url' => request()->url(),
            'full_url' => request()->fullUrl(),
            'supported_locales' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocalesKeys(),
        ]);
    }

    public function testUpload(Request $request)
    {
        try {
            \Log::info('Test upload method called', [
                'request_data' => $request->all(),
                'files' => $request->allFiles()
            ]);

            if (!$request->hasFile('audio_file')) {
                return response()->json(['error' => 'No audio file provided'], 400);
            }

            $audioFile = $request->file('audio_file');
            \Log::info('Audio file details', [
                'original_name' => $audioFile->getClientOriginalName(),
                'mime_type' => $audioFile->getMimeType(),
                'size' => $audioFile->getSize(),
                'extension' => $audioFile->getClientOriginalExtension()
            ]);

            // Test local storage first
            $localPath = Storage::disk('local')->putFileAs(
                'test_uploads',
                $audioFile,
                'test_' . time() . '.mp3'
            );

            \Log::info('Local storage successful', ['path' => $localPath]);

            return response()->json([
                'success' => true,
                'message' => 'Test upload successful',
                'local_path' => $localPath
            ]);

        } catch (\Exception $e) {
            \Log::error('Test upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function testRouteBinding(Interview $interview, InterviewQuestion $question)
    {
        return response()->json([
            'success' => true,
            'interview' => [
                'id' => $interview->id,
                'status' => $interview->status,
                'language' => $interview->language
            ],
            'question' => [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_order' => $question->question_order
            ],
            'user_id' => auth()->id(),
            'interview_user_id' => $interview->user_id
        ]);
    }
}

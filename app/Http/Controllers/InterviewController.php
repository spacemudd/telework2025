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
        // Add detailed debug logging
        \Log::info('Interview start method called', [
            'user_id' => auth()->id(),
            'url' => request()->url(),
            'full_url' => request()->fullUrl(),
            'method' => request()->method(),
            'headers' => request()->headers->all()
        ]);
        
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee || !$employee->is_job_seeker) {
            return redirect()->route('dashboard', ['locale' => app()->getLocale()])->with('error', 'Access denied');
        }

        // Check if user already has a completed interview
        $completedInterview = $employee->interviews()
            ->where('status', 'completed')
            ->first();

        if ($completedInterview) {
            return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
                ->with('info', 'You have already completed your interview.');
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

        \Log::info('Existing interview check', [
            'has_existing_interview' => $existingInterview ? true : false,
            'interview_id' => $existingInterview ? $existingInterview->id : null,
            'interview_status' => $existingInterview ? $existingInterview->status : null
        ]);

        if ($existingInterview) {
            \Log::info('Redirecting to existing interview', [
                'interview_id' => $existingInterview->id,
                'interview_object' => $existingInterview->toArray(),
                'redirect_url' => route('interview.conduct', ['locale' => app()->getLocale(), 'interview' => $existingInterview->id])
            ]);
            return redirect()->route('interview.conduct', ['locale' => app()->getLocale(), 'interview' => $existingInterview->id]);
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

        \Log::info('Redirecting to new interview', [
            'interview_id' => $interview->id,
            'interview_object' => $interview->toArray(),
            'redirect_url' => route('interview.conduct', ['locale' => app()->getLocale(), 'interview' => $interview->id])
        ]);
        return redirect()->route('interview.conduct', ['locale' => app()->getLocale(), 'interview' => $interview->id]);
    }

    public function conduct($interview)
    {
        // Add detailed debug logging
        \Log::info('Interview conduct method called with raw parameter', [
            'raw_interview_param' => $interview,
            'param_type' => gettype($interview),
            'user_id' => auth()->id(),
            'url' => request()->url(),
            'full_url' => request()->fullUrl(),
            'route_parameters' => request()->route()->parameters()
        ]);
        
        // The issue is that the route parameter might be the locale instead of the interview ID
        // Let's get the interview ID from the route parameters correctly
        $routeParams = request()->route()->parameters();
        $interviewId = $routeParams['interview'] ?? $interview;
        
        \Log::info('Corrected interview ID', [
            'original_param' => $interview,
            'route_params' => $routeParams,
            'corrected_id' => $interviewId
        ]);
        
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interviewId);
        
        \Log::info('Interview lookup result', [
            'found_interview' => $interview ? true : false,
            'interview_id' => $interview ? $interview->id : null,
            'all_interviews_for_user' => Interview::where('user_id', auth()->id())->pluck('id', 'status')->toArray()
        ]);
        
        if (!$interview) {
            return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
                ->with('error', 'Interview not found');
        }
        
        // Add debugging
        \Log::info('Interview conduct method called', [
            'interview_id' => $interview->id,
            'user_id' => auth()->id(),
            'locale' => app()->getLocale(),
            'interview_language' => $interview->language
        ]);

        $this->authorize('view', $interview);

        // Check if interview is already completed
        if ($interview->status === 'completed') {
            return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
                ->with('info', 'تم إكمال هذه المقابلة بالفعل.');
        }

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

        // Add interview_id to currentQuestion for frontend use
        if ($currentQuestion) {
            $currentQuestion->interview_id = $interview->id;
        }

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

    public function storeResponse(Request $request, $interview, $question)
    {
        // Add detailed debug logging
        \Log::info('StoreResponse method called', [
            'raw_interview_param' => $interview,
            'raw_question_param' => $question,
            'user_id' => auth()->id(),
            'url' => request()->url(),
            'route_parameters' => request()->route()->parameters()
        ]);
        
        // The issue is that the route parameter might be the locale instead of the interview ID
        // Let's get the interview ID from the route parameters correctly
        $routeParams = request()->route()->parameters();
        $interviewId = $routeParams['interview'] ?? $interview;
        $questionId = $routeParams['question'] ?? $question;
        
        \Log::info('Corrected IDs in storeResponse', [
            'original_interview_param' => $interview,
            'original_question_param' => $question,
            'route_params' => $routeParams,
            'corrected_interview_id' => $interviewId,
            'corrected_question_id' => $questionId
        ]);
        
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interviewId);
        
        if (!$interview) {
            \Log::error('Interview not found in storeResponse', [
                'interview_id' => $interviewId,
                'user_id' => auth()->id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }
        
        // Find the question by ID since route model binding isn't working correctly with UUIDs
        $question = InterviewQuestion::find($questionId);
        
        if (!$question) {
            \Log::error('Question not found in storeResponse', [
                'question_id' => $questionId,
                'interview_id' => $interview->id,
                'user_id' => auth()->id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Question not found'
            ], 404);
        }
        // Debug logging for route model binding
        \Log::info('Route model binding debug', [
            'interview_id' => $interview->id ?? 'NULL',
            'question_id' => $question->id ?? 'NULL',
            'request_path' => $request->path(),
            'request_url' => $request->url(),
            'request_method' => $request->method(),
            'user_id' => auth()->id(),
            'user_authenticated' => auth()->check(),
            'user_roles' => auth()->user() ? auth()->user()->getRoleNames() : 'no_user',
            'request_headers' => $request->headers->all(),
            'csrf_token' => $request->header('X-CSRF-TOKEN'),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'request_size' => $request->getContent() ? strlen($request->getContent()) : 'no_content'
        ]);

        // Add additional validation
        if (!$interview) {
            \Log::error('Interview not found in storeResponse', ['request' => $request->all()]);
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }

        if (!$question) {
            \Log::error('Question not found in storeResponse', [
                'interview_id' => $interview->id,
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Question not found'
            ], 404);
        }

        // Verify the question belongs to the interview
        if ($question->interview_id !== $interview->id) {
            \Log::error('Question does not belong to interview', [
                'question_interview_id' => $question->interview_id,
                'interview_id' => $interview->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid question for this interview'
            ], 400);
        }

        $this->authorize('update', $interview);

        \Log::info('Interview response submission started', [
            'interview_id' => $interview->id,
            'question_id' => $question->id,
            'user_id' => auth()->id(),
            'request_data' => $request->all(),
            'recording_duration_received' => $request->recording_duration,
            'recording_duration_type' => gettype($request->recording_duration)
        ]);

        // Check file size before validation
        $maxFileSize = min(
            (int) ini_get('upload_max_filesize') * 1024 * 1024, // Convert MB to bytes
            (int) ini_get('post_max_size') * 1024 * 1024, // Convert MB to bytes
            10 * 1024 * 1024 // 10MB fallback
        );
        
        \Log::info('File size limits', [
            'php_upload_max_filesize' => ini_get('upload_max_filesize'),
            'php_post_max_size' => ini_get('post_max_size'),
            'calculated_max_size' => $maxFileSize,
            'request_has_file' => $request->hasFile('audio_file')
        ]);
        
        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav,m4a,webm,ogg,mp4|max:' . ($maxFileSize / 1024), // Use calculated max size
            'recording_duration' => 'required|integer|min:1|max:600', // 10 minutes max
        ]);
        
        // Additional validation for recording duration
        $recordingDuration = (int) $request->recording_duration;
        if ($recordingDuration <= 0 || $recordingDuration > 600) {
            \Log::warning('Invalid recording duration received', [
                'received_duration' => $recordingDuration,
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid recording duration. Must be between 1 and 600 seconds.'
            ], 400);
        }

        try {
            $audioFile = $request->file('audio_file');
            
            \Log::info('File upload details', [
                'file_exists' => $audioFile ? 'yes' : 'no',
                'file_size' => $audioFile ? $audioFile->getSize() : 'N/A',
                'mime_type' => $audioFile ? $audioFile->getMimeType() : 'N/A',
                'original_name' => $audioFile ? $audioFile->getClientOriginalName() : 'N/A',
                'is_valid' => $audioFile ? $audioFile->isValid() : 'N/A',
                'error' => $audioFile ? $audioFile->getError() : 'N/A'
            ]);
            
            if (!$audioFile || !$audioFile->isValid()) {
                \Log::error('Invalid file upload', [
                    'file_error' => $audioFile ? $audioFile->getError() : 'no_file',
                    'file_size' => $audioFile ? $audioFile->getSize() : 'N/A'
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file upload'
                ], 400);
            }
            
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
                \Log::info('Attempting S3 storage', [
                    's3_config' => config('filesystems.disks.s3'),
                    'file_path' => $fileName
                ]);
                
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
                try {
                    \Log::info('Attempting local storage fallback', [
                        'local_path' => 'interviews/' . $interview->id,
                        'file_name' => $question->id . '_' . time() . '.' . $extension
                    ]);
                    
                    $path = Storage::disk('local')->putFileAs(
                        'interviews/' . $interview->id,
                        $audioFile,
                        $question->id . '_' . time() . '.' . $extension
                    );
                    \Log::info('Audio file stored successfully in local storage', ['path' => $path]);
                } catch (\Exception $localError) {
                    \Log::error('Local storage also failed', [
                        'local_error' => $localError->getMessage(),
                        'file_size' => $audioFile->getSize(),
                        'mime_type' => $audioFile->getMimeType()
                    ]);
                    throw new \Exception('Failed to store file in both S3 and local storage: ' . $localError->getMessage());
                }
            }

            \Log::info('Updating question with response data', [
                'question_id' => $question->id,
                'response_audio_url' => $path,
                'recording_duration' => $request->recording_duration
            ]);
            
            $question->update([
                'response_audio_url' => $path,
                'recording_duration' => $request->recording_duration,
                'answered_at' => now(),
            ]);
            
            \Log::info('Question updated successfully');

            // Check if all questions are answered
            $unansweredQuestions = $interview->questions()->whereNull('response_audio_url')->count();
            \Log::info('Checking interview completion', [
                'unanswered_questions' => $unansweredQuestions,
                'total_questions' => $interview->questions()->count()
            ]);
            
            if ($unansweredQuestions === 0) {
                \Log::info('Marking interview as completed');
                $interview->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
                \Log::info('Interview marked as completed');
            }

            $nextQuestion = $interview->questions()->whereNull('response_audio_url')->first();
            \Log::info('Preparing success response', [
                'next_question_id' => $nextQuestion ? $nextQuestion->id : null,
                'is_completed' => $unansweredQuestions === 0
            ]);
            
            return response()->json([
                'success' => true,
                'message' => __('words.response_recorded_successfully'),
                'next_question' => $nextQuestion,
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

    public function complete($interview)
    {
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interview);
        
        if (!$interview) {
            return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
                ->with('error', 'Interview not found');
        }
        $this->authorize('update', $interview);

        $interview->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])
            ->with('success', 'Interview completed successfully!');
    }

    public function reRecord(Request $request, $interview, $question)
    {
        // The issue is that the route parameter might be the locale instead of the interview ID
        // Let's get the interview ID from the route parameters correctly
        $routeParams = request()->route()->parameters();
        $interviewId = $routeParams['interview'] ?? $interview;
        $questionId = $routeParams['question'] ?? $question;
        
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interviewId);
        
        if (!$interview) {
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }
        
        // Find the question by ID since route model binding isn't working correctly with UUIDs
        $question = InterviewQuestion::find($questionId);
        
        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found'
            ], 404);
        }
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

    public function debugInterview($interview)
    {
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interview);
        
        if (!$interview) {
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }
        return response()->json([
            'interview_id' => $interview->id,
            'interview_status' => $interview->status,
            'questions_count' => $interview->questions()->count(),
            'unanswered_questions' => $interview->questions()->whereNull('response_audio_url')->count(),
            'current_question' => $interview->questions()->whereNull('response_audio_url')->first(),
            'user_id' => auth()->id(),
            'employee_id' => $interview->employee_id,
            'route_parameters' => request()->route()->parameters(),
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

    public function testRouteBinding($interview, $question)
    {
        // The issue is that the route parameter might be the locale instead of the interview ID
        // Let's get the interview ID from the route parameters correctly
        $routeParams = request()->route()->parameters();
        $interviewId = $routeParams['interview'] ?? $interview;
        $questionId = $routeParams['question'] ?? $question;
        
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interviewId);
        
        if (!$interview) {
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }
        
        // Find the question by ID since route model binding isn't working correctly with UUIDs
        $question = InterviewQuestion::find($questionId);
        
        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found'
            ], 404);
        }
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

    public function testResponse($interview)
    {
        // Find the interview by ID since route model binding isn't working correctly with UUIDs
        $interview = Interview::find($interview);
        
        if (!$interview) {
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }
        $this->authorize('view', $interview);
        
        return response()->json([
            'success' => true,
            'message' => 'Test response endpoint working',
            'interview_id' => $interview->id,
            'user_authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString()
        ]);
    }
}

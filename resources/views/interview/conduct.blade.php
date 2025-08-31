@extends('layouts.employee')

@push('styles')
<style>
    .question-text {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        line-height: 1.6;
        max-width: 100%;
        padding: 1rem;
        background-color: #f8fafc;
        border-radius: 0.5rem;
        border-left: 4px solid #3b82f6;
    }
    
    .question-text.rtl {
        text-align: right;
        border-left: none;
        border-right: 4px solid #3b82f6;
    }
    
    .question-text.ltr {
        text-align: left;
    }
    
    /* Section visibility management */
    .section-hidden {
        opacity: 0;
        visibility: hidden;
        height: 0;
        overflow: hidden;
        margin: 0;
        padding: 0;
        transition: all 0.5s ease-in-out;
    }
    
    .section-visible {
        opacity: 1;
        visibility: visible;
        height: auto;
        overflow: visible;
        transition: all 0.5s ease-in-out;
    }
    
    /* Timer styles */
    .timer {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1f2937;
    }
    
    .timer.warning {
        color: #f59e0b;
    }
    
    .timer.danger {
        color: #dc2626;
    }
    
    .timer-container {
        background: #f3f4f6;
        border-radius: 0.5rem;
        padding: 0.75rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    /* Video preview styles */
    .video-preview {
        width: 100%;
        max-width: 500px;
        border-radius: 0.5rem;
        margin: 0 auto;
        display: block;
    }
    
    /* Responsive adjustments for mobile */
    @media (max-width: 640px) {
        .question-text {
            font-size: 1rem;
            padding: 0.75rem;
            line-height: 1.5;
        }
        
        .timer {
            font-size: 1.25rem;
        }
    }
    
    /* Ensure proper text wrapping for very long questions */
    .question-text {
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* Notification positioning for RTL/LTR */
    .error-notification, .success-notification {
        transition: all 0.3s ease-in-out;
    }

    .error-notification.rtl, .success-notification.rtl {
        right: auto;
        left: 1rem;
    }

    .error-notification.ltr, .success-notification.ltr {
        left: auto;
        right: 1rem;
    }
</style>
@endpush

@section('employee-content')

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div id="welcome-section" class="mb-8 text-center section-visible">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-12 shadow-lg">
                <div id="welcome-text" class="opacity-100 transition-all duration-1000">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ app()->getLocale() === 'ar' ? 'مرحباً بك في مقابلة الذكاء الاصطناعي' : 'Welcome to your AI-assisted interview' }}
                    </h1>
                </div>
                
                <div id="welcome-message" class="opacity-100 transition-all duration-1000 mt-8">
                    <div class="bg-white rounded-xl p-8 shadow-md max-w-2xl mx-auto">
                        <div class="flex items-center justify-center mb-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-lg text-gray-700 mb-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ app()->getLocale() === 'ar' ? 'مرحباً. سأطرح عليك بضع أسئلة حول ملفك الشخصي.' : 'Welcome. I will ask you a few questions about your portfolio.' }}
                        </p>
                        <p class="text-sm text-gray-600" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ app()->getLocale() === 'ar' ? 'يرجى التأكد من تشغيل الكاميرا والميكروفون الخاص بك.' : 'Please make sure your camera and microphone are enabled.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Selection -->
        <div id="language-selection" class="mb-8 section-hidden" style="display: none;">
            <div class="bg-white rounded-xl p-8 shadow-md text-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                    {{ app()->getLocale() === 'ar' ? 'هل تفضل اللغة الإنجليزية أم العربية؟' : 'Do you prefer English or Arabic?' }}
                </h3>
                <div class="flex gap-4 justify-center">
                    <button onclick="selectLanguage('en')" class="language-btn bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                        English
                    </button>
                    <button onclick="selectLanguage('ar')" class="language-btn bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                        العربية
                    </button>
                </div>
            </div>
        </div>

        <!-- Question Section -->
        <div id="question-section" class="section-hidden" style="display: none;">
            <div class="bg-white rounded-xl p-8 shadow-md">
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ app()->getLocale() === 'ar' ? 'السؤال' : 'Question' }} {{ $currentQuestion ? $currentQuestion->question_order : 1 }} {{ app()->getLocale() === 'ar' ? 'من' : 'of' }} {{ $questions->count() }}
                        </span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $currentQuestion ? (($currentQuestion->question_order - 1) / $questions->count()) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 question-text {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ $currentQuestion ? $currentQuestion->localized_question : '' }}
                    </h3>
                </div>

                <!-- Timer Display -->
                <div id="timer-container" class="timer-container hidden">
                    <div class="text-sm text-gray-600 mb-2" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ app()->getLocale() === 'ar' ? 'الوقت المتبقي:' : 'Time remaining:' }}
                    </div>
                    <div id="timer" class="timer">02:00</div>
                </div>

                <!-- Recording Controls -->
                <div class="space-y-4">
                    <div class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                        <button id="record-btn" onclick="startRecording()" 
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'تسجيل' : 'Record' }}
                            </span>
                        </button>
                        
                        <button id="stop-btn" onclick="stopRecording()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors hidden">
                            <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'إيقاف' : 'Stop' }}
                            </span>
                        </button>
                    </div>

                    <!-- Live Video Preview Container -->
                    <div id="live-preview-container" class="hidden mb-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-800 mb-3 text-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'معاينة مباشرة:' : 'Live Preview:' }}
                            </h4>
                            <video id="live-video" autoplay muted class="video-preview"></video>
                        </div>
                    </div>

                    <!-- Recording Status -->
                    <div id="recording-status" class="text-center hidden">
                        <div class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full">
                            <div class="w-2 h-2 bg-red-600 rounded-full mr-2 rtl:ml-2 animate-pulse"></div>
                            <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'جاري التسجيل...' : 'Recording...' }}
                            </span>
                        </div>
                    </div>

                    <!-- Video Player -->
                    <div id="video-player" class="hidden">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-800 mb-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'شاهد تسجيلك:' : 'Watch your recording:' }}
                            </h4>
                            <video id="recorded-video" controls class="video-preview"></video>
                            <div class="flex gap-3 mt-3 justify-center">
                                <button onclick="playRecording()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'تشغيل' : 'Play' }}
                                    </span>
                                </button>
                                <button onclick="reRecord()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm">
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'إعادة تسجيل' : 'Re-record' }}
                                    </span>
                                </button>
                                <button id="submit-btn" onclick="submitRecording()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'إرسال' : 'Submit' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completion Section -->
        <div id="completion-section" class="section-hidden" style="display: none;">
            <div class="bg-white rounded-xl p-8 shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                    {{ app()->getLocale() === 'ar' ? 'تم إكمال المقابلة بنجاح!' : 'Interview completed successfully!' }}
                </h3>
                <p class="text-gray-600 mb-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                    {{ app()->getLocale() === 'ar' ? 'شكراً لك على وقتك. سنراجع إجاباتك وسنتواصل معك قريباً.' : 'Thank you for your time. We will review your answers and get back to you soon.' }}
                </p>
                <a href="{{ route('employee.job-seeker-dashboard') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ app()->getLocale() === 'ar' ? 'العودة إلى لوحة التحكم' : 'Back to Dashboard' }}
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let mediaRecorder;
    let videoChunks = [];
    let currentQuestion = @json($currentQuestion);
    let questions = @json($questions);
    let currentLanguage = '{{ app()->getLocale() }}';
    let isRecording = false;
    let timerInterval;
    let timeRemaining = 120; // 2 minutes in seconds

    // Helper function to show/hide sections properly
    function showSection(sectionId) {
        const section = document.getElementById(sectionId);
        section.style.display = 'block';
        // Small delay to ensure display is set before adding visible class
        setTimeout(() => {
            section.classList.remove('section-hidden');
            section.classList.add('section-visible');
        }, 10);
    }

    function hideSection(sectionId) {
        const section = document.getElementById(sectionId);
        section.classList.remove('section-visible');
        section.classList.add('section-hidden');
        // Hide the element after transition
        setTimeout(() => {
            section.style.display = 'none';
        }, 500);
    }

    // Timer functions
    function startTimer() {
        timeRemaining = 120; // Reset to 2 minutes
        updateTimerDisplay();
        
        timerInterval = setInterval(() => {
            timeRemaining--;
            updateTimerDisplay();
            
            if (timeRemaining <= 0) {
                stopRecording();
            }
        }, 1000);
    }

    function stopTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        const timerElement = document.getElementById('timer');
        
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Update timer color based on remaining time
        timerElement.className = 'timer';
        if (timeRemaining <= 30) {
            timerElement.classList.add('danger');
        } else if (timeRemaining <= 60) {
            timerElement.classList.add('warning');
        }
    }

    // Welcome animation sequence - simplified
    document.addEventListener('DOMContentLoaded', function() {
        // Show welcome text immediately
        document.getElementById('welcome-text').style.opacity = '1';
        
        // Show welcome message after 1 second
        setTimeout(() => {
            document.getElementById('welcome-message').style.opacity = '1';
        }, 1000);
        
        // Show language selection after 2 seconds
        setTimeout(() => {
            showSection('language-selection');
        }, 2000);
    });

    function selectLanguage(lang) {
        currentLanguage = lang;
        
        // Hide welcome and language selection sections
        hideSection('welcome-section');
        hideSection('language-selection');
        
        // Show question section
        setTimeout(() => {
            showSection('question-section');
        }, 500);
    }

    async function startRecording() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: true, 
                audio: true 
            });
            
            // Get supported MIME types for video
            const mimeType = MediaRecorder.isTypeSupported('video/webm') ? 'video/webm' : 
                            MediaRecorder.isTypeSupported('video/mp4') ? 'video/mp4' : 
                            MediaRecorder.isTypeSupported('video/ogg') ? 'video/ogg' : 'video/webm';
            
            mediaRecorder = new MediaRecorder(stream, { mimeType: mimeType });
            videoChunks = [];

            mediaRecorder.ondataavailable = (event) => {
                videoChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                const videoBlob = new Blob(videoChunks, { type: mimeType });
                const videoUrl = URL.createObjectURL(videoBlob);
                document.getElementById('recorded-video').src = videoUrl;
                document.getElementById('video-player').classList.remove('hidden');
                
                // Store the MIME type for submission
                window.recordedMimeType = mimeType;
            };

            mediaRecorder.start();
            isRecording = true;
            
            // Show live preview
            const liveVideo = document.getElementById('live-video');
            liveVideo.srcObject = stream;
            document.getElementById('live-preview-container').classList.remove('hidden');
            
            // Start timer and show timer container
            startTimer();
            document.getElementById('timer-container').classList.remove('hidden');
            
            document.getElementById('record-btn').classList.add('hidden');
            document.getElementById('stop-btn').classList.remove('hidden');
            document.getElementById('recording-status').classList.remove('hidden');
            
        } catch (error) {
            console.error('Error accessing camera/microphone:', error);
            
            // Show user-friendly error message
            const errorMessage = error.name === 'NotAllowedError' 
                ? 'Camera and microphone access denied. Please allow access and refresh the page.'
                : 'Unable to access camera/microphone. Please check your device permissions.';
            
            // Create and show error notification
            showErrorNotification(errorMessage);
        }
    }

    function stopRecording() {
        if (mediaRecorder && isRecording) {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
            isRecording = false;
            
            // Hide live preview
            const liveVideo = document.getElementById('live-video');
            liveVideo.srcObject = null;
            document.getElementById('live-preview-container').classList.add('hidden');

            // Stop timer and hide timer container
            stopTimer();
            document.getElementById('timer-container').classList.add('hidden');
            
            document.getElementById('record-btn').classList.remove('hidden');
            document.getElementById('stop-btn').classList.add('hidden');
            document.getElementById('recording-status').classList.add('hidden');
        }
    }

    function playRecording() {
        document.getElementById('recorded-video').play();
    }

    function reRecord() {
        document.getElementById('video-player').classList.add('hidden');
        videoChunks = [];
        // Reset timer display
        timeRemaining = 120;
        updateTimerDisplay();
    }

    async function submitRecording() {
        // Validate recording exists
        if (!videoChunks || videoChunks.length === 0) {
            showErrorNotification('No recording available. Please record your answer first.');
            return;
        }

        if (!window.recordedMimeType) {
            showErrorNotification('Recording format not detected. Please try recording again.');
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                {{ app()->getLocale() === 'ar' ? 'جاري الإرسال...' : 'Submitting...' }}
            </span>
        `;
        submitBtn.disabled = true;

        const videoBlob = new Blob(videoChunks, { type: window.recordedMimeType });
        const formData = new FormData();
        
        // Get the correct file extension based on MIME type
        const fileExtension = window.recordedMimeType === 'video/webm' ? 'webm' :
                             window.recordedMimeType === 'video/mp4' ? 'mp4' :
                             window.recordedMimeType === 'video/ogg' ? 'ogg' : 'webm';
        
        formData.append('audio_file', videoBlob, `recording.${fileExtension}`);
        formData.append('recording_duration', Math.ceil(videoBlob.size / 1000)); // Approximate duration

        try {
            const response = await fetch(`/interview/${currentQuestion.interview_id}/questions/${currentQuestion.id}/response`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            });

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                // Response is not JSON, get the text to see what it is
                const responseText = await response.text();
                throw new Error(`Server returned non-JSON response: ${response.status} ${response.statusText}`);
            }

            const result = await response.json();
            
            if (result.success) {
                if (result.is_completed) {
                    // Interview completed - hide question section and show completion
                    showSuccessNotification('Interview completed successfully!');
                    hideSection('question-section');
                    setTimeout(() => {
                        showSection('completion-section');
                    }, 500);
                } else if (result.next_question) {
                    // Move to next question
                    showSuccessNotification('Response recorded successfully!');
                    currentQuestion = result.next_question;
                    updateQuestionDisplay();
                    document.getElementById('video-player').classList.add('hidden');
                }
            } else {
                showErrorNotification('Error: ' + result.message);
            }
        } catch (error) {
            showErrorNotification('Error submitting recording: ' + error.message);
        } finally {
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    function updateQuestionDisplay() {
        // Update question text and progress
        const questionText = currentLanguage === 'ar' ? currentQuestion.question_text_ar : currentQuestion.question_text;
        const questionElement = document.querySelector('#question-section h3');
        questionElement.textContent = questionText;
        
        // Update CSS classes for proper text alignment
        questionElement.className = `text-xl font-semibold text-gray-800 mb-4 question-text ${currentLanguage === 'ar' ? 'rtl' : 'ltr'}`;
        questionElement.setAttribute('dir', currentLanguage === 'ar' ? 'rtl' : 'ltr');
        
        const progress = ((currentQuestion.question_order - 1) / questions.length) * 100;
        document.querySelector('#question-section .bg-blue-600').style.width = progress + '%';
        
        document.querySelector('#question-section .text-sm').textContent = 
            `${currentLanguage === 'ar' ? 'السؤال' : 'Question'} ${currentQuestion.question_order} ${currentLanguage === 'ar' ? 'من' : 'of'} ${questions.length}`;
    }

    // Error notification function
    function showErrorNotification(message) {
        // Remove existing error notifications
        const existingError = document.querySelector('.error-notification');
        if (existingError) {
            existingError.remove();
        }
        
        // Create error notification
        const errorDiv = document.createElement('div');
        const isRTL = currentLanguage === 'ar';
        errorDiv.className = `error-notification fixed top-4 ${isRTL ? 'left-4' : 'right-4'} bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 max-w-md ${isRTL ? 'rtl' : 'ltr'}`;
        errorDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(errorDiv);
        
        // Auto-remove after 8 seconds
        setTimeout(() => {
            if (errorDiv.parentElement) {
                errorDiv.remove();
            }
        }, 8000);
    }

    // Success notification function
    function showSuccessNotification(message) {
        // Remove existing success notifications
        const existingSuccess = document.querySelector('.success-notification');
        if (existingSuccess) {
            existingSuccess.remove();
        }
        
        // Create success notification
        const successDiv = document.createElement('div');
        const isRTL = currentLanguage === 'ar';
        successDiv.className = `success-notification fixed top-4 ${isRTL ? 'left-4' : 'right-4'} bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 max-w-md ${isRTL ? 'rtl' : 'ltr'}`;
        successDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(successDiv);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (successDiv.parentElement) {
                successDiv.remove();
            }
        }, 5000);
    }

</script>
@endpush
@endsection

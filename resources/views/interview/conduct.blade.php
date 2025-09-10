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

    /* Permissions warning styling */
    #permissions-warning {
        animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* RTL specific adjustments for permissions warning */
    #permissions-warning.rtl {
        text-align: right;
    }

    #permissions-warning.rtl .flex {
        flex-direction: row-reverse;
    }

    #permissions-warning.rtl .space-x-4 > * + * {
        margin-left: 0;
        margin-right: 1rem;
    }

    #permissions-warning.ltr {
        text-align: left;
    }

    /* Enhanced warning styling */
    #permissions-warning .bg-amber-100 {
        background-color: #fef3c7;
        border-color: #f59e0b;
    }

    #permissions-warning .border-amber-300 {
        border-color: #f59e0b;
    }

    /* Camera preview styling */
    #camera-preview {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        transition: border-color 0.3s ease;
    }

    #camera-preview:hover {
        border-color: #3b82f6;
    }

    /* Professional video interface styling */
    #main-video {
        transition: all 0.3s ease-in-out;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform-origin: center center;
    }

    #main-video:hover {
        transform: scale(1.02);
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }

    /* Mirror effect styling */
    #main-video.mirrored {
        transform: scaleX(-1);
    }



    /* Recording overlay styling */
    #recording-overlay {
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 32px rgba(220, 38, 38, 0.3);
    }

    /* Status icon animations */
    #video-status-icon {
        transition: all 0.3s ease-in-out;
    }

    #video-status-icon:hover {
        transform: scale(1.1);
    }

    /* Button hover effects */
    .group:hover .w-6 {
        transform: scale(1.1);
        transition: transform 0.2s ease-in-out;
    }

    /* Review actions styling */
    #review-actions {
        animation: slideInUp 0.6s ease-out;
    }

    /* Timer styling */
    #timer-container {
        animation: fadeInScale 0.4s ease-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* RTL specific adjustments for video interface */
    #permissions-warning.rtl #recording-overlay {
        right: auto;
        left: 1rem;
    }

    #permissions-warning.ltr #recording-overlay {
        left: auto;
        right: 1rem;
    }
</style>
@endpush

@section('employee-content')

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm text-gray-500 text-left" dir="rtl">
            <a href="{{ route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()]) }}" class="hover:text-gray-700">لوحة التحكم</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-700">المقابلة</span>
        </nav>
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
                            {{ app()->getLocale() === 'ar' ? 'مرحباً. ستحتاج لتسجيل فيديو قصير عن نفسك.' : 'Welcome. You will need to record a short video about yourself.' }}
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

        <!-- Privacy & Permissions Warning -->
        <div id="permissions-warning" class="mb-8 section-hidden" style="display: none;">
            <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-8 shadow-lg">
                <div class="flex items-start space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-amber-800 mb-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ app()->getLocale() === 'ar' ? 'تنبيه مهم: الوصول إلى الكاميرا والميكروفون' : 'Important Notice: Camera & Microphone Access Required' }}
                        </h3>
                        <div class="text-amber-700 space-y-3" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                            <p class="leading-relaxed">
                                {{ app()->getLocale() === 'ar' ? 'نحتاج إلى الوصول إلى كاميرا الويب والميكروفون الخاص بك لإجراء هذه المقابلة.' : 'We need access to your webcam and microphone to conduct this interview.' }}
                            </p>
                            <p class="leading-relaxed">
                                {{ app()->getLocale() === 'ar' ? 'عند النقر على "أفهم وأوافق على المتابعة"، سيطلب منك المتصفح السماح بالوصول إلى الكاميرا والميكروفون.' : 'When you click "I Understand & Agree to Continue", your browser will ask for permission to access your camera and microphone.' }}
                            </p>
                            <p class="leading-relaxed">
                                {{ app()->getLocale() === 'ar' ? 'معلوماتك محمية ومؤمنة ولن يتم مشاهدتها من قبل أي شخص باستثناء مدير التوظيف للوظائف التي تتقدم إليها.' : 'Your information is secured and will not be viewed by anyone except the hiring manager for the job(s) you apply for.' }}
                            </p>
                            <div class="bg-amber-100 border border-amber-200 rounded-lg p-4 mt-4">
                                <p class="text-sm font-medium text-amber-800" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                    {{ app()->getLocale() === 'ar' ? '🔒 حماية الخصوصية: جميع التسجيلات مشفرة ومخزنة بأمان' : '🔒 Privacy Protection: All recordings are encrypted and stored securely' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <button onclick="proceedToInterview()" 
                                    class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                    {{ app()->getLocale() === 'ar' ? 'أفهم وأوافق على المتابعة' : 'I Understand & Agree to Continue' }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audio element for interview sound -->
        <audio id="interview-sound" preload="auto">
            <source src="{{ asset('interview-sound.mp3') }}" type="audio/mpeg">
        </audio>

        <!-- Recording Section -->
        <div id="question-section" class="section-hidden" style="display: none;">
            <div class="bg-white rounded-xl p-8 shadow-md">
                <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6 shadow-sm">
                    <div class="flex items-start space-x-3 rtl:space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 question-text rtl" dir="rtl">
                                تحدث عن نفسك بإيجاز (لمدة 60 ثانية)
                            </h3>
                            <p class="text-base text-gray-700 leading-relaxed" dir="rtl">
                                الأسم، المهارات، الخبرات، الدورات التدريبية و احرص على ان يكون اسلوبك مميز 
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Timer Display -->
                <div id="timer-container" class="timer-container hidden">
                    <div class="text-sm text-gray-600 mb-2" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                        {{ app()->getLocale() === 'ar' ? 'الوقت المتبقي:' : 'Time remaining:' }}
                    </div>
                    <div id="timer" class="timer">01:00</div>
                </div>

                <!-- Professional Video Interface -->
                <div class="space-y-6">
                    <!-- Single Video Display Container -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-100 rounded-2xl p-8 shadow-lg border border-gray-200">
                        <!-- Video Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                <div id="video-status-icon" class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg id="status-svg" class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 id="video-status-title" class="text-lg font-semibold text-gray-800" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'معاينة الكاميرا' : 'Camera Preview' }}
                                    </h4>
                                    <p id="video-status-subtitle" class="text-sm text-gray-600" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'تأكد من أن الكاميرا تعمل بشكل صحيح' : 'Ensure your camera is working properly' }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Timer Display -->
                            <div id="timer-container" class="hidden">
                                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-2">
                                    <div class="text-xs text-red-600 mb-1" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'الوقت المتبقي' : 'Time Remaining' }}
                                    </div>
                                    <div id="timer" class="text-xl font-bold text-red-700">01:00</div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Video Element -->
                        <div class="relative">
                            <video id="main-video" autoplay muted class="w-full max-w-2xl mx-auto rounded-xl shadow-2xl border-4 border-white"></video>
                            

                            
                            <!-- Recording Overlay -->
                            <div id="recording-overlay" class="hidden absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'جاري التسجيل' : 'RECORDING' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Control Buttons -->
                    <div class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                        <!-- Record Button -->
                        <button id="record-btn" onclick="startRecording()" 
                                class="group bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-3 rtl:space-x-reverse">
                            <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </div>
                            <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'بدء التسجيل' : 'Begin Recording' }}
                            </span>
                        </button>
                        
                        <!-- Stop Button -->
                        <button id="stop-btn" onclick="stopRecording()" 
                                class="hidden group bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-3 rtl:space-x-reverse">
                            <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'إيقاف التسجيل' : 'Stop Recording' }}
                            </span>
                        </button>
                    </div>

                    <!-- Review Actions (Hidden until recording is complete) -->
                    <div id="review-actions" class="hidden">
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'مراجعة التسجيل' : 'Review Your Recording' }}
                            </h4>
                            <p class="text-gray-600 text-center mb-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                {{ app()->getLocale() === 'ar' ? 'شاهد تسجيلك وتأكد من رضاك عنه قبل المتابعة' : 'Watch your recording and confirm you are satisfied before proceeding' }}
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                                <button onclick="playRecording()" 
                                        class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg sm:rounded-xl font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center justify-center space-x-2 rtl:space-x-reverse text-sm sm:text-base">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'تشغيل' : 'Play' }}
                                    </span>
                                </button>
                                
                                <button onclick="reRecord()" 
                                        class="group bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg sm:rounded-xl font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center justify-center space-x-2 rtl:space-x-reverse text-sm sm:text-base">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'إعادة تسجيل' : 'Re-record' }}
                                    </span>
                                </button>
                                
                                <button id="submit-btn" onclick="submitRecording()" 
                                        class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg sm:rounded-xl font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center justify-center space-x-2 rtl:space-x-reverse text-sm sm:text-base">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                                        {{ app()->getLocale() === 'ar' ? 'تأكيد والمتابعة' : 'Confirm & Continue' }}
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
                    {{ app()->getLocale() === 'ar' ? 'تم إكمال التسجيل بنجاح!' : 'Recording completed successfully!' }}
                </h3>
                <p class="text-gray-600 mb-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                    {{ app()->getLocale() === 'ar' ? 'شكراً لك على وقتك. سنراجع تسجيلك وسنتواصل معك قريباً.' : 'Thank you for your time. We will review your recording and get back to you soon.' }}
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
    let timeRemaining = 60; // 1 minute in seconds
    let isMirrored = true; // Always mirrored by default

    // Debug logging for currentQuestion
    console.log('Current question data:', currentQuestion);
    console.log('Questions data:', questions);
    
    // Test debug endpoint
    if (currentQuestion && currentQuestion.interview_id) {
        const debugUrl = `${window.location.pathname}/debug`;
        console.log('Testing debug endpoint:', debugUrl);
        fetch(debugUrl)
            .then(response => response.json())
            .then(data => console.log('Debug endpoint response:', data))
            .catch(error => console.error('Debug endpoint error:', error));
    }

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
        timeRemaining = 60; // Reset to 1 minute
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
        
        // Show permissions warning first
        setTimeout(() => {
            showSection('permissions-warning');
            // Update warning text based on selected language
            updateWarningText(lang);
            // Update button text based on selected language
            updateButtonText(lang);
        }, 500);
    }

    async function proceedToInterview() {
        // Hide permissions warning
        hideSection('permissions-warning');
        
        // Show question section
        setTimeout(async () => {
            showSection('question-section');
            
            // Request all permissions upfront (camera + audio)
            const permissionsGranted = await requestAllPermissions();
            
            if (permissionsGranted) {
                // Set initial state
                updateVideoInterface('preview');
            } else {
                // If permissions denied, show error and go back
                hideSection('question-section');
                showSection('permissions-warning');
            }
        }, 500);
    }

    // Function to update warning text based on selected language
    function updateWarningText(lang) {
        const warningTitle = document.getElementById('permissions-warning').querySelector('h3');
        const warningContent = document.getElementById('permissions-warning').querySelector('.text-amber-700');
        const privacyNote = document.getElementById('permissions-warning').querySelector('.bg-amber-100 p');
        const proceedButton = document.getElementById('permissions-warning').querySelector('button span');
        
        if (lang === 'ar') {
            // Arabic text
            warningTitle.textContent = 'تنبيه مهم: الوصول إلى الكاميرا والميكروفون';
            warningTitle.setAttribute('dir', 'rtl');
            warningContent.setAttribute('dir', 'rtl');
            warningContent.innerHTML = `
                <p class="leading-relaxed">
                    نحتاج إلى الوصول إلى كاميرا الويب والميكروفون الخاص بك لإجراء هذه المقابلة.
                </p>
                <p class="leading-relaxed">
                    عند النقر على "أفهم وأوافق على المتابعة"، سيطلب منك المتصفح السماح بالوصول إلى الكاميرا والميكروفون.
                </p>
                <p class="leading-relaxed">
                    معلوماتك محمية ومؤمنة ولن يتم مشاهدتها من قبل أي شخص باستثناء مدير التوظيف للوظائف التي تتقدم إليها.
                </p>
            `;
            privacyNote.textContent = '🔒 حماية الخصوصية: جميع التسجيلات مشفرة ومخزنة بأمان';
            privacyNote.setAttribute('dir', 'rtl');
            proceedButton.textContent = 'أفهم وأوافق على المتابعة';
            proceedButton.setAttribute('dir', 'rtl');
            
            // Update container classes for RTL
            document.getElementById('permissions-warning').classList.add('rtl');
            document.getElementById('permissions-warning').classList.remove('ltr');
        } else {
            // English text
            warningTitle.textContent = 'Important Notice: Camera & Microphone Access Required';
            warningTitle.setAttribute('dir', 'ltr');
            warningContent.setAttribute('dir', 'ltr');
            warningContent.innerHTML = `
                <p class="leading-relaxed">
                    We need access to your webcam and microphone to conduct this interview.
                </p>
                <p class="leading-relaxed">
                    When you click "I Understand & Agree to Continue", your browser will ask for permission to access your camera and microphone.
                </p>
                <p class="leading-relaxed">
                    Your information is secured and will not be viewed by anyone except the hiring manager for the job(s) you apply for.
                </p>
            `;
            privacyNote.textContent = '🔒 Privacy Protection: All recordings are encrypted and stored securely';
            privacyNote.setAttribute('dir', 'ltr');
            proceedButton.textContent = 'I Understand & Agree to Continue';
            proceedButton.setAttribute('dir', 'ltr');
            
            // Update container classes for LTR
            document.getElementById('permissions-warning').classList.add('ltr');
            document.getElementById('permissions-warning').classList.remove('rtl');
        }
    }

    // Function to request all permissions upfront (camera + audio)
    async function requestAllPermissions() {
        try {
            console.log('Requesting all permissions (camera + audio)...');
            
            // Request both camera and audio permissions at once
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: true, 
                audio: true // Request audio permission upfront
            });
            
            console.log('All permissions granted, stream obtained:', stream);
            
            // Store the stream for later use
            window.fullMediaStream = stream;
            
            // Initialize camera preview with the full stream
            await initializeCameraPreview(stream);
            
            return true;
            
        } catch (error) {
            console.error('Error requesting permissions:', error);
            
            // Show user-friendly error message
            const errorMessage = error.name === 'NotAllowedError' 
                ? 'Camera and microphone access denied. Please allow access and refresh the page.'
                : 'Unable to access camera/microphone. Please check your device permissions.';
            
            showErrorNotification(errorMessage);
            return false;
        }
    }

    // Function to initialize camera preview with existing stream
    async function initializeCameraPreview(stream = null) {
        try {
            console.log('Initializing camera preview...');
            
            // Use provided stream or get new one
            if (!stream && window.fullMediaStream) {
                stream = window.fullMediaStream;
            } else if (!stream) {
                // Fallback: request permissions again
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: true, 
                    audio: true
                });
                window.fullMediaStream = stream;
            }
            
            console.log('Camera stream obtained:', stream);
            
            const mainVideo = document.getElementById('main-video');
            if (!mainVideo) {
                console.error('Main video element not found in initializeCameraPreview');
                return;
            }
            
            console.log('Setting video stream and ensuring visibility...');
            mainVideo.srcObject = stream;
            
            // Ensure video is visible
            mainVideo.classList.remove('hidden');
            
            // Always apply mirror effect for natural user experience
            mainVideo.style.transform = 'scaleX(-1)';
            
            console.log('Camera preview initialized successfully');
            
            // Check final video visibility state
            checkVideoVisibility();
            
        } catch (error) {
            console.error('Error accessing camera for preview:', error);
            // Don't show error notification here, just log it
            // User will see the error when they try to record
        }
    }

    // Function to update button text based on language
    function updateButtonText(lang) {
        const recordBtn = document.getElementById('record-btn');
        const stopBtn = document.getElementById('stop-btn');
        
        if (!recordBtn || !stopBtn) {
            console.warn('Record or stop button not found in updateButtonText');
            return;
        }
        
        const recordBtnSpan = recordBtn.querySelector('span');
        const stopBtnSpan = stopBtn.querySelector('span');
        
        if (!recordBtnSpan || !stopBtnSpan) {
            console.warn('Button span elements not found in updateButtonText');
            return;
        }
        
        if (lang === 'ar') {
            recordBtnSpan.textContent = 'بدء التسجيل';
            recordBtnSpan.setAttribute('dir', 'rtl');
            stopBtnSpan.textContent = 'إيقاف التسجيل';
            stopBtnSpan.setAttribute('dir', 'rtl');
        } else {
            recordBtnSpan.textContent = 'Begin Recording';
            recordBtnSpan.setAttribute('dir', 'ltr');
            stopBtnSpan.textContent = 'Stop Recording';
            stopBtnSpan.setAttribute('dir', 'ltr');
        }
    }



    // Helper function to safely get DOM elements
    function safeGetElement(id, context = 'function') {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Element with ID '${id}' not found in ${context}`);
            return null;
        }
        return element;
    }

    // Function to update video interface based on current state
    function updateVideoInterface(state, stream = null) {
        const mainVideo = document.getElementById('main-video');
        const statusIcon = document.getElementById('video-status-icon');
        const statusSvg = document.getElementById('status-svg');
        const statusTitle = document.getElementById('video-status-title');
        const statusSubtitle = document.getElementById('video-status-subtitle');
        const recordingOverlay = document.getElementById('recording-overlay');
        const reviewActions = document.getElementById('review-actions');
        
        // Check if all required elements exist
        if (!mainVideo || !statusIcon || !statusSvg || !statusTitle || !statusSubtitle || !recordingOverlay || !reviewActions) {
            console.warn('One or more video interface elements not found in updateVideoInterface');
            return;
        }
        
        if (state === 'preview') {
            // Camera preview state
            statusIcon.className = 'w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center';
            statusSvg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
            statusTitle.textContent = currentLanguage === 'ar' ? 'معاينة الكاميرا' : 'Camera Preview';
            statusSubtitle.textContent = currentLanguage === 'ar' ? 'تأكد من أن الكاميرا تعمل بشكل صحيح' : 'Ensure your camera is working properly';
            recordingOverlay.classList.add('hidden');
            reviewActions.classList.add('hidden');
            
            // Ensure video is visible and properly configured for preview
            mainVideo.classList.remove('hidden');
            mainVideo.controls = false;
            mainVideo.autoplay = true;
            mainVideo.muted = true;
            
        } else if (state === 'recording') {
            // Recording state
            statusIcon.className = 'w-8 h-8 bg-red-100 rounded-full flex items-center justify-center';
            statusSvg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>';
            statusTitle.textContent = currentLanguage === 'ar' ? 'جاري التسجيل' : 'Recording in Progress';
            statusSubtitle.textContent = currentLanguage === 'ar' ? 'تسجيل إجابتك على السؤال' : 'Recording your answer to the question';
            recordingOverlay.classList.remove('hidden');
            reviewActions.classList.add('hidden');
            
            // Ensure video is visible and properly configured for recording
            mainVideo.classList.remove('hidden');
            mainVideo.controls = false;
            mainVideo.autoplay = true;
            mainVideo.muted = true;
            
            if (stream) {
                mainVideo.srcObject = stream;
            }
            
        } else if (state === 'review') {
            // Review state
            statusIcon.className = 'w-8 h-8 bg-green-100 rounded-full flex items-center justify-center';
            statusSvg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            statusTitle.textContent = currentLanguage === 'ar' ? 'مراجعة التسجيل' : 'Review Recording';
            statusSubtitle.textContent = currentLanguage === 'ar' ? 'شاهد تسجيلك وتأكد من رضاك عنه' : 'Watch your recording and confirm satisfaction';
            recordingOverlay.classList.add('hidden');
            reviewActions.classList.remove('hidden');
            
            // Ensure video is visible and properly configured for review
            mainVideo.classList.remove('hidden');
            mainVideo.controls = true;
            mainVideo.autoplay = false;
            mainVideo.muted = false;
        }
    }

    async function startRecording() {
        try {
            // Play interview sound when recording begins
            const interviewSound = document.getElementById('interview-sound');
            if (interviewSound) {
                try {
                    await interviewSound.play();
                    console.log('Interview sound played successfully');
                } catch (soundError) {
                    console.warn('Could not play interview sound:', soundError);
                    // Don't stop the recording process if sound fails
                }
            }

            // Use the pre-granted full media stream
            let stream;
            if (window.fullMediaStream) {
                // Use the existing stream that already has both video and audio
                stream = window.fullMediaStream;
                console.log('Using pre-granted media stream for recording');
            } else {
                // Fallback: request both video and audio (should not happen if permissions were granted)
                console.warn('No pre-granted stream found, requesting permissions again');
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: true, 
                    audio: true 
                });
                window.fullMediaStream = stream;
            }
            
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
                
                // Update main video to show recorded content
                const mainVideo = document.getElementById('main-video');
                mainVideo.src = videoUrl;
                mainVideo.srcObject = null; // Remove stream
                
                // Store the MIME type for submission
                window.recordedMimeType = mimeType;
            };

            mediaRecorder.start();
            isRecording = true;
            
            // Update video interface for recording state
            updateVideoInterface('recording', stream);
            
            // Start timer and show timer container
            startTimer();
            document.getElementById('timer-container').classList.remove('hidden');
            
            document.getElementById('record-btn').classList.add('hidden');
            document.getElementById('stop-btn').classList.remove('hidden');
            
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
            
            // Update video interface for review state
            updateVideoInterface('review');

            // Stop timer and hide timer container
            stopTimer();
            document.getElementById('timer-container').classList.add('hidden');
            
            document.getElementById('record-btn').classList.remove('hidden');
            document.getElementById('stop-btn').classList.add('hidden');
        }
    }

    function playRecording() {
        document.getElementById('main-video').play();
    }

    function reRecord() {
        // Reset to preview state
        updateVideoInterface('preview');
        videoChunks = [];
        // Reset timer display
        timeRemaining = 60;
        updateTimerDisplay();
        
        // Re-initialize camera preview with existing stream
        if (window.fullMediaStream) {
            initializeCameraPreview(window.fullMediaStream);
        } else {
            // Fallback: re-request permissions
            initializeCameraPreview();
        }
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
        
        // Check file size
        const fileSizeMB = (videoBlob.size / (1024 * 1024)).toFixed(2);
        console.log('File size check:', {
            size_bytes: videoBlob.size,
            size_mb: fileSizeMB,
            mime_type: window.recordedMimeType
        });
        
        // Check if file is too large (PHP limit is 1GB)
        if (videoBlob.size > 1024 * 1024 * 1024) {
            showErrorNotification(`File too large (${fileSizeMB}MB). Maximum size is 1GB. Please try again.`);
            return;
        }
        
        // Get the correct file extension based on MIME type
        const fileExtension = window.recordedMimeType === 'video/webm' ? 'webm' :
                             window.recordedMimeType === 'video/mp4' ? 'mp4' :
                             window.recordedMimeType === 'video/ogg' ? 'ogg' : 'webm';
        
        formData.append('audio_file', videoBlob, `recording.${fileExtension}`);
        
        // Use actual recording duration from timer, not file size
        const actualDuration = 60 - timeRemaining; // 60 seconds total - remaining time = actual recording time
        formData.append('recording_duration', Math.max(1, actualDuration)); // Ensure minimum 1 second
        
        console.log('Recording duration calculation:', {
            total_time: 60,
            time_remaining: timeRemaining,
            actual_duration: actualDuration,
            file_size_bytes: videoBlob.size,
            file_size_mb: fileSizeMB
        });

        try {
            // Debug logging
            console.log('Submitting recording for:', {
                interview_id: currentQuestion.interview_id,
                question_id: currentQuestion.id,
                currentQuestion: currentQuestion
            });
            
                    // Debug URL construction
        const pathSegments = window.location.pathname.split('/');
        const localeSegment = pathSegments[1];
        const baseUrl = localeSegment && (localeSegment === 'en' || localeSegment === 'ar') ? `/${localeSegment}` : '';
        const fullUrl = `${baseUrl}/interview/${currentQuestion.interview_id}/questions/${currentQuestion.id}/response`;
        
        console.log('URL construction:', {
            pathSegments: pathSegments,
            localeSegment: localeSegment,
            baseUrl: baseUrl,
            fullUrl: fullUrl,
            currentPath: window.location.pathname,
            currentQuestionData: currentQuestion
        });

        // Check if user is still authenticated
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token not found - user may not be authenticated');
            showErrorNotification('Authentication error. Please refresh the page and try again.');
            return;
        }
        
        console.log('CSRF token found:', csrfToken.getAttribute('content').substring(0, 10) + '...');

        // Test the basic interview route first
        try {
            console.log('Testing basic interview route...');
            
            // Test the debug route first (no auth required)
            const debugResponse = await fetch(`${baseUrl}/interview/debug-route`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });
            console.log('Debug route response:', {
                status: debugResponse.status,
                ok: debugResponse.ok,
                headers: Object.fromEntries(debugResponse.headers.entries())
            });
            
            if (debugResponse.ok) {
                const debugData = await debugResponse.json();
                console.log('Debug route data:', debugData);
            } else {
                console.error('Debug route failed:', debugResponse.status, debugResponse.statusText);
                const debugText = await debugResponse.text();
                console.error('Debug route response text:', debugText.substring(0, 200));
            }
            
            // Now test the authenticated route
            const testResponse = await fetch(`${baseUrl}/interview/${currentQuestion.interview_id}/test-response`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            console.log('Test route response:', {
                status: testResponse.status,
                ok: testResponse.ok,
                headers: Object.fromEntries(testResponse.headers.entries())
            });
            
            if (testResponse.ok) {
                const testData = await testResponse.json();
                console.log('Test route data:', testData);
            } else {
                console.error('Test route failed:', testResponse.status, testResponse.statusText);
                const testText = await testResponse.text();
                console.error('Test route response text:', testText.substring(0, 200));
            }
        } catch (testError) {
            console.error('Test route error:', testError);
        }
            
            // Additional validation
            if (!currentQuestion.interview_id) {
                console.error('Missing interview_id in currentQuestion:', currentQuestion);
                throw new Error('Interview ID is missing. Please refresh the page and try again.');
            }
            
            if (!currentQuestion.id) {
                console.error('Missing question id in currentQuestion:', currentQuestion);
                throw new Error('Question ID is missing. Please refresh the page and try again.');
            }

            // Check if we have the required IDs
            if (!currentQuestion.interview_id || !currentQuestion.id) {
                // Try to get interview_id from the questions array if available
                if (questions && questions.length > 0 && questions[0].interview_id) {
                    currentQuestion.interview_id = questions[0].interview_id;
                } else {
                    throw new Error('Missing interview or question ID. Please refresh the page and try again.');
                }
            }

            const response = await fetch(`${fullUrl}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            // Debug logging
            console.log('Response status:', response.status);
            console.log('Response headers:', Object.fromEntries(response.headers.entries()));

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                // Response is not JSON, get the text to see what it is
                const responseText = await response.text();
                console.error('Non-JSON response received:', responseText);
                throw new Error(`Server returned non-JSON response: ${response.status} ${response.statusText}. Response: ${responseText.substring(0, 200)}`);
            }

            const result = await response.json();
            
            // Always show completion after first question submission
            showSuccessNotification('Recording completed successfully!');
            hideSection('question-section');
            setTimeout(() => {
                showSection('completion-section');
            }, 500);
        } catch (error) {
            console.error('Full error details:', error);
            showErrorNotification('Error submitting recording: ' + error.message);
        } finally {
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
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

    // Global error handler for DOM element access
    window.addEventListener('error', function(event) {
        if (event.error && event.error.message && event.error.message.includes('classList')) {
            console.warn('DOM element access error detected:', event.error.message);
            console.warn('This usually means an element was not found in the DOM');
        }
    });

    // Helper function to check video visibility state
    function checkVideoVisibility() {
        const mainVideo = document.getElementById('main-video');
        if (!mainVideo) {
            console.warn('Video element not found in checkVideoVisibility');
            return;
        }
        
        const computedStyle = window.getComputedStyle(mainVideo);
        console.log('Video visibility state:', {
            element: mainVideo,
            hidden_class: mainVideo.classList.contains('hidden'),
            display: computedStyle.display,
            visibility: computedStyle.visibility,
            opacity: computedStyle.opacity,
            width: computedStyle.width,
            height: computedStyle.height,
            srcObject: mainVideo.srcObject ? 'has_stream' : 'no_stream',
            src: mainVideo.src || 'no_src'
        });
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

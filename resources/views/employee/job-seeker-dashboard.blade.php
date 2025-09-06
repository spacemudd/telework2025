@extends('layouts.employee')

@section('title', 'لوحة تحكم الباحث عن عمل')

@section('employee-content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-3xl font-bold text-gray-800 mb-8">مرحباً {{ auth()->user()->name }}</h1>

            <!-- Flash Messages -->
            @if(session('info'))
                <div class="mb-6 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM9 11v4h2v-4H9zm0-4h2v2H9V7z"/></svg></div>
                        <div>
                            <p class="font-bold">معلومة</p>
                            <p class="text-sm">{{ session('info') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                     <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM9 11v4h2v-4H9zm0-4h2v2H9V7z"/></svg></div>
                        <div>
                            <p class="font-bold">خطأ</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM9 11v4h2v-4H9zm0-4h2v2H9V7z"/></svg></div>
                        <div>
                            <p class="font-bold">نجاح</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @php
                // Calculate profile completeness based on 4 steps
                $stepsCompleted = 0;
                $totalSteps = 4;
                
                // Step 1: Profile details (always completed if user exists)
                $stepsCompleted++;
                
                // Step 2: CV uploaded
                if(auth()->user()->employee && auth()->user()->employee->cv_path) {
                    $stepsCompleted++;
                }
                
                // Step 3: First AI interview completed
                if(auth()->user()->employee && auth()->user()->employee->interviews()->where('status', 'completed')->exists()) {
                    $stepsCompleted++;
                }
                
                // Step 4: Applied to jobs
                if(auth()->user()->jobApplications()->exists()) {
                    $stepsCompleted++;
                }
                
                $completenessPercentage = round(($stepsCompleted / $totalSteps) * 100);
            @endphp

            <!-- Profile Completeness Card -->
            <div class="mb-8 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-1">اكتمال الملف الشخصي</h2>
                            <p class="text-sm text-gray-500">أكمل ملفك الشخصي لزيادة فرصك في التوظيف.</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-4xl font-bold text-blue-600">{{ $completenessPercentage }}%</div>
                            <div class="text-sm text-gray-500">مكتمل</div>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-gray-200 h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2" style="width: {{ $completenessPercentage }}%"></div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">تفاصيل الملف الشخصي</h3>
                                <p class="text-sm text-green-600 font-medium">مكتمل</p>
                            </div>
                        </div>
                        @if(auth()->user()->employee && auth()->user()->employee->cv_path)
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">رفع السيرة الذاتية</h3>
                                    <p class="text-sm text-green-600 font-medium">مكتمل</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('employee.cv.view', ['locale' => app()->getLocale()]) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <form action="{{ route('employee.cv.delete', ['locale' => app()->getLocale()]) }}" method="POST" onsubmit="return confirm('{{ __('words.are_you_sure') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="#" onclick="openCvUploadModal(event)" class="group flex items-center justify-between gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 group-hover:bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-4-4V6a2 2 0 012-2h10a2 2 0 012 2v6a4 4 0 01-4 4H7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2m11 0v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2m11 0h.01"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 group-hover:text-gray-800">رفع السيرة الذاتية</h3>
                                        <p class="text-sm text-gray-500 group-hover:text-gray-600">ابدأ الآن</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                             </a>
                        @endif
                        
                        @if(auth()->user()->employee->interviews()->where('status', 'completed')->exists())
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">إجراء أول مقابلة</h3>
                                    <p class="text-sm text-green-600 font-medium">مكتمل</p>
                                </div>
                            </div>
                        @elseif(($existingInterview = auth()->user()->employee->interviews()->whereIn('status', ['pending', 'in_progress'])->first()))
                            <a href="{{ route('interview.conduct', ['locale' => app()->getLocale(), 'interview' => $existingInterview->id]) }}" class="group flex items-center justify-between gap-3 p-4 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold">إجراء أول مقابلة</h3>
                                        <p class="text-sm opacity-80">قيد التقدم - اضغط للمتابعة</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('interview.start', ['locale' => app()->getLocale()]) }}" class="group flex items-center justify-between gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 group-hover:bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 group-hover:text-gray-800">إجراء أول مقابلة</h3>
                                        <p class="text-sm text-gray-500 group-hover:text-gray-600">ابدأ الآن</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif

                        @if(auth()->user()->jobApplications()->exists())
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">التقدم للوظائف</h3>
                                    <p class="text-sm text-green-600 font-medium">مكتمل</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('jobs.my-applications', ['locale' => app()->getLocale()]) }}" class="text-green-600 hover:text-green-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="group flex items-center justify-between gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 group-hover:bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 group-hover:text-gray-800">التقدم للوظائف</h3>
                                        <p class="text-sm text-gray-500 group-hover:text-gray-600">ابحث عن فرص</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Job Search Stats -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-3xl font-bold">0</p>
                                <h3 class="font-semibold">الطلبات النشطة</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-3xl font-bold">0</p>
                                <h3 class="font-semibold">المقابلات المجدولة</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                            </div>
                            <div>
                                <p class="text-3xl font-bold">0</p>
                                <h3 class="font-semibold">الوظائف المعروضة</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Summary -->
            <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                    <h2 class="text-xl font-bold text-gray-800">ملخص الملف الشخصي</h2>
                    <a href="#" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform hover:scale-105">
                        تعديل الملف الشخصي
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">مستوى الخبرة</p>
                        <p class="text-base text-gray-800 font-semibold">
                            @switch(session('job_seeker_experience_level', 'entry'))
                                @case('entry') مبتدئ (0-2 سنوات) @break
                                @case('mid_level') متوسط (3-5 سنوات) @break
                                @case('senior') متقدم (6-10 سنوات) @break
                                @case('expert') خبير (10+ سنوات) @break
                                @default مبتدئ (0-2 سنوات)
                            @endswitch
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">نوع العمل المفضل</p>
                         <p class="text-base text-gray-800 font-semibold">
                            @switch(session('job_seeker_preferred_work_type', 'full_time'))
                                @case('full_time') دوام كامل @break
                                @case('part_time') دوام جزئي @break
                                @case('contract') عقد @break
                                @case('freelance') عمل حر @break
                                @default دوام كامل
                            @endswitch
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1 font-medium">المهارات</p>
                        <div class="flex flex-wrap gap-2">
                             @foreach(explode(',', session('job_seeker_skills', '')) as $skill)
                                @if(trim($skill))
                                    <span class="inline-block bg-gray-100 text-gray-700 text-sm font-medium px-3 py-1 rounded-full">{{ trim($skill) }}</span>
                                @endif
                            @endforeach
                            @if(!session('job_seeker_skills'))
                                <p class="text-sm text-gray-500">المهارات لم يتم تحديثها بعد</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Jobs -->
            <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl font-bold text-gray-800">الوظائف المتاحة لك</h2>
                    <button class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-full text-blue-600 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform hover:scale-105">
                        تحديث الوظائف
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:border-blue-500">
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">مطور برمجيات متقدم</h3>
                                <p class="text-sm text-gray-600 mb-3">شركة حلول التقنية</p>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>عن بُعد</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>دوام كامل</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                                        <span>80,000 - 120,000 ر.س</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 mt-4">نحن نبحث عن مطور برمجيات متمرس للانضمام إلى فريقنا عن بُعد. يجب أن يكون المرشح المثالي لديه مهارات برمجة قوية وخبرة في تقنيات الويب الحديثة.</p>
                            </div>
                            <div class="flex-shrink-0 w-full sm:w-auto mt-4 sm:mt-0">
                                <button class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform hover:scale-105">
                                    تقدم الآن
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center py-12 bg-gray-50 rounded-2xl">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ __('words.browse_jobs') }}</h3>
                        <p class="mt-2 text-sm text-gray-500">استكشف الفرص الوظيفية المتاحة</p>
                        <div class="mt-6 space-x-2 rtl:space-x-reverse">
                            <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700">
                                {{ __('words.browse_jobs') }}
                            </a>
                            <a href="{{ route('jobs.my-applications', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                {{ __('words.my_applications') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">إجراءات سريعة</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                    <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="group">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full group-hover:bg-blue-200 transition-colors">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <p class="mt-3 text-sm font-medium text-gray-700 group-hover:text-blue-600">{{ __('words.search_jobs') }}</p>
                    </a>
                     <a href="{{ route('jobs.my-applications', ['locale' => app()->getLocale()]) }}" class="group">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 bg-green-100 rounded-full group-hover:bg-green-200 transition-colors">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="mt-3 text-sm font-medium text-gray-700 group-hover:text-green-600">{{ __('words.my_applications') }}</p>
                    </a>
                    <a href="#" class="group">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full group-hover:bg-purple-200 transition-colors">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="mt-3 text-sm font-medium text-gray-700 group-hover:text-purple-600">المقابلات</p>
                    </a>
                    <a href="#" class="group">
                        <div class="mx-auto flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full group-hover:bg-orange-200 transition-colors">
                           <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <p class="mt-3 text-sm font-medium text-gray-700 group-hover:text-orange-600">الإعدادات</p>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- CV Upload Modal -->
    <div id="cvUploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ __('words.upload_cv') }}</h3>
                    <button onclick="closeCvUploadModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
    
                <form id="cvUploadForm" method="POST" action="{{ route('employee.cv.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="cv_file" class="block text-sm font-medium mb-2">{{ __('words.select_cv_file') }}:</label>
                        <input type="file" name="cv" id="cv_file" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                        <p class="mt-1 text-sm text-gray-500">{{ __('words.cv_file_types') }}</p>
                    </div>
    
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" onclick="closeCvUploadModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm">
                            {{ __('words.close') }}
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                            {{ __('words.upload') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function openCvUploadModal(event) {
    event.preventDefault();
    document.getElementById('cvUploadModal').classList.remove('hidden');
}

function closeCvUploadModal() {
    document.getElementById('cvUploadModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('cvUploadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCvUploadModal();
    }
});
</script>
@endpush

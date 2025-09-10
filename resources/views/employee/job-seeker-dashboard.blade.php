@extends('layouts.employee')

@section('title', 'لوحة تحكم الباحث عن عمل')

@section('employee-content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-3xl font-bold text-gray-800 mb-8">مرحباً {{ auth()->user()->name }}</h1>

            {{-- <x-employee.dashboard-promo-carousel /> --}}

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
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm transition-opacity duration-300" role="alert" data-auto-dismiss="4000">
                    <div class="flex items-start">
                        <div class="py-1 mr-4 rtl:ml-4 rtl:mr-0 flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold">نجاح</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @php
                // Calculate profile completeness based on new steps and weights
                $stepsCompleted = 0;
                $totalSteps = 4;
                
                // Step 1: Profile details (30%) - always completed if user exists
                $stepsCompleted++;
                
                // Step 2: Experiences exist (30%)
                if(auth()->user()->employee && auth()->user()->employee->hasExperiences()) {
                    $stepsCompleted++;
                }
                
                // Step 3: Education exists (30%)
                if(auth()->user()->employee && auth()->user()->employee->hasEducations()) {
                    $stepsCompleted++;
                }
                
                // Step 4: First AI interview completed (10%)
                if(auth()->user()->employee && auth()->user()->employee->interviews()->where('status', 'completed')->exists()) {
                    $stepsCompleted++;
                }
                
                // Calculate percentage with new weights
                $completenessPercentage = 0;
                if(auth()->user()->employee) {
                    $completenessPercentage += 30; // Step 1 always completed
                    
                    if(auth()->user()->employee->hasExperiences()) {
                        $completenessPercentage += 30; // Step 2
                    }
                    
                    if(auth()->user()->employee->hasEducations()) {
                        $completenessPercentage += 30; // Step 3
                    }
                    
                    if(auth()->user()->employee->interviews()->where('status', 'completed')->exists()) {
                        $completenessPercentage += 10; // Step 4
                    }
                }
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
                            <div class="text-4xl font-bold" style="color: #012d48;">{{ $completenessPercentage }}%</div>
                            <div class="text-sm text-gray-500">مكتمل</div>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-gray-200 h-2">
                    <div class="h-2" style="width: {{ $completenessPercentage }}%; background-color: #012d48;"></div>
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
                        <!-- Step 2: Experiences (30%) -->
                        @if(auth()->user()->employee && auth()->user()->employee->hasExperiences())
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">الخبرات المهنية</h3>
                                    <p class="text-sm text-green-600 font-medium">مكتمل</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('employee.experiences.index', ['locale' => app()->getLocale()]) }}" class="hover:opacity-80" style="color: #012d48;">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('employee.experiences.create', ['locale' => app()->getLocale()]) }}" class="group flex items-center justify-between gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors" style="border-color: #e5e7eb;" onmouseover="this.style.borderColor='#012d48'; this.style.backgroundColor='#f8fafc';" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='white';">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center" style="background-color: #f1f5f9;" onmouseover="this.style.backgroundColor='#e0f2fe';" onmouseout="this.style.backgroundColor='#f1f5f9';">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;" onmouseover="this.style.color='#012d48';" onmouseout="this.style.color='#6b7280';"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 group-hover:text-gray-800">الخبرات المهنية</h3>
                                        <p class="text-sm text-gray-500 group-hover:text-gray-600">ابدأ الآن</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;" onmouseover="this.style.color='#012d48';" onmouseout="this.style.color='#6b7280';"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif
                        
                        <!-- Step 3: Education (30%) -->
                        @if(auth()->user()->employee && auth()->user()->employee->hasEducations())
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">التعليم والشهادات</h3>
                                    <p class="text-sm text-green-600 font-medium">مكتمل - انت الآن مرشح للتقدم للوظائف</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('employee.educations.index', ['locale' => app()->getLocale()]) }}" class="hover:opacity-80" style="color: #012d48;">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('employee.educations.create', ['locale' => app()->getLocale()]) }}" class="group flex items-center justify-between gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors" style="border-color: #e5e7eb;" onmouseover="this.style.borderColor='#012d48'; this.style.backgroundColor='#f8fafc';" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='white';">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center" style="background-color: #f1f5f9;" onmouseover="this.style.backgroundColor='#e0f2fe';" onmouseout="this.style.backgroundColor='#f1f5f9';">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;" onmouseover="this.style.color='#012d48';" onmouseout="this.style.color='#6b7280';"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 group-hover:text-gray-800">التعليم والشهادات</h3>
                                        <p class="text-sm text-gray-500 group-hover:text-gray-600">ابدأ الآن</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;" onmouseover="this.style.color='#012d48';" onmouseout="this.style.color='#6b7280';"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif

                        <!-- Step 4: AI Interview (10%) -->
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
                            <a href="{{ route('interview.conduct', ['locale' => app()->getLocale(), 'interview' => $existingInterview->id]) }}" class="group flex items-center justify-between gap-3 p-4 text-white rounded-xl shadow-md transition-all duration-300 transform hover:scale-105" style="background-color: #012d48;" onmouseover="this.style.backgroundColor='#001a2e';" onmouseout="this.style.backgroundColor='#012d48';">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold">إجراء أول مقابلة</h3>
                                        <p class="text-xs opacity-80">عزز ملفك الشخصي حيث تزيد فرصتك في الحصول الى وظيفة تصل الى 2x</p>
                                        <p class="text-sm opacity-80">قيد التقدم - اضغط للمتابعة</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('interview.start', ['locale' => app()->getLocale()]) }}" class="group flex items-center justify-between gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors" style="border-color: #e5e7eb;" onmouseover="this.style.borderColor='#012d48'; this.style.backgroundColor='#f8fafc';" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='white';">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center" style="background-color: #f1f5f9;" onmouseover="this.style.backgroundColor='#e0f2fe';" onmouseout="this.style.backgroundColor='#f1f5f9';">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;" onmouseover="this.style.color='#012d48';" onmouseout="this.style.color='#6b7280';"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 group-hover:text-gray-800">إجراء أول مقابلة</h3>
                                        <p class="text-xs text-gray-500">عزز ملفك الشخصي حيث تزيد فرصتك في الحصول الى وظيفة تصل الى 2x</p>
                                        <p class="text-sm text-gray-500 group-hover:text-gray-600">ابدأ الآن</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;" onmouseover="this.style.color='#012d48';" onmouseout="this.style.color='#6b7280';"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif

                        <!-- Job Applications CTA Button -->
                        <div class="md:col-span-2 mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-blue-800">ابدأ التقدم للوظائف</h3>
                                    <p class="text-sm text-blue-600">استكشف الفرص الوظيفية المتاحة</p>
                                </div>
                                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    تصفح الوظائف
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Profile Summary -->
            <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                    <h2 class="text-xl font-bold text-gray-800">ملخص الملف الشخصي</h2>
                    <a href="/{{ app()->getLocale() }}/profile" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-full shadow-sm text-white transition-transform hover:scale-105" style="background-color: #012d48;" onmouseover="this.style.backgroundColor='#001a2e';" onmouseout="this.style.backgroundColor='#012d48';" onfocus="this.style.outline='2px solid #012d48'; this.style.outlineOffset='2px';" onblur="this.style.outline='none';">
                        تعديل الملف الشخصي
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">مستوى الخبرة</p>
                        <p class="text-base text-gray-800 font-semibold">
                            @if(auth()->user()->employee && auth()->user()->employee->experience_level)
                                @switch(auth()->user()->employee->experience_level)
                                    @case('none') لا يوجد @break
                                    @case('1_3_years') 1-3 سنوات @break
                                    @case('3_5_years') 3-5 سنوات @break
                                    @case('5_plus_years') 5+ سنوات @break
                                    @default لا يوجد
                                @endswitch
                            @else
                                @switch(session('job_seeker_experience_level', 'none'))
                                    @case('none') لا يوجد @break
                                    @case('1_3_years') 1-3 سنوات @break
                                    @case('3_5_years') 3-5 سنوات @break
                                    @case('5_plus_years') 5+ سنوات @break
                                    @default لا يوجد
                                @endswitch
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-medium">نوع العمل المفضل</p>
                         <p class="text-base text-gray-800 font-semibold">
                            @if(auth()->user()->employee && auth()->user()->employee->preferred_work_type)
                                @switch(auth()->user()->employee->preferred_work_type)
                                    @case('full_time') دوام كامل @break
                                    @case('part_time') دوام جزئي @break
                                    @case('contract') عقد @break
                                    @case('freelance') عمل حر @break
                                    @default دوام كامل
                                @endswitch
                            @else
                                @switch(session('job_seeker_preferred_work_type', 'full_time'))
                                    @case('full_time') دوام كامل @break
                                    @case('part_time') دوام جزئي @break
                                    @case('contract') عقد @break
                                    @case('freelance') عمل حر @break
                                    @default دوام كامل
                                @endswitch
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1 font-medium">المهارات</p>
                        <div class="flex flex-wrap gap-2">
                            @if(auth()->user()->employee && auth()->user()->employee->skills()->count() > 0)
                                @foreach(auth()->user()->employee->skills()->get() as $skill)
                                    <span class="inline-block bg-gray-100 text-gray-700 text-sm font-medium px-3 py-1 rounded-full">{{ $skill->name }}</span>
                                @endforeach
                            @elseif(auth()->user()->employee && auth()->user()->employee->skills)
                                @foreach(explode(',', auth()->user()->employee->skills) as $skill)
                                    @if(trim($skill))
                                        <span class="inline-block bg-gray-100 text-gray-700 text-sm font-medium px-3 py-1 rounded-full">{{ trim($skill) }}</span>
                                    @endif
                                @endforeach
                            @else
                                @foreach(explode(',', session('job_seeker_skills', '')) as $skill)
                                    @if(trim($skill))
                                        <span class="inline-block bg-gray-100 text-gray-700 text-sm font-medium px-3 py-1 rounded-full">{{ trim($skill) }}</span>
                                    @endif
                                @endforeach
                                @if(!session('job_seeker_skills'))
                                    <p class="text-sm text-gray-500">المهارات لم يتم تحديثها بعد</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Experiences Section -->
                @if(auth()->user()->employee && auth()->user()->employee->hasExperiences())
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">الخبرات المهنية</h3>
                        <div class="space-y-4">
                            @foreach(auth()->user()->employee->experiences as $experience)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800">{{ $experience->job_title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $experience->company_name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                                @if($experience->is_current)
                                                    الحاضر
                                                @else
                                                    {{ \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                                                @endif
                                            </p>
                                            @if($experience->description)
                                                <p class="text-sm text-gray-700 mt-2">{{ Str::limit($experience->description, 150) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Education Section -->
                @if(auth()->user()->employee && auth()->user()->employee->hasEducations())
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">التعليم والشهادات</h3>
                        <div class="space-y-4">
                            @foreach(auth()->user()->employee->educations as $education)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800">{{ $education->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $education->institute_name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($education->start_date)->format('M Y') }} - 
                                                @if($education->is_current)
                                                    الحاضر
                                                @else
                                                    {{ \Carbon\Carbon::parse($education->end_date)->format('M Y') }}
                                                @endif
                                            </p>
                                            @if($education->certificate_type)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full mt-2">
                                                    {{ $education->certificate_type }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Available Jobs -->
            <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl font-bold text-gray-800">الوظائف المتاحة لك</h2>
                    <button class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-full transition-transform hover:scale-105" style="color: #012d48; background-color: #e0f2fe;" onmouseover="this.style.backgroundColor='#bae6fd';" onmouseout="this.style.backgroundColor='#e0f2fe';" onfocus="this.style.outline='2px solid #012d48'; this.style.outlineOffset='2px';" onblur="this.style.outline='none';">
                        تحديث الوظائف
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="text-center py-12 bg-gray-50 rounded-2xl">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full" style="background-color: #e0f2fe;">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #012d48;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ __('words.browse_jobs') }}</h3>
                        <p class="mt-2 text-sm text-gray-500">استكشف الفرص الوظيفية المتاحة</p>
                        <div class="mt-6 space-x-2 rtl:space-x-reverse">
                            <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-full text-white" style="background-color: #012d48;" onmouseover="this.style.backgroundColor='#001a2e';" onmouseout="this.style.backgroundColor='#012d48';">
                                {{ __('words.browse_jobs') }}
                            </a>
                            <a href="{{ route('jobs.my-applications', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                {{ __('words.my_applications') }}
                            </a>
                        </div>
                    </div>
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
                                class="text-white px-4 py-2 rounded text-sm" style="background-color: #012d48;" onmouseover="this.style.backgroundColor='#001a2e';" onmouseout="this.style.backgroundColor='#012d48';">
                            {{ __('words.upload') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-employee.promo-modal />
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

// Auto-dismiss flash alerts
document.querySelectorAll('[data-auto-dismiss]').forEach(function(el) {
    var timeoutMs = parseInt(el.getAttribute('data-auto-dismiss'), 10) || 4000;
    setTimeout(function() {
        el.classList.add('opacity-0');
        setTimeout(function() { el.remove(); }, 300);
    }, timeoutMs);
});

</script>
@endpush

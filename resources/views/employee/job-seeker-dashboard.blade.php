@extends('layouts.employee')

@section('title', 'لوحة تحكم الباحث عن عمل')

@section('employee-content')
    <div class="container mx-auto">
        <div class="p-6 max-w-7xl mx-auto">

            <h1 class="text-2xl font-bold mb-6">مرحباً {{ auth()->user()->name }}</h1>

            <!-- Profile Completeness Box -->
            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-1">اكتمال الملف الشخصي</h2>
                        <p class="text-sm text-gray-600">أكمل ملفك الشخصي لزيادة فرصك في التوظيف</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-blue-600">75%</div>
                        <div class="text-sm text-gray-500">مكتمل</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 ease-out" style="width: 75%"></div>
                </div>
                
                <!-- Completion Items -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#" class="group flex items-center gap-3 p-3 bg-white rounded-lg border border-blue-100 hover:bg-blue-700 hover:text-white cursor-pointer transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900 group-hover:text-white">تفاصيل الملف الشخصي</h3>
                            <p class="text-xs text-gray-500 group-hover:text-white">مكتمل</p>
                        </div>
                    </a>
                    
                    <a href="#" class="group flex items-center gap-3 p-3 bg-white rounded-lg border border-blue-100 hover:bg-blue-700 hover:text-white cursor-pointer transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900 group-hover:text-white">رفع السيرة الذاتية</h3>
                            <p class="text-xs text-gray-500 group-hover:text-white">مكتمل</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('interview.start') }}" class="group flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-700 hover:text-white cursor-pointer transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-700 group-hover:text-white">إجراء أول مقابلة</h3>
                            <p class="text-xs text-gray-500 group-hover:text-white">
                                @if(auth()->user()->employee->interviews()->where('status', 'completed')->exists())
                                    مكتمل
                                @elseif(auth()->user()->employee->interviews()->whereIn('status', ['pending', 'in_progress'])->exists())
                                    قيد التقدم
                                @else
                                    قيد الانتظار
                                @endif
                            </p>
                        </div>
                    </a>
                    
                    <a href="#" class="group flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-700 hover:text-white cursor-pointer transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-700 group-hover:text-white">التقدم للوظائف</h3>
                            <p class="text-xs text-gray-500 group-hover:text-white">قيد الانتظار</p>
                        </div>
                    </a>
                </div>
                
            </div>

            <!-- Profile Summary -->
            <div class="mb-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">ملخص الملف الشخصي</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600"><strong>مستوى الخبرة:</strong> 
                            @switch(session('job_seeker_experience_level', 'entry'))
                                @case('entry')
                                    مبتدئ (0-2 سنوات)
                                    @break
                                @case('mid_level')
                                    متوسط (3-5 سنوات)
                                    @break
                                @case('senior')
                                    متقدم (6-10 سنوات)
                                    @break
                                @case('expert')
                                    خبير (10+ سنوات)
                                    @break
                                @default
                                    مبتدئ (0-2 سنوات)
                            @endswitch
                        </p>
                        <p class="text-sm text-gray-600"><strong>نوع العمل المفضل:</strong> 
                            @switch(session('job_seeker_preferred_work_type', 'full_time'))
                                @case('full_time')
                                    دوام كامل
                                    @break
                                @case('part_time')
                                    دوام جزئي
                                    @break
                                @case('contract')
                                    عقد
                                    @break
                                @case('freelance')
                                    عمل حر
                                    @break
                                @default
                                    دوام كامل
                            @endswitch
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600"><strong>المهارات:</strong></p>
                        <p class="text-sm text-gray-700 mt-1">{{ session('job_seeker_skills', 'المهارات لم يتم تحديثها بعد') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        تعديل الملف الشخصي
                    </a>
                </div>
            </div>

            <!-- Job Search Section -->
            <div class="mb-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">البحث عن الوظائف</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-2">الطلبات النشطة</h3>
                        <p class="text-2xl font-bold text-blue-600">0</p>
                        <p class="text-sm text-blue-600">لا توجد طلبات نشطة</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-green-800 mb-2">المقابلات المجدولة</h3>
                        <p class="text-2xl font-bold text-green-600">0</p>
                        <p class="text-sm text-green-600">لا توجد مقابلات مجدولة</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-purple-800 mb-2">الوظائف المعروضة</h3>
                        <p class="text-2xl font-bold text-purple-600">0</p>
                        <p class="text-sm text-purple-600">لم يتم عرض وظائف بعد</p>
                    </div>
                </div>
            </div>

            <!-- Available Jobs -->
            <div class="mb-6 bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">الوظائف المتاحة</h2>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        تحديث الوظائف
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">مطور برمجيات متقدم</h3>
                                <p class="text-sm text-gray-600 mb-2">شركة حلول التقنية</p>
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span>عن بُعد</span>
                                    <span>دوام كامل</span>
                                    <span>80,000 - 120,000 ر.س</span>
                                </div>
                            </div>
                            <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                تقدم الآن
                            </button>
                        </div>
                        <p class="text-sm text-gray-700 mt-3">نحن نبحث عن مطور برمجيات متمرس للانضمام إلى فريقنا عن بُعد. يجب أن يكون المرشح المثالي لديه مهارات برمجة قوية وخبرة في تقنيات الويب الحديثة.</p>
                    </div>

                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">لا توجد وظائف متاحة حالياً</h3>
                        <p class="mt-1 text-sm text-gray-500">عد لاحقاً للفرص الجديدة</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">إجراءات سريعة</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="#" class="flex flex-col items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">البحث عن الوظائف</span>
                    </a>
                    <a href="#" class="flex flex-col items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">طلباتي</span>
                    </a>
                    <a href="#" class="flex flex-col items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">المقابلات</span>
                    </a>
                    <a href="#" class="flex flex-col items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">الإعدادات</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

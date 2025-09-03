<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>

    <!-- Hero Section (shadcn-style) -->
        <div class="" style="background-color: rgb(31, 41, 55)">
            <div class="container mx-auto px-4 py-16 md:py-20">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                        {{ app()->getLocale() === 'ar' ? 'أحدث الوظائف المنشورة' : 'Find your dream job' }}
                    </h1>
                    <p class="text-xl text-gray-300 mb-12 max-w-2xl mx-auto">
                        {{ __('words.hero.looking_for_job') }}
                    </p>

                    <!-- Search Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-8 max-w-4xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="relative">
                                <svg class="absolute rtl:left-3 ltr:right-3 top-1/2 -translate-y-1/2 text-gray-400 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" placeholder="{{ app()->getLocale() === 'ar' ? 'البحث عن وظيفة...' : 'Search for a job...' }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 rtl:pl-10 rtl:pr-3 ltr:pr-10 ltr:pl-3 rtl:text-right ltr:text-left focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent" />
                            </div>

                            <div>
                                <select dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left bg-white focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent">
                                    <option value="" selected disabled>{{ app()->getLocale() === 'ar' ? 'المدينة' : 'City' }}</option>
                                    <option value="riyadh">{{ app()->getLocale() === 'ar' ? 'الرياض' : 'Riyadh' }}</option>
                                    <option value="jeddah">{{ app()->getLocale() === 'ar' ? 'جدة' : 'Jeddah' }}</option>
                                    <option value="dammam">{{ app()->getLocale() === 'ar' ? 'الدمام' : 'Dammam' }}</option>
                                    <option value="makkah">{{ app()->getLocale() === 'ar' ? 'مكة المكرمة' : 'Makkah' }}</option>
                                    <option value="medina">{{ app()->getLocale() === 'ar' ? 'المدينة المنورة' : 'Medina' }}</option>
                                </select>
                            </div>

                            <div>
                                <select dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left bg-white focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent">
                                    <option value="" selected disabled>{{ app()->getLocale() === 'ar' ? 'المجال' : 'Field' }}</option>
                                    <option value="technology">{{ app()->getLocale() === 'ar' ? 'التكنولوجيا' : 'Technology' }}</option>
                                    <option value="finance">{{ app()->getLocale() === 'ar' ? 'المالية' : 'Finance' }}</option>
                                    <option value="healthcare">{{ app()->getLocale() === 'ar' ? 'الرعاية الصحية' : 'Healthcare' }}</option>
                                    <option value="education">{{ app()->getLocale() === 'ar' ? 'التعليم' : 'Education' }}</option>
                                    <option value="engineering">{{ app()->getLocale() === 'ar' ? 'الهندسة' : 'Engineering' }}</option>
                                </select>
                            </div>

                            <div>
                                <button type="button" class="w-full inline-flex items-center rtl:flex-row-reverse justify-center px-4 py-2.5 text-sm font-medium rounded-md text-white" style="background-color: rgb(31, 41, 55)">
                                    <svg class="h-4 w-4 rtl:ml-2 ltr:mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
                        <div class="text-center">
                            <h3 class="text-3xl font-bold mb-2">+5000</h3>
                            <p class="text-gray-300">{{ app()->getLocale() === 'ar' ? 'وظيفة متاحة' : 'Open jobs' }}</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-bold mb-2">+200</h3>
                            <p class="text-gray-300">{{ app()->getLocale() === 'ar' ? 'شركة معتمدة' : 'Verified companies' }}</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-bold mb-2">+10000</h3>
                            <p class="text-gray-300">{{ app()->getLocale() === 'ar' ? 'موظف تم توظيفهم' : 'Candidates hired' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Listings Grid (shadcn-style) -->
        <section id="jobs" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-3" style="color: rgb(31, 41, 55)">
                        {{ __('words.latest_jobs.title') }}
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        {{ app()->getLocale() === 'ar' ? 'اكتشف الفرص الوظيفية المتنوعة من أفضل الشركات في المملكة' : 'Discover diverse opportunities from top companies in the Kingdom' }}
                    </p>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-3 mb-8 justify-center">
                    <select dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="w-48 border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left bg-white focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent">
                        <option value="" selected disabled>{{ app()->getLocale() === 'ar' ? 'نوع العمل' : 'Work type' }}</option>
                        <option value="fulltime">{{ __('words.latest_jobs.contract_types.fulltime') }}</option>
                        <option value="parttime">{{ __('words.latest_jobs.contract_types.parttime') }}</option>
                        <option value="contract">{{ __('words.latest_jobs.contract_types.contract') }}</option>
                        <option value="remote">{{ __('words.latest_jobs.contract_types.remote') }}</option>
                    </select>
                    <select dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="w-48 border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left bg-white focus:outline-none focus:ring-2 focus:ring-gray-700 focus:border-transparent">
                        <option value="" selected disabled>{{ app()->getLocale() === 'ar' ? 'مستوى الخبرة' : 'Experience level' }}</option>
                        <option value="entry">{{ app()->getLocale() === 'ar' ? 'مبتدئ' : 'Entry' }}</option>
                        <option value="mid">{{ app()->getLocale() === 'ar' ? 'متوسط' : 'Mid' }}</option>
                        <option value="senior">{{ app()->getLocale() === 'ar' ? 'خبير' : 'Senior' }}</option>
                        <option value="lead">{{ app()->getLocale() === 'ar' ? 'قيادي' : 'Lead' }}</option>
                    </select>
                </div>

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(__('words.latest_jobs.examples') as $job)
                        @php $typeKey = $job['contract_type'] ?? 'fulltime'; @endphp
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                            <div class="p-5 border-b border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ __('words.latest_jobs.contract_types.' . $typeKey) }}
                                    </span>
                                    <div class="flex items-center text-gray-500 text-sm">
                                        <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $job['time_ago'] ?? '' }}
                                    </div>
                                </div>
                                <h3 class="text-left text-lg font-semibold leading-tight text-gray-900">{{ $job['title'] }}</h3>
                                <div class="text-left flex items-center text-gray-600 mt-1">
                                    <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
                                    {{ $job['company'] }}
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1118 0z"/></svg>
                                        {{ $job['location'] ?? (app()->getLocale() === 'ar' ? 'عن بُعد' : 'Remote') }}
                                    </div>
                                    <div class="flex items-center text-gray-700" style="color: rgb(31, 41, 55)">
                                        <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"/></svg>
                                        {{ app()->getLocale() === 'ar' ? '—' : '—' }}
                                    </div>
                                </div>
                                <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">
                                    {{ app()->getLocale() === 'ar' ? 'عرض التفاصيل' : 'View details' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="#" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                        {{ app()->getLocale() === 'ar' ? 'عرض المزيد من الوظائف' : 'Load more jobs' }}
                    </a>
                </div>
            </div>
        </section>

    <!-- جميع القطاعات Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">جميع القطاعات</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- المبيعات -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 8h18M3 13h18M3 18h18" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">المبيعات</h3>
                    </div>
                </div>
                <!-- المحاسبة -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8m5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">المحاسبة</h3>
                    </div>
                </div>
                <!-- الإدارة -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M8 6h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">الإدارة</h3>
                    </div>
                </div>
                <!-- الموارد البشرية -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">الموارد البشرية</h3>
                    </div>
                </div>
                <!-- خدمة العملاء -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13V8a6 6 0 10-12 0v5m0 0a3 3 0 106 0m-6 0v5a3 3 0 006 0" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">خدمة العملاء</h3>
                    </div>
                </div>
                <!-- المطاعم و المقاهي -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M10 14h4m-7 4h10" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">المطاعم و المقاهي</h3>
                    </div>
                </div>
                <!-- السفر والسياحة -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6.5L21 3l-3.5 10.5-7 7L3 21l7.5-7z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">السفر والسياحة</h3>
                    </div>
                </div>
                <!-- البيع التجزئة والخدمات -->
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">البيع التجزئة والخدمات</h3>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="#" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">عرض المزير من القطاعات</a>
            </div>
        </div>
    </section>

    

    {{-- 
    <div class="relative z-10 py-12">
        <div class="container mx-auto px-4">
            <section class="bg-blue-700 text-white rounded-3xl shadow-xl my-12 px-8 py-16">
                <div class="container mx-auto">
                    <div class="flex flex-col md:flex-row gap-8 items-stretch">
                        <!-- Right Section: Bullet List -->
                        <div class="md:w-1/2 w-full flex flex-col justify-start border-b-2 md:border-b-0 md:border-e-2 border-blue-500 pe-0 md:pe-8 mb-8 md:mb-0 rtl:border-s-2 rtl:border-e-0 rtl:ps-8 rtl:pe-0">
                            <h3 class="text-2xl font-bold mb-4">{{ __('words.features.title') }}</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.nationwide') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.flexible_hours') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.diverse_opportunities') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.easy_application') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.continuous_support') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.personalized_opportunities') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-blue-600">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ __('words.features.transparent_followup') }}</span>
                                </li>
                            </ul>
                        </div>
                        <!-- Left Section: Title, Paragraph, Button -->
                        <div class="md:w-1/2 w-full flex flex-col justify-between">
                            <h3 class="text-2xl font-bold mb-4">{{ __('words.homepage.cta_title') }}</h3>
                            <p class="mb-8 text-lg">{{ __('words.homepage.cta_paragraph') }}</p>
                            
                            <!-- Professional Meeting Image -->
                            <div class="mb-6">
                                <img src="{{ asset('img/width_800.png') }}" 
                                     alt="Professional team meeting around a table" 
                                     class="w-full h-48 object-cover rounded-lg shadow-md"
                                     loading="lazy">
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('register') }}"
                                   class="inline-block px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg shadow hover:bg-blue-100 transition duration-150 ease-in-out text-base">
                                    {{ app()->getLocale() === 'ar' ? 'افتح ملفك الآن' : 'Open your file now' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
--}}

    <!--
    <div class="relative z-10 py-12">
        <div class="container mx-auto px-4">
            <div class="py-12 backdrop-blur-sm bg-blue-700/95 rounded-[2rem] shadow-xl">
                <div class="px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">{{ __('words.search.title') }}</h2>
                <p class="text-gray-100">{{ __('words.search.subtitle') }}</p>
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>

                <input type="text"
                       class="block w-full ltr:pl-12 rtl:pr-12 ltr:pr-12 rtl:pl-12 py-4 bg-white border border-blue-400 rounded-2xl
                              text-black placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400
                              focus:border-transparent transition duration-200 backdrop-blur-lg
                              shadow-[0_0_15px_rgba(0,0,0,0.2)]"
                       placeholder="{{ __('words.search.placeholder') }}"
                       id="citySearch">

                <button type="button"
                        class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center px-4
                               text-gray-500 hover:text-blue-600 transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>

            <div class="flex justify-center mt-4 flex-wrap gap-2">
                <a href="#" class="px-3 py-1.5 text-sm bg-white/10 hover:bg-white/20 text-white rounded-full transition duration-200 backdrop-blur-sm">
                    #{{ __('words.search.popular_tags.programmer') }}
                </a>
                <a href="#" class="px-3 py-1.5 text-sm bg-white/10 hover:bg-white/20 text-white rounded-full transition duration-200 backdrop-blur-sm">
                    #{{ __('words.search.popular_tags.computer_systems') }}
                </a>
                <a href="#" class="px-3 py-1.5 text-sm bg-white/10 hover:bg-white/20 text-white rounded-full transition duration-200 backdrop-blur-sm">
                    #{{ __('words.search.popular_tags.data_analyst') }}
                </a>
                <a href="#" class="px-3 py-1.5 text-sm bg-white/10 hover:bg-white/20 text-white rounded-full transition duration-200 backdrop-blur-sm">
                    #{{ __('words.search.popular_tags.project_manager') }}
                </a>
                <a href="#" class="px-3 py-1.5 text-sm bg-white/10 hover:bg-white/20 text-white rounded-full transition duration-200 backdrop-blur-sm">
                    #{{ __('words.search.popular_tags.ui_designer') }}
                </a>
            </div>
                </div>
            </div>
        </div>
    </div>
    -->




    <!-- Action Buttons -->
    <div class="bg-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#" class="group inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg w-full sm:w-auto text-center">
                    <span>{{ __('words.looking_for_job') }}</span>
                    <svg class="w-5 h-5 rtl:rotate-180 ltr:ml-2 rtl:mr-2 transition-transform duration-300 ease-out transform ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="#" class="group inline-flex items-center justify-center px-8 py-4 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 w-full sm:w-auto text-center">
                    <span>{{ __('words.looking_for_hire') }}</span>
                    <svg class="w-5 h-5 rtl:rotate-180 ltr:ml-2 rtl:mr-2 transition-transform duration-300 ease-out transform ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <main class="flex-grow">
        <!-- Hero Section -->
        <div class="bg-white relative overflow-hidden">
            <!-- Animated background elements -->
            {{-- <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -inset-[10px] opacity-50">
                    <div class="absolute left-[10%] top-[20%] h-24 w-24 rounded-full bg-blue-400 mix-blend-multiply animate-blob"></div>
                    <div class="absolute right-[15%] top-[30%] h-32 w-32 rounded-full bg-indigo-400 mix-blend-multiply animate-blob animation-delay-2000"></div>
                    <div class="absolute left-[20%] bottom-[20%] h-28 w-28 rounded-full bg-purple-400 mix-blend-multiply animate-blob animation-delay-4000"></div>
                </div>
            </div> --}}

            {{-- <div class="container mx-auto px-4 py-20 relative">
                <div class="grid grid-cols-12 gap-8 items-center">
                    <div class="col-span-12 lg:col-span-12 space-y-8">
                        <!-- Arabic Navigation/Title -->
                        <div class="text-center md:text-right mb-8">
                            <h1 class="text-lg text-gray-600 mb-2">الرئيسية – من نحن</h1>
                        </div>

                        <!-- Main Headlines -->
                        <div class="space-y-6 text-center md:text-right">
                            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black leading-tight">
                                حلول توظيف سعودية.. تفهم حاجتك وتلبي طموحك
                            </h2>
                            <h3 class="text-2xl md:text-3xl font-semibold text-blue-600">
                                مع هدف.. نجمع بين طموح الشركات وطموح السعوديين
                            </h3>
                            <div class="space-y-4 text-xl md:text-2xl font-medium text-gray-700">
                                <p>المواهب السعودية.. وقود نجاح شركتك</p>
                                <p>استثمر في السعوديين.. واربح مستقبل شركتك</p>
                                <p>الكادر السعودي.. دعمك الحقيقي لتحقيق نمو مستدام وقوي</p>
                            </div>
                        </div>

                        <!-- Hadaf Section -->
                        <div class="bg-blue-50 rounded-2xl p-8 space-y-6 text-center md:text-right">
                            <h3 class="text-3xl font-bold text-blue-800">هدف للتوظيف</h3>
                            <p class="text-lg text-gray-700 leading-relaxed">
                                نوصلك بالمكان اللي يستاهلك، لأن الوظيفة نمو، وانتماء، وترك أثر.
                            </p>
                            <p class="text-base text-gray-600 leading-relaxed">
                                هدف للتوظيف مرخصة للوساطة لتوظيف السعوديين. خدماتنا متاحة بدوام كامل، جزئي، وعن بعد - هذا سلوجن للباحثين عن عمل. نحن نفخر بأن
                            </p>
                        </div>

                        <!-- Services Section -->
                        <div class="space-y-6 text-center md:text-right">
                            <h3 class="text-2xl font-bold text-black">خدماتنا</h3>
                            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-3 h-3 bg-blue-600 rounded-full mt-2"></div>
                                    <p class="text-gray-700 text-right">
                                        خدمة التوظيف الفعلي - لأن احنا مرخصين للوساطة لتوظيف السعوديين
                                    </p>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-3 h-3 bg-blue-600 rounded-full mt-2"></div>
                                    <p class="text-gray-700 text-right">
                                        خدمة العمل عن بعد - مزود خدمة معتمد في منصة العمل عن بعد التابعة لوزارة الموارد البشرية
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Partners Section -->
                        <div class="space-y-4 text-center md:text-right">
                            <h3 class="text-xl font-semibold text-black">لصاحب العمل – شركاؤنا من الكفاءات</h3>
                            <p class="text-lg text-blue-600 font-medium">يثقون بنا - يثقون بهدف</p>
                            <p class="text-base text-gray-600">المقارنة اللي يميزنا هي تكون لماذا هدف</p>
                        </div>

                        <!-- CTA Section -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-center text-white space-y-6">
                            <h3 class="text-2xl font-bold">ختامًا</h3>
                            <p class="text-lg leading-relaxed">
                                نوصلك بالمكان اللي يستاهلك،<br>
                                لأن الوظيفة نمو، وانتماء، وترك أثر.
                            </p>
                            <div class="flex items-center justify-center gap-2 text-lg">
                                <span>📞</span>
                                <p>تواصل معنا اليوم—مع هدف للتوظيف، تبدأ رحلتك المهنية بخطوة مبنية على الثقة والرؤية.</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                                <a href="#" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-blue-600 transition duration-150 ease-in-out">
                                    تواصل معنا
                                </a>
                                <a href="#" class="inline-flex items-center justify-center px-8 py-3 border-2 border-transparent text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition duration-150 ease-in-out">
                                    اعرف المزيد
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> --}}

        <!-- Trusted Companies Section -->
        <div class="bg-white">
            <div class="container mx-auto px-4 py-20">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-black">
                        عملائنا
                    </h2>
                    <p class="text-xl text-gray-600">
                        جهات واثقة بنا
                    </p>
                </div>

                <!-- Company Logos Grid -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-12 items-center justify-items-center opacity-90">
                    @foreach(($logos ?? collect()) as $index => $logo)
                    <div class="h-24 flex items-center justify-center bg-transparent rounded-lg p-8 transition duration-200 ease-in-out filter grayscale hover:grayscale-0">
                        <img src="{{ asset($logo) }}" alt="Client Logo {{ $index + 1 }}" class="h-12 w-auto object-contain" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Job Districts Section -->
        {{-- <div class="bg-white">
            <div class="container mx-auto px-4 py-20">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-black">
                    🌱 {{ __('words.opportunities.title') }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        {{ __('words.opportunities.subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Sales and Marketing -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.sales') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.8</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(234 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Accounting and Finance -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.accounting') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.5</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(187 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Management and Secretary -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.management') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.7</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(312 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- IT and Software -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.it') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.9</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(456 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Legal Services -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.legal') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.6</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(167 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- HR -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.hr') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.7</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(289 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Engineering -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.engineering') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.8</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(378 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Healthcare -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-black mb-2">{{ __('words.opportunities.districts.healthcare') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600">4.7</span>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2">(245 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div> --}}

        <!-- Instagram Embeds Section -->
        <x-instagram-embeds />

        <!-- Enterprise Section -->
        <div class="bg-white py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-12 gap-8 items-center">
                    <div class="col-span-12 lg:col-span-6 space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-3xl md:text-4xl font-bold text-black">
                                هدف للشركات
                            </h2>
                            <p class="text-xl text-gray-600">
                                نوصلكم بأفضل الكفاءات.. بسرعة، ثقة، وبتكلفة أقل
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-3xl p-8 shadow-sm border border-gray-100 backdrop-blur-sm">
                            <div class="space-y-6">
                                <!-- Vetted Professionals -->
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-black">
                                            كفاءات موثوقة جاهزة للعمل
                                        </h3>
                                        <p class="mt-2 text-gray-600">
                                            اختروا من شبكة المحترفين الذين اجتازوا التقييم المسبق والتحقق من خبراتهم، لتضمنوا جودة أعلى وموظفين يعتمد عليهم.
                                        </p>
                                    </div>
                                </div>

                                <!-- Save Time -->
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-black">
                                            توظيف أسرع وأسهل
                                        </h3>
                                        <p class="mt-2 text-gray-600">
                                            وفروا وقتكم الثمين عبر منصتنا الذكية التي تختصر خطوات البحث والاختيار، لتجدوا المرشح المناسب في وقت قياسي.
                                        </p>
                                    </div>
                                </div>

                                <!-- Reduce Costs -->
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-black">
                                            جودة عالية بتكلفة أقل
                                        </h3>
                                        <p class="mt-2 text-gray-600">
                                            قلّل من مصاريف التوظيف والتشغيل مع الحفاظ على أعلى المعايير، لأننا نجمع بين الكفاءة والجودة والاحترافية
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl transform rotate-3"></div>
                            <div class="relative rounded-2xl shadow-xl overflow-hidden aspect-[4/3]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <img
                                    class="absolute inset-0 w-full h-full object-cover object-center"
                                    src="{{ asset('img/enterprise-team.jpg') }}"
                                    alt="Enterprise Team"
                                >
                                <div class="absolute bottom-0 left-0 right-0 p-8 z-20">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                        </svg>
                                        <span class="text-white font-semibold">{{ __('words.enterprise.rating') }}</span>
                                    </div>
                                    <div class="ltr:ml-8 rtl:mr-8">
                                        <p class="text-gray-200 text-sm mb-4">{{ __('words.enterprise.rating_subtitle') }}</p>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white leading-tight">
                                        {{ __('words.enterprise.image_overlay') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Companies Section with stats and pricing (shadcn-style) -->
        <div id="companies" class="bg-white py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: rgb(31, 41, 55)">
                        {{ app()->getLocale() === 'ar' ? 'هل أنت شركة توظيف؟' : 'Are you an employer?' }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        {{ app()->getLocale() === 'ar' ? 'انضم إلى شبكتنا من أفضل الشركات واعثر على أفضل المواهب لفريقك' : 'Join our network of top companies and hire the best talent' }}
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">+50,000</h3>
                        <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'باحث عن عمل نشط' : 'Active candidates' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 11V7a4 4 0 018 0v4m-1 2v4a4 4 0 11-8 0v-4m-4 0h12"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">85%</h3>
                        <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'معدل نجاح التوظيف' : 'Hiring success rate' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="h-8 w-8 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M9 3v18M3 9h18M3 15h18"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">+200</h3>
                        <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'شركة تثق بنا' : 'Companies trust us' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-orange-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="h-8 w-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">15</h3>
                        <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'يوم متوسط مدة التوظيف' : 'Avg. days to hire' }}</p>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="mb-16">
                    <h3 class="text-2xl font-bold text-center mb-12" style="color: rgb(31, 41, 55)">
                        {{ app()->getLocale() === 'ar' ? 'اختر الخطة المناسبة لشركتك' : 'Choose the right plan' }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        <!-- Basic -->
                        <div class="relative border rounded-lg p-6">
                            <div class="text-center">
                                <h4 class="text-xl font-semibold mb-2">{{ app()->getLocale() === 'ar' ? 'الخطة الأساسية' : 'Basic' }}</h4>
                                <div class="mb-4">
                                    <span class="text-4xl font-bold" style="color: rgb(31, 41, 55)">499 {{ app()->getLocale() === 'ar' ? 'ريال' : 'SAR' }}</span>
                                    <span class="text-gray-600">/{{ app()->getLocale() === 'ar' ? 'شهرياً' : 'mo' }}</span>
                                </div>
                                <p class="text-gray-600 mb-6">{{ app()->getLocale() === 'ar' ? 'مثالية للشركات الصغيرة' : 'Great for small teams' }}</p>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'نشر حتى 5 وظائف شهرياً' : 'Post up to 5 jobs/mo' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'عرض في نتائج البحث' : 'Search visibility' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'دعم فني أساسي' : 'Basic support' }}</span></li>
                            </ul>
                            <a href="#" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'اختر هذه الخطة' : 'Choose plan' }}</a>
                        </div>

                        <!-- Pro (popular) -->
                        <div class="relative border-2 rounded-lg p-6 shadow-xl" style="border-color: rgb(31, 41, 55)">
                            <div class="absolute -top-4 right-1/2 translate-x-1/2">
                                <span class="inline-flex items-center px-4 py-1 text-white text-sm rounded-full" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'الأكثر شعبية' : 'Most popular' }}</span>
                            </div>
                            <div class="text-center">
                                <h4 class="text-xl font-semibold mb-2">{{ app()->getLocale() === 'ar' ? 'الخطة الاحترافية' : 'Pro' }}</h4>
                                <div class="mb-4">
                                    <span class="text-4xl font-bold" style="color: rgb(31, 41, 55)">999 {{ app()->getLocale() === 'ar' ? 'ريال' : 'SAR' }}</span>
                                    <span class="text-gray-600">/{{ app()->getLocale() === 'ar' ? 'شهرياً' : 'mo' }}</span>
                                </div>
                                <p class="text-gray-600 mb-6">{{ app()->getLocale() === 'ar' ? 'الأفضل للشركات المتوسطة' : 'Best for growing teams' }}</p>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'نشر حتى 20 وظيفة شهرياً' : 'Post up to 20 jobs/mo' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'أولوية في نتائج البحث' : 'Priority placement' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'دعم فني مخصص' : 'Dedicated support' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'تقارير تفصيلية' : 'Detailed reports' }}</span></li>
                            </ul>
                            <a href="#" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'اختر هذه الخطة' : 'Choose plan' }}</a>
                        </div>

                        <!-- Enterprise -->
                        <div class="relative border rounded-lg p-6">
                            <div class="text-center">
                                <h4 class="text-xl font-semibold mb-2">{{ app()->getLocale() === 'ar' ? 'خطة المؤسسات' : 'Enterprise' }}</h4>
                                <div class="mb-4">
                                    <span class="text-2xl font-bold" style="color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'تواصل معنا' : 'Contact us' }}</span>
                                </div>
                                <p class="text-gray-600 mb-6">{{ app()->getLocale() === 'ar' ? 'حلول مخصصة للمؤسسات الكبيرة' : 'Custom solutions for large orgs' }}</p>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'وظائف غير محدودة' : 'Unlimited jobs' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'أولوية قصوى في العرض' : 'Top priority' }}</span></li>
                                <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'مدير حساب مخصص' : 'Account manager' }}</span></li>
                            </ul>
                            <a href="#" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'تواصل معنا' : 'Contact sales' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative bg-blue-600 dark:bg-blue-800">
            <!-- Pattern Background -->
            <div class="absolute inset-0 opacity-[0.08] mix-blend-overlay">
                <svg class="w-full h-full text-white" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40L40 0M-10 10L10 -10M30 50L50 30" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </pattern>
                    </defs>
                    <rect x="0" y="0" width="100%" height="100%" fill="url(#grid-pattern)"/>
                </svg>
            </div>

            <div class="relative container mx-auto px-4 py-20">
                <div class="max-w-4xl mx-auto text-center space-y-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-white">
                        {{ __('words.enterprise.cta.header') }}
                    </h2>
                    <p class="text-xl text-blue-100">
                        {{ __('words.enterprise.cta.subtext') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                        <a href="#" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-lg font-medium rounded-lg text-white hover:bg-white hover:text-blue-600 transition duration-150 ease-in-out">
                            {{ __('words.enterprise.cta.hire') }}
                        </a>
                        <a href="#" class="inline-flex items-center justify-center px-8 py-4 border-2 border-transparent text-lg font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition duration-150 ease-in-out">
                            {{ __('words.enterprise.cta.pricing') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partner Logos -->
    <div class="bg-white/90 backdrop-blur-sm py-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 sm:gap-16">
                <img src="{{ asset('img/takamol-logo@2x.png') }}"
                     alt="Takamol Logo"
                     class="h-12 w-auto object-contain"
                     loading="lazy">
                <img src="{{ asset('img/logo_v2_on_white.png') }}"
                     alt="Hadaf Logo"
                     class="h-12 w-auto object-contain"
                     loading="lazy">
                <img src="{{ asset('img/Saudi_Vision_2030_logo.svg') }}"
                     alt="Saudi Vision 2030 Logo"
                     class="h-12 w-auto object-contain"
                     loading="lazy">
            </div>
        </div>
    </div>

    </main>
</x-visitor-layout>

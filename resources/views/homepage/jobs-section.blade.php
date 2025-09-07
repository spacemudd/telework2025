<!-- Jobs Section -->
<section id="jobs" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-3" style="color: rgb(31, 41, 55)">
                {{ __('words.latest_jobs.title') }}
            </h2>
        </div>

        @if($jobPostings->count() > 0)
            <!-- Dynamic Job Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobPostings as $jobPosting)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                        <div class="p-5 border-b border-gray-100">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    {{ __('words.' . $jobPosting->employment_type) }}
                                </span>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $jobPosting->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <h3 class="text-left text-lg font-semibold leading-tight text-gray-900">{{ $jobPosting->title }}</h3>
                            <div class="text-left flex items-center text-gray-600 mt-1">
                                <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
                                {{ $jobPosting->company->name }}
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1118 0z"/></svg>
                                    {{ $jobPosting->location ?? (app()->getLocale() === 'ar' ? 'عن بُعد' : 'Remote') }}
                                </div>
                                @if($jobPosting->salary_min || $jobPosting->salary_max)
                                    <div class="flex items-center text-gray-700" style="color: rgb(31, 41, 55)">
                                        <svg class="h-4 w-4 rtl:ml-1 ltr:mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"/></svg>
                                        @if($jobPosting->salary_min && $jobPosting->salary_max)
                                            {{ number_format($jobPosting->salary_min) }} - {{ number_format($jobPosting->salary_max) }} {{ __('words.sar') }}
                                        @elseif($jobPosting->salary_min)
                                            {{ __('words.from') }} {{ number_format($jobPosting->salary_min) }} {{ __('words.sar') }}
                                        @elseif($jobPosting->salary_max)
                                            {{ __('words.up_to') }} {{ number_format($jobPosting->salary_max) }} {{ __('words.sar') }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('jobs.show', ['jobPosting' => $jobPosting, 'locale' => app()->getLocale()]) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium rounded-md text-white hover:opacity-90" 
                               style="background-color: rgb(31, 41, 55)">
                                {{ app()->getLocale() === 'ar' ? 'عرض التفاصيل' : 'View details' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" 
                   class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    {{ app()->getLocale() === 'ar' ? 'عرض المزيد من الوظائف' : 'Load more jobs' }}
                </a>
            </div>
        @else
            <!-- No Jobs Available -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد وظائف متاحة حالياً' : 'No jobs available at the moment' }}
                </h3>
                <p class="text-gray-500 mb-6">
                    {{ app()->getLocale() === 'ar' ? 'تحقق مرة أخرى قريباً للعثور على فرص جديدة' : 'Check back soon for new opportunities' }}
                </p>
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    {{ app()->getLocale() === 'ar' ? 'تصفح جميع الوظائف' : 'Browse all jobs' }}
                </a>
            </div>
        @endif
    </div>
</section>

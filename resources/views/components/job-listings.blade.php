<!-- Job Listings Grid (shadcn-style) -->
<section id="jobs" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-3" style="color: rgb(31, 41, 55)">
                {{ $title }}
            </h2>
            @if($subtitle)
                <p class="text-lg text-gray-600">{{ $subtitle }}</p>
            @endif
            <p class="mt-4 text-md text-gray-500 max-w-2xl mx-auto">
                تصفح تفاصيل الوظيفة، والوصف الوظيفي، وموقع الوظيفة. أنشئ سيرتك الذاتية وقدّم عليها الآن
            </p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($jobPostings as $jobPosting)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <div class="p-6">
                        <div class="flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="flex items-start mb-4">
                                    <div class="w-16 h-16 flex-shrink-0 mr-4 rtl:ml-4 rtl:mr-0 overflow-hidden rounded-lg bg-gray-100 border border-gray-200">
                                        @if($jobPosting->company->getFirstMedia('logos'))
                                            <img src="{{ $jobPosting->company->getSecureMediaUrlForCollection('logos') }}" alt="{{ $jobPosting->company->name }}" class="w-full h-full object-contain">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                                                <span class="text-xl font-bold">{{ substr($jobPosting->company->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $jobPosting->title }}</h3>
                                        <p class="text-gray-700 text-sm">{{ $jobPosting->company->name }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mb-4">
                                    @if($jobPosting->jobCategory)
                                        <div class="flex items-center gap-1.5 bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                            <span class="text-xs">{{ $jobPosting->jobCategory->localized_name }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($jobPosting->location)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="text-xs">{{ $jobPosting->location }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-xs">{{ __('words.' . $jobPosting->employment_type) }}</span>
                                    </div>
                                    
                                    @if($jobPosting->salary_min || $jobPosting->salary_max)
                                        <div class="flex items-center gap-1.5 font-semibold text-green-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                                            <span class="text-xs">
                                                @if($jobPosting->salary_min && $jobPosting->salary_max)
                                                    {{ number_format($jobPosting->salary_min) }} - {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                                                @elseif($jobPosting->salary_min)
                                                    {{ __('words.from') }} {{ number_format($jobPosting->salary_min) }} {{ __('words.currency') }}
                                                @elseif($jobPosting->salary_max)
                                                    {{ __('words.up_to') }} {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                                                @endif
                                            </span>
                                        </div>
                                    @else
                                        <!-- Invisible placeholder to maintain consistent card height -->
                                        <div class="flex items-center gap-1.5 opacity-0">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                                            <span class="text-xs">Placeholder</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                    {{ Str::limit(strip_tags($jobPosting->description), 150) }}
                                </p>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('jobs.show', ['jobPosting' => $jobPosting->id, 'locale' => app()->getLocale()]) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-transform transform hover:scale-105" 
                                   style="background-color: #012d48; --tw-ring-color: #012d48;"
                                   onmouseover="this.style.backgroundColor='#023a5c'" 
                                   onmouseout="this.style.backgroundColor='#012d48'">
                                    {{ __('words.view_details') }}
                                </a>
                                <div class="text-xs text-gray-400 mt-2 text-center">
                                    {{ __('words.posted') }} {{ $jobPosting->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12">
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
                </div>
            @endforelse
        </div>

        @if($showLoadMore)
            <div class="text-center mt-12">
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    {{ app()->getLocale() === 'ar' ? 'عرض المزيد من الوظائف' : 'Load more jobs' }}
                </a>
            </div>
        @endif
    </div>
</section>

<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>

    <main class="flex-grow">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 relative overflow-hidden">
            <!-- Animated background elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -inset-[10px] opacity-50">
                    <div class="absolute left-[10%] top-[20%] h-24 w-24 rounded-full bg-blue-400 mix-blend-multiply animate-blob"></div>
                    <div class="absolute right-[15%] top-[30%] h-32 w-32 rounded-full bg-indigo-400 mix-blend-multiply animate-blob animation-delay-2000"></div>
                    <div class="absolute left-[20%] bottom-[20%] h-28 w-28 rounded-full bg-purple-400 mix-blend-multiply animate-blob animation-delay-4000"></div>
                </div>
            </div>

            <div class="container mx-auto px-4 py-20 relative">
                <div class="grid grid-cols-12 gap-8 items-center">
                    <div class="col-span-12 lg:col-span-7 space-y-8">
                        <h1 class="text-5xl md:text-5xl lg:text-8xl font-bold text-gray-900 dark:text-white leading-tight text-center md:text-left rtl:md:text-right animate-fade-in-up">
                            {{ __('words.hero.title') }}
                        </h1>
                        <div class="space-y-6 animate-fade-in-up animation-delay-300">
                            <p class="text-xl text-gray-600 dark:text-gray-300">
                                {{ __('words.hero.description') }}
                            </p>
                            <p class="text-lg text-gray-600 dark:text-gray-300">
                                {{ __('words.hero.subtitle') }}
                            </p>
                        </div>
                        
                        <div class="space-y-6 animate-fade-in-up animation-delay-500">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('words.hero.i_am') }}</h2>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="#" class="group inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
                                    <span>{{ __('words.hero.looking_for_employees') }}</span>
                                    <svg class="w-5 h-5 rtl:rotate-180 ltr:ml-2 rtl:mr-2 transition-transform duration-300 ease-out transform ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a href="#" class="group inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                                    <span>{{ __('words.hero.looking_for_job') }}</span>
                                    <svg class="w-5 h-5 rtl:rotate-180 ltr:ml-2 rtl:mr-2 transition-transform duration-300 ease-out transform ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 animate-pulse">{{ __('words.hero.no_risk') }}</p>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-5">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl transform rotate-3 animate-pulse"></div>
                            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 pb-5">
                                <!-- Saudi Arabia Map Container -->
                                <div class="relative w-full aspect-[4/3]">
                                    <div id="saudi-map" class="w-full h-full">
                                        <!-- Map will be injected here via JavaScript -->
                                    </div>
                                    
                                    <!-- Live Activity Indicator -->
                                    <div class="absolute top-4 right-4 flex items-center space-x-2 rtl:space-x-reverse">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                            @if(LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
                                                النشاط
                                            @else
                                                Live Activity
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trusted Companies Section -->
        <div class="bg-white dark:bg-gray-900">
            <div class="container mx-auto px-4 py-20">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        {{ __('words.companies.title') }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300">
                        {{ __('words.companies.subtitle') }}
                    </p>
                </div>
                
                <!-- Company Logos Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 items-center justify-items-center opacity-75">
                    <!-- Add company logos here -->
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="h-12 w-full flex items-center justify-center">
                            <div class="h-8 w-32 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Job Districts Section -->
        <div class="bg-white dark:bg-gray-800">
            <div class="container mx-auto px-4 py-20">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-navy-800 dark:text-white">
                        {{ __('words.opportunities.title') }}
                    </h2>
                    <p class="text-xl text-navy-600 dark:text-gray-300 max-w-3xl mx-auto">
                        {{ __('words.opportunities.subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Sales and Marketing -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.sales') }}</h3>
                    </div>

                    <!-- Accounting and Finance -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.accounting') }}</h3>
                    </div>

                    <!-- Management and Secretary -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.management') }}</h3>
                    </div>

                    <!-- IT and Software -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.it') }}</h3>
                    </div>

                    <!-- Legal Services -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.legal') }}</h3>
                    </div>

                    <!-- HR -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.hr') }}</h3>
                    </div>

                    <!-- Engineering -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.engineering') }}</h3>
                    </div>

                    <!-- Healthcare -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.healthcare') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enterprise Section -->
        <div class="bg-white dark:bg-gray-800 py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-12 gap-8 items-center">
                    <div class="col-span-12 lg:col-span-6 space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-3xl md:text-4xl font-bold text-navy-800 dark:text-white">
                                {{ __('words.enterprise.title') }}
                            </h2>
                            <p class="text-xl text-gray-600 dark:text-gray-300">
                                {{ __('words.enterprise.tagline') }}
                            </p>
                        </div>

                        <div class="space-y-6">
                            <!-- Vetted Professionals -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-navy-800 dark:text-white">
                                        {{ __('words.enterprise.benefits.vetted.title') }}
                                    </h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                                        {{ __('words.enterprise.benefits.vetted.description') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Save Time -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-navy-800 dark:text-white">
                                        {{ __('words.enterprise.benefits.time.title') }}
                                    </h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                                        {{ __('words.enterprise.benefits.time.description') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Reduce Costs -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-navy-800 dark:text-white">
                                        {{ __('words.enterprise.benefits.cost.title') }}
                                    </h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                                        {{ __('words.enterprise.benefits.cost.description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl transform rotate-3"></div>
                            <div class="relative rounded-2xl shadow-xl overflow-hidden aspect-[4/3]">
                                <img 
                                    class="absolute inset-0 w-full h-full object-cover object-center" 
                                    src="{{ asset('img/enterprise-team.jpg') }}" 
                                    alt="Enterprise Team"
                                >
                            </div>
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

        <!-- Latest Jobs Section -->
        <div class="bg-gray-50 dark:bg-gray-900">
            <div class="container mx-auto px-4 py-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        {{ __('words.latest_jobs.title') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    @foreach(__('words.latest_jobs.examples') as $job)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="p-6 space-y-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white line-clamp-2">
                                    {{ $job['title'] }}
                                </h3>
                                <div class="space-y-2">
                                    <div class="text-gray-600 dark:text-gray-300 font-medium">
                                        {{ $job['company'] }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('words.latest_jobs.posted') }}: {{ $job['time_ago'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                        {{ __('words.latest_jobs.view_more') }}
                    </a>
                </div>
            </div>
        </div>

    </main>
</x-visitor-layout>

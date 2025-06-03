<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>

    <div class="relative z-10 py-12 backdrop-blur-sm bg-blue-700/95">
        <div class="max-w-4xl mx-auto px-4">
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
                        <h1 class="text-5xl md:text-5xl lg:text-7xl font-bold text-gray-900 dark:text-white leading-tight text-center md:text-left rtl:md:text-right animate-fade-in-up">
                            {{ __('words.hero.title') }}.
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
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center sm:text-left rtl:sm:text-right">{{ __('words.hero.i_am') }}</h2>
                            <div class="flex flex-col sm:flex-row gap-4 items-center sm:items-start">
                                <a href="#" class="group inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg w-full sm:w-auto text-center">
                                    <span>{{ __('words.hero.looking_for_employees') }}</span>
                                    <svg class="w-5 h-5 rtl:rotate-180 ltr:ml-2 rtl:mr-2 transition-transform duration-300 ease-out transform ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a href="#" class="group inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 w-full sm:w-auto text-center">
                                    <span>{{ __('words.hero.looking_for_job') }}</span>
                                    <svg class="w-5 h-5 rtl:rotate-180 ltr:ml-2 rtl:mr-2 transition-transform duration-300 ease-out transform ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4 mt-4 items-center sm:items-start">
                                <a href="#" class="group inline-flex items-center justify-center px-6 py-3 border border-[#0A66C2] text-base font-medium rounded-lg text-white bg-[#0A66C2] hover:bg-[#004182] transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg w-full sm:w-auto text-center">
                                    <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    <span>{{ __('words.hero.login_linkedin') }}</span>
                                </a>
                                <a href="#" class="group inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg w-full sm:w-auto text-center">
                                    <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" viewBox="0 0 24 24">
                                        <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                                        <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                                        <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                                        <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                                    </svg>
                                    <span>{{ __('words.hero.login_gmail') }}</span>
                                </a>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center sm:text-left rtl:sm:text-right">* {{ __('words.hero.no_risk') }}</p>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-5">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl transform rotate-3"></div>
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
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 items-center justify-items-center opacity-90">
                    <!-- STC -->
                    <div class="h-24 flex items-center justify-center bg-transparent dark:bg-white/10 dark:backdrop-blur-sm rounded-lg p-8 transition-colors duration-200">
                        <img src="https://salogos.org/wp-content/uploads/2024/01/STC-01-2048x1023.png" 
                             alt="STC" 
                             class="h-12 w-auto object-contain dark:brightness-200"
                             loading="lazy">
                    </div>
                    <!-- Aramco -->
                    <div class="h-24 flex items-center justify-center bg-transparent dark:bg-white/10 dark:backdrop-blur-sm rounded-lg p-8 transition-colors duration-200">
                        <img src="https://thegulfobserver.com/wp-content/uploads/2024/02/Saudi-Aramco-logo-2048x1152.png" 
                             alt="Aramco" 
                             class="h-12 w-auto object-contain dark:brightness-200"
                             loading="lazy">
                    </div>
                    <!-- SABIC -->
                    <div class="h-24 flex items-center justify-center bg-transparent dark:bg-white/10 dark:backdrop-blur-sm rounded-lg p-8 transition-colors duration-200">
                        <img src="https://www.sabic.com/en/Images/SABIC-LOGO_tcm1010-14323.svg" 
                             alt="SABIC" 
                             class="h-12 w-auto object-contain dark:brightness-200"
                             loading="lazy">
                    </div>
                    <!-- CCC -->
                    <div class="h-24 flex items-center justify-center bg-transparent dark:bg-white/10 dark:backdrop-blur-sm rounded-lg p-8 transition-colors duration-200">
                        <img src="https://odoocdn.com/web/image/res.partner/11845367/avatar_1920/CCC%20by%20STC?unique=b05ef4c" 
                             alt="CCC by STC" 
                             class="h-12 w-auto object-contain dark:brightness-200"
                             loading="lazy">
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Districts Section -->
        <div class="bg-white dark:bg-gray-800">
            <div class="container mx-auto px-4 py-20">
                <div class="text-center space-y-4 mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-navy-800 dark:text-white">
                    🌱 {{ __('words.opportunities.title') }}
                    </h2>
                    <p class="text-xl text-navy-600 dark:text-gray-300 max-w-3xl mx-auto">
                        {{ __('words.opportunities.subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Sales and Marketing -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.sales') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.8</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(234 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Accounting and Finance -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.accounting') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.5</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(187 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Management and Secretary -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.management') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.7</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(312 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- IT and Software -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.it') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.9</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(456 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Legal Services -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.legal') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.6</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(167 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- HR -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.hr') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.7</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(289 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Engineering -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.engineering') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.8</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(378 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>

                    <!-- Healthcare -->
                    <a href="#" class="group">
                        <div class="bg-white rounded-xl p-6 shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02] border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-600 dark:bg-blue-900 rounded-lg mb-4">
                                <svg class="w-6 h-6 text-white dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-navy-800 dark:text-white mb-2">{{ __('words.opportunities.districts.healthcare') }}</h3>
                            <div class="flex items-center space-x-1 rtl:space-x-reverse mb-1">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-300">4.7</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ltr:ml-2 rtl:mr-2">(245 {{ __('words.opportunities.skills') }})</span>
                            </div>
                        </div>
                    </a>
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

                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
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
                        <a href="#" class="group">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm group-hover:shadow-xl transition-all duration-500 ease-in-out transform group-hover:-translate-y-2 group-hover:scale-[1.02]">
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
                        </a>
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

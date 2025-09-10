<div class="relative bg-white overflow-hidden" style="filter: contrast(100%) brightness(100%); background: linear-gradient(30deg, rgb(255, 255, 255), rgba(255, 255, 255, 0.25) 100%), url(http://localhost:8000/img/grainy-noise.svg);">
    <!-- Large Image - Absolute positioned on right side of entire page -->
    <img src="/img/girls_two.png" alt="Professional women" class="hero-image-large fixed right-0 top-1/2 -translate-y-1/2 object-cover opacity-20 z-0" style="width: 60vw;">
    <style>
        @media (max-width: 1023px) {
            .hero-image-large {
                width: 70vw !important;
            }
        }
        @media (max-width: 767px) {
            .hero-image-large {
                width: 80vw !important;
                opacity: 0.15 !important;
            }
        }
    </style>
    
    <!-- Upward shadow at the bottom to create a stamped effect -->
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-3 md:h-4" style="background: linear-gradient(0deg, rgba(0,0,0,0.15), rgba(0,0,0,0)); z-index: 10;"></div>
    <div class="container mx-auto px-4 py-16 md:py-20 relative z-30">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-12 relative z-40">
                {{ __('words.hero.title') }}
            </h1>

            <!-- Search Card -->
            <div class="bg-transparent rounded-lg p-6 mb-8 max-w-4xl mx-auto relative z-40">
                <form action="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <select name="location" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left focus:outline-none focus:ring-2" style="--tw-ring-color: #012d48; focus:border-transparent; background-color: #efefef;">
                                <option value="" selected disabled>{{ __('words.hero.city_placeholder') }}</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select name="job_category_id" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left focus:outline-none focus:ring-2" style="--tw-ring-color: #012d48; focus:border-transparent; background-color: #efefef;">
                                <option value="" selected disabled>{{ __('words.hero.field_placeholder') }}</option>
                                @foreach($jobCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->localized_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <button type="submit" class="w-full inline-flex items-center rtl:flex-row-reverse justify-center px-4 py-2.5 text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" style="background-color: #012d48;">
                                <svg class="h-4 w-4 rtl:ml-2 ltr:mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                {{ __('words.hero.search_button') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            <p class="mt-4 text-lg text-gray-600 mb-12 relative z-40">
                {{ __('words.hero.description') }}
            </p>

            <div class="mb-16 relative z-40">
                @auth
                    <!-- Logged in user - Single Journey Button -->
                    <a href="{{ URL::localized('dashboard') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full shadow-lg text-white hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="background-color: #012d48;">
                        {{ app()->getLocale() === 'ar' ? __('words.dashboard') : 'Begin your journey' }}
                    </a>
                @else
                    <!-- Guest user - Original buttons -->
                    <a href="{{ URL::localized('register') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full shadow-lg text-white hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="background-color: #012d48;">
                        {{ app()->getLocale() === 'ar' ? 'سجل الآن' : 'Open an account - Apply now' }}
                    </a>
                    
                    <!-- Separator -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-4 py-1 text-sm text-gray-500 bg-white rounded-full border border-gray-300">{{ app()->getLocale() === 'ar' ? 'أو' : 'or' }}</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>
                    
                    <!-- Social Sign In Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <!-- Google Sign In Button -->
                        <a href="{{ route('auth.google') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105 transition-all duration-200 bg-white shadow-md">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            {{ app()->getLocale() === 'ar' ? 'التسجيل عبر جوجل' : 'Sign in with Google' }}
                        </a>
                        
                        <!-- LinkedIn Sign In Button -->
                        <a href="{{ route('auth.linkedin') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105 transition-all duration-200 bg-white shadow-md">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            {{ app()->getLocale() === 'ar' ? 'التسجيل عبر لينكد إن' : 'Sign in with LinkedIn' }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hiring Journey Section - Compact Layout -->
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-6xl font-bold text-gray-800 mb-12">
                        {{ app()->getLocale() === 'ar' ? 'رحلة التوظيف' : 'Hiring Journey' }}
                    </h2>
                    
                    <!-- Three Process Steps -->
                    <div class="max-w-2xl mx-auto space-y-4 relative z-20">
                        <!-- Discovery -->
                        <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-shadow duration-300">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row text-left' : 'flex-row-reverse text-right' }}">
                                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'فرص' : 'Discovery' }}
                                    </h3>
                                    <p class="text-base text-gray-600">
                                        {{ app()->getLocale() === 'ar' ? 'نحضر لك قائمة بالوظائف التي يمكنك التقدم إليها' : 'We prepare for you a list of job opportunities that you can apply to' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Prospect -->
                        <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-shadow duration-300">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row text-left' : 'flex-row-reverse text-right' }}">
                                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'الترشيح' : 'Prospect' }}
                                    </h3>
                                    <p class="text-base text-gray-600">
                                        {{ app()->getLocale() === 'ar' ? 'سنقوم باعداد مقابلات مع الشركات المتوافقة' : 'We will set you up with interviews and hiring companies' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hiring -->
                        <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-shadow duration-300">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row text-left' : 'flex-row-reverse text-right' }}">
                                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'التوظيف' : 'Hiring' }}
                                    </h3>
                                    <p class="text-base text-gray-600">
                                        {{ app()->getLocale() === 'ar' ? 'سنرافقك في كل خطوة الى ان يتم توظفيك' : 'We will accompany you with every step until you are hired' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

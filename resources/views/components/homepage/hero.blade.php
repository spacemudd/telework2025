<div class="relative bg-white overflow-hidden" style="filter: contrast(100%) brightness(100%); background: linear-gradient(30deg, rgb(255, 255, 255), rgba(255, 255, 255, 0.25) 100%), url(http://localhost:8000/img/grainy-noise.svg);">
    <div class="container mx-auto px-4 py-16 md:py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-12">
                {{ __('words.hero.title') }}
            </h1>

            <!-- Search Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8 max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative">
                        <svg class="absolute rtl:left-3 ltr:right-3 top-1/2 -translate-y-1/2 text-gray-400 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" placeholder="{{ __('words.hero.search_job_placeholder') }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 rtl:pl-10 rtl:pr-3 ltr:pr-10 ltr:pl-3 rtl:text-right ltr:text-left focus:outline-none focus:ring-2" style="--tw-ring-color: #012d48; focus:border-transparent" />
                    </div>

                    <div>
                        <select dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left bg-white focus:outline-none focus:ring-2" style="--tw-ring-color: #012d48; focus:border-transparent">
                            <option value="" selected disabled>{{ __('words.hero.city_placeholder') }}</option>
                            <option value="riyadh">{{ app()->getLocale() === 'ar' ? 'الرياض' : 'Riyadh' }}</option>
                            <option value="jeddah">{{ app()->getLocale() === 'ar' ? 'جدة' : 'Jeddah' }}</option>
                            <option value="dammam">{{ app()->getLocale() === 'ar' ? 'الدمام' : 'Dammam' }}</option>
                            <option value="makkah">{{ app()->getLocale() === 'ar' ? 'مكة المكرمة' : 'Makkah' }}</option>
                            <option value="medina">{{ app()->getLocale() === 'ar' ? 'المدينة المنورة' : 'Medina' }}</option>
                        </select>
                    </div>

                    <div>
                        <select dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="block w-full border border-gray-300 rounded-md py-2.5 px-3 rtl:text-right ltr:text-left bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="" selected disabled>{{ __('words.hero.field_placeholder') }}</option>
                            <option value="technology">{{ app()->getLocale() === 'ar' ? 'التكنولوجيا' : 'Technology' }}</option>
                            <option value="finance">{{ app()->getLocale() === 'ar' ? 'المالية' : 'Finance' }}</option>
                            <option value="healthcare">{{ app()->getLocale() === 'ar' ? 'الرعاية الصحية' : 'Healthcare' }}</option>
                            <option value="education">{{ app()->getLocale() === 'ar' ? 'التعليم' : 'Education' }}</option>
                            <option value="engineering">{{ app()->getLocale() === 'ar' ? 'الهندسة' : 'Engineering' }}</option>
                        </select>
                    </div>

                    <div>
                        <button type="button" class="w-full inline-flex items-center rtl:flex-row-reverse justify-center px-4 py-2.5 text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" style="background-color: #012d48;">
                            <svg class="h-4 w-4 rtl:ml-2 ltr:mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            {{ __('words.hero.search_button') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- New elements for the hero section, based on the image -->
            <div class="mb-12">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ __('words.hero.job_seekers_connected') }}
                </span>
            </div>

            <p class="mt-4 text-lg text-gray-600 mb-12">
                {{ __('words.hero.description') }}
            </p>

            <div class="mb-16 relative z-20">
                <button type="button" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full shadow-lg text-white hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="background-color: #012d48;">
                    🌟 {{ app()->getLocale() === 'ar' ? 'افتح حسابك الآن' : 'Open an account - Apply now' }}
                </button>
            </div>

            <!-- Hiring Journey Section - Compact Layout -->
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                    <!-- Left Side: Title and Benefits -->
                    <div class="flex flex-col justify-center relative">
                        <!-- Image - Absolute positioned -->
                        <img src="/img/girls.png" alt="Professional women" class="hero-image absolute object-cover opacity-30 z-0" style="right: -30px;">
                        <style>
                            @media (min-width: 1024px) {
                                .hero-image {
                                    right: -100px !important;
                                }
                            }
                        </style>
                        
                        <div class="relative z-20">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 xs:text-center sm:text-start">
                                {{ app()->getLocale() === 'ar' ? 'رحلة التوظيف' : 'Hiring Journey' }}
                            </h2>
                            
                            <ul class="space-y-3 text-base text-gray-700">
                            <li class="flex items-center justify-center lg:justify-start {{ app()->getLocale() === 'ar' ? 'lg:flex-row lg:text-left' : 'lg:flex-row-reverse lg:text-right' }} text-center">
                                <svg class="h-5 w-5 text-green-500 flex-shrink-0 {{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'لا عاد تشيل هم تصميم سيرة ذاتية' : 'No more worrying about CV design' }}
                            </li>
                            <li class="flex items-center justify-center lg:justify-start {{ app()->getLocale() === 'ar' ? 'lg:flex-row lg:text-left' : 'lg:flex-row-reverse lg:text-right' }} text-center">
                                <svg class="h-5 w-5 text-green-500 flex-shrink-0 {{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'ننبهك و نعيد جدولة التوظيف متى ما احببت' : 'We notify and reschedule hiring whenever you prefer' }}
                            </li>
                            <li class="flex items-center justify-center lg:justify-start {{ app()->getLocale() === 'ar' ? 'lg:flex-row lg:text-left' : 'lg:flex-row-reverse lg:text-right' }} text-center">
                                <svg class="h-5 w-5 text-green-500 flex-shrink-0 {{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'حدد طلباتك و بيئة العمل المراد بها' : 'Define your requirements and desired work environment' }}
                            </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Side: Three Process Steps -->
                    <div class="space-y-4 relative z-20">
                        <!-- Discovery -->
                        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row text-left' : 'flex-row-reverse text-right' }}">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'الاكتشاف' : 'Discovery' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ app()->getLocale() === 'ar' ? 'نحضر لك قائمة بالوظائف التي يمكنك التقدم إليها' : 'We prepare for you a list of job opportunities that you can apply to' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Prospect -->
                        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row text-left' : 'flex-row-reverse text-right' }}">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'الترشيح' : 'Prospect' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ app()->getLocale() === 'ar' ? 'سنرتب لك المقابلات مع الشركات المهتمة بتوظيفك' : 'We will set you up with interviews and hiring companies' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Hiring -->
                        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row text-left' : 'flex-row-reverse text-right' }}">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 713.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'التوظيف' : 'Hiring' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ app()->getLocale() === 'ar' ? 'سنرافقك في كل خطوة حتى يتم توظيفك' : 'We will accompany you with every step until you are hired' }}
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

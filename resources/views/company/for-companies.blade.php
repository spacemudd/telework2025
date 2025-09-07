<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32
                        {{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'lg:ml-auto' : '' }}">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-20">
                    <div class="sm:text-center lg:text-left {{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'lg:text-right' : '' }}">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">{{ __('words.enterprise.title') }}</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            {{ __('words.enterprise.tagline') }}
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start {{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'lg:justify-end' : '' }}">
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                    {{ __('words.enterprise.cta.hire') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'lg:left-0' : 'lg:right-0' }} lg:absolute lg:inset-y-0 lg:w-1/2">
            <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('img/enterprise-hero.jpg') }}" alt="{{ __('words.enterprise.image_overlay') }}">
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="py-12 bg-gray-50 scroll-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('words.enterprise.cta.header') }}
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    {{ __('words.enterprise.cta.subtext') }}
                </p>
            </div>

            <div class="mt-20">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                    <!-- Vetted Professionals -->
                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white
                                        {{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'right-0' : 'left-0' }}">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'mr-16' : 'ml-16' }} text-lg leading-6 font-medium text-gray-900">
                                {{ __('words.enterprise.benefits.vetted.title') }}
                            </p>
                        </dt>
                        <dd class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'mr-16' : 'ml-16' }} mt-2 text-base text-gray-500">
                            {{ __('words.enterprise.benefits.vetted.description') }}
                        </dd>
                    </div>

                    <!-- Save Time -->
                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white
                                        {{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'right-0' : 'left-0' }}">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'mr-16' : 'ml-16' }} text-lg leading-6 font-medium text-gray-900">
                                {{ __('words.enterprise.benefits.time.title') }}
                            </p>
                        </dt>
                        <dd class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'mr-16' : 'ml-16' }} mt-2 text-base text-gray-500">
                            {{ __('words.enterprise.benefits.time.description') }}
                        </dd>
                    </div>

                    <!-- Reduce Costs -->
                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white
                                        {{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'right-0' : 'left-0' }}">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'mr-16' : 'ml-16' }} text-lg leading-6 font-medium text-gray-900">
                                {{ __('words.enterprise.benefits.cost.title') }}
                            </p>
                        </dt>
                        <dd class="{{ LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? 'mr-16' : 'ml-16' }} mt-2 text-base text-gray-500">
                            {{ __('words.enterprise.benefits.cost.description') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="bg-white py-20 scroll-animate">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: rgb(31, 41, 55)">
                    {{ app()->getLocale() === 'ar' ? 'هل تبحث عن موظفين؟' : 'Are you an employer?' }}
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ app()->getLocale() === 'ar' ? 'انضم الى هدف و اعثر على افضل المواهب لفريقك' : 'Join our network of top companies and hire the best talent' }}
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
                <div class="text-center scroll-animate delay-100">
                    <div class="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">+50,000</h3>
                    <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'باحث عن عمل نشط' : 'Active candidates' }}</p>
                </div>
                <div class="text-center scroll-animate delay-200">
                    <div class="bg-green-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">85%</h3>
                    <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'معدل نجاح التوظيف' : 'Hiring success rate' }}</p>
                </div>
                <div class="text-center scroll-animate delay-300">
                    <div class="bg-purple-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">+200</h3>
                    <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'شركة تثق بنا' : 'Companies trust us' }}</p>
                </div>
                <div class="text-center scroll-animate delay-400">
                    <div class="bg-orange-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <svg class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2" style="color: rgb(31, 41, 55)">15</h3>
                    <p class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'يوم متوسط مدة التوظيف' : 'Avg. days to hire' }}</p>
                </div>
            </div>

            <!-- Pricing -->
            <div id="pricing" class="mb-16">
                <h3 class="text-2xl font-bold text-center mb-12" style="color: rgb(31, 41, 55)">
                    {{ app()->getLocale() === 'ar' ? 'اختر الخطة المناسبة لشركتك' : 'Choose the right plan' }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- Basic -->
                    <div class="relative border rounded-lg p-6 scroll-animate delay-100">
                        <div class="text-center">
                            <h4 class="text-xl font-semibold mb-2">{{ app()->getLocale() === 'ar' ? 'الخطة الأساسية' : 'Basic' }}</h4>
                            <div class="mb-4">
                                <span class="text-4xl font-bold" style="color: rgb(31, 41, 55)">499 {{ app()->getLocale() === 'ar' ? 'ريال' : 'SAR' }}</span>
                                <span class="text-gray-600">/{{ app()->getLocale() === 'ar' ? 'شهرياً' : 'mo' }}</span>
                            </div>
                            <p class="text-gray-600 mb-6">{{ app()->getLocale() === 'ar' ? 'مثالية للقطاع الخاص الصغير' : 'Great for small teams' }}</p>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'نشر حتى 5 وظائف شهرياً' : 'Post up to 5 jobs/mo' }}</span></li>
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'عرض في نتائج البحث' : 'Search visibility' }}</span></li>
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'دعم فني أساسي' : 'Basic support' }}</span></li>
                        </ul>
                        <a href="#contact" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'اختر هذه الخطة' : 'Choose plan' }}</a>
                    </div>

                    <!-- Pro (popular) -->
                    <div class="relative border-2 rounded-lg p-6 shadow-xl scroll-animate delay-200" style="border-color: rgb(31, 41, 55)">
                        <div class="absolute -top-4 right-1/2 translate-x-1/2">
                            <span class="inline-flex items-center px-4 py-1 text-white text-sm rounded-full" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'الأكثر شعبية' : 'Most popular' }}</span>
                        </div>
                        <div class="text-center">
                            <h4 class="text-xl font-semibold mb-2">{{ app()->getLocale() === 'ar' ? 'الخطة الاحترافية' : 'Pro' }}</h4>
                            <div class="mb-4">
                                <span class="text-4xl font-bold" style="color: rgb(31, 41, 55)">999 {{ app()->getLocale() === 'ar' ? 'ريال' : 'SAR' }}</span>
                                <span class="text-gray-600">/{{ app()->getLocale() === 'ar' ? 'شهرياً' : 'mo' }}</span>
                            </div>
                            <p class="text-gray-600 mb-6">{{ app()->getLocale() === 'ar' ? 'الأفضل للقطاع الخاص المتوسط' : 'Best for growing teams' }}</p>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'نشر حتى 20 وظيفة شهرياً' : 'Post up to 20 jobs/mo' }}</span></li>
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'أولوية في نتائج البحث' : 'Priority placement' }}</span></li>
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'دعم فني مخصص' : 'Dedicated support' }}</span></li>
                            <li class="flex items-center text-right"><svg class="h-5 w-5 text-green-500 ml-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span class="text-gray-700">{{ app()->getLocale() === 'ar' ? 'تقارير تفصيلية' : 'Detailed reports' }}</span></li>
                        </ul>
                        <a href="#contact" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'اختر هذه الخطة' : 'Choose plan' }}</a>
                    </div>

                    <!-- Enterprise -->
                    <div class="relative border rounded-lg p-6 scroll-animate delay-300">
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
                        <a href="#contact" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white hover:opacity-90" style="background-color: rgb(31, 41, 55)">{{ app()->getLocale() === 'ar' ? 'تواصل معنا' : 'Contact sales' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Table -->
    <div class="bg-gray-50 py-16 sm:py-24 scroll-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    {{ __('words.pricing.comparison.title') }}
                </h2>
                <p class="mt-4 text-xl text-gray-500">
                    {{ __('words.pricing.comparison.subtitle') }}
                </p>
            </div>

            <div class="mt-12">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('words.pricing.comparison.feature') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('words.pricing.basic.title') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('words.pricing.pro.title') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('words.pricing.enterprise.title') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.ads') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">3/{{ __('words.month') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">6/{{ __('words.month') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">150/{{ __('words.year') }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.communication') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.users') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">3</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.promote') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.duration') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.filter') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ __('words.pricing.comparison.features.esign') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-green-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                <svg class="h-5 w-5 text-red-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-white py-16 sm:py-24 scroll-animate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    {{ __('words.faq.title') }}
                </h2>
                <p class="mt-4 text-xl text-gray-500">
                    {{ __('words.faq.subtitle') }}
                </p>
            </div>

            <div class="mt-12 max-w-3xl mx-auto divide-y divide-gray-200">
                <div x-data="{ open: false }" class="py-6">
                    <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                        <span class="text-lg font-medium text-gray-900">{{ __('words.faq.questions.q1') }}</span>
                        <span class="ml-6 flex-shrink-0">
                            <svg class="h-6 w-6 transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-2 pr-12">
                        <p class="text-base text-gray-500">{{ __('words.faq.answers.a1') }}</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="py-6">
                    <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                        <span class="text-lg font-medium text-gray-900">{{ __('words.faq.questions.q2') }}</span>
                        <span class="ml-6 flex-shrink-0">
                            <svg class="h-6 w-6 transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-2 pr-12">
                        <p class="text-base text-gray-500">{{ __('words.faq.answers.a2') }}</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="py-6">
                    <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                        <span class="text-lg font-medium text-gray-900">{{ __('words.faq.questions.q3') }}</span>
                        <span class="ml-6 flex-shrink-0">
                            <svg class="h-6 w-6 transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-2 pr-12">
                        <p class="text-base text-gray-500">{{ __('words.faq.answers.a3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div id="contact" class="bg-gray-50 py-16 px-4 sm:px-6 lg:py-24 lg:px-8 scroll-animate">
        <div class="max-w-3xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('words.contact_us') }}
                </h2>
                <p class="mt-4 text-lg leading-6 text-gray-500">
                    {{ __('words.contact_form_description') }}
                </p>
            </div>
            <div class="mt-12">
                <form action="{{ route('company.contact.submit', ['locale' => app()->getLocale()]) }}" method="POST" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    @csrf
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('words.name') }}</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" autocomplete="name" class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="company_name" class="block text-sm font-medium text-gray-700">{{ __('words.company_name') }}</label>
                        <div class="mt-1">
                            <input type="text" name="company_name" id="company_name" class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" required>
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('words.email') }}</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" autocomplete="email" class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" required>
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('words.phone') }}</label>
                        <div class="mt-1">
                            <input type="text" name="phone" id="phone" autocomplete="tel" class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="employees_count" class="block text-sm font-medium text-gray-700">{{ __('words.employees_count') }}</label>
                        <div class="mt-1">
                            <select id="employees_count" name="employees_count" class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" required>
                                <option value="">{{ __('words.select_option') }}</option>
                                <option value="1-10">1-10</option>
                                <option value="11-50">11-50</option>
                                <option value="51-200">51-200</option>
                                <option value="201-500">201-500</option>
                                <option value="501+">501+</option>
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message" class="block text-sm font-medium text-gray-700">{{ __('words.message') }}</label>
                        <div class="mt-1">
                            <textarea id="message" name="message" rows="4" class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" required></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('words.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-visitor-layout>

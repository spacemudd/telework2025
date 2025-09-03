<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>

    <!-- Latest Jobs Section (Carousel) - Moved to Top -->
        <div class="bg-gray-50">
            <div class="container mx-auto px-4 py-12 md:py-16">
                <div class="text-center mb-2">
                    <span class="text-2xl font-bold text-blue-700">نبني الفريق ونصنع القادة.</span>
                </div>
            <div class="text-center space-y-2 mb-6">
                <h2 class="text-3xl md:text-4xl font-bold text-black">
                    {{ __('words.latest_jobs.title') }}
                </h2>
                <p class="text-gray-600">
                    {{ __('words.hero.looking_for_job') }}
                </p>
            </div>

            <div x-data="{
                    next() {
                        const c = this.$refs.c;
                        const gap = parseFloat(getComputedStyle(c).columnGap) || 12;
                        const width = c.firstElementChild ? c.firstElementChild.getBoundingClientRect().width : 320;
                        const delta = width + gap;
                        c.scrollBy({ left: (document.dir === 'rtl' ? -delta : delta), behavior: 'smooth' });
                    },
                    prev() {
                        const c = this.$refs.c;
                        const gap = parseFloat(getComputedStyle(c).columnGap) || 12;
                        const width = c.firstElementChild ? c.firstElementChild.getBoundingClientRect().width : 320;
                        const delta = width + gap;
                        c.scrollBy({ left: (document.dir === 'rtl' ? delta : -delta), behavior: 'smooth' });
                    }
                }" class="relative">
                <!-- Carousel Track -->
                <div class="flex gap-3 overflow-x-auto snap-x snap-mandatory pb-4" x-ref="c">
                    @foreach(__('words.latest_jobs.examples') as $job)
                            <a href="#" class="snap-start flex-none group px-2">
                            <div class="bg-white rounded-xl border w-[400px] border-gray-100 shadow-sm group-hover:shadow transition-all duration-300 ease-in-out h-full flex flex-col">
                                <div class="p-6 space-y-4 flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                            <img src="{{ $job['company_logo'] ?? asset('img/hadaf.png') }}" alt="{{ $job['company'] }}" class="h-10 w-10 object-contain" loading="lazy">
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm text-gray-600 font-medium truncate">{{ $job['company'] }}</div>
                                            <div class="text-xs text-gray-500 truncate">{{ $job['location'] ?? '' }}</div>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold text-black line-clamp-2">{{ $job['title'] }}</h3>
                                    <div class="flex items-center flex-wrap gap-2">
                                        @php $typeKey = $job['contract_type'] ?? 'fulltime'; @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ __('words.latest_jobs.contract_types.' . $typeKey) }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-700 border border-gray-100">
                                            {{ __('words.latest_jobs.posted') }}: {{ $job['time_ago'] }}
                                        </span>
                                    </div>
                                </div>
                                    <div class="px-6 pb-6">
                                        <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                                            {{ app()->getLocale() === 'ar' ? 'قدّم الآن' : 'Apply now' }}
                                        </a>
                                    </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Controls -->
                <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center">
                    <button @click="prev" type="button" class="hidden md:inline-flex h-10 w-10 items-center justify-center rounded-full bg-white shadow ring-1 ring-gray-200 text-gray-700 hover:bg-gray-50" aria-label="Previous">
                        <svg class="h-5 w-5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
                <div class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center">
                    <button @click="next" type="button" class="hidden md:inline-flex h-10 w-10 items-center justify-center rounded-full bg-white shadow ring-1 ring-gray-200 text-gray-700 hover:bg-gray-50" aria-label="Next">
                        <svg class="h-5 w-5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                    {{ __('words.latest_jobs.view_more') }}
                </a>
            </div>
        </div>
    </div>

    

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

    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    جميع القطاعات
                </h2>
            </div>
            
            <!-- Talent Categories Grid - Dynamic Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @foreach($talentCategories as $category)
                <div class="group relative bg-gray-50 hover:bg-blue-600 rounded-xl p-8 text-center transition-all duration-300 cursor-pointer"
                     onclick="window.location.href='{{ route('talent-categories.show', $category) }}'">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-blue-100 group-hover:bg-white/20 rounded-lg flex items-center justify-center transition-colors duration-300">
                            @include('components.talent-category-icon', ['icon' => $category->icon])
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">
                        {{ $category->localized_name }}
                    </h3>
                    <p class="text-gray-600 group-hover:text-blue-100 text-sm leading-relaxed mb-6 transition-colors duration-300">
                        {{ $category->localized_description }}
                    </p>
                    <!-- View Talents Button (appears on hover) -->
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors duration-200">
                            {{ __('words.view_talents') }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


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
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 items-center justify-items-center opacity-90">
                    <!-- STC -->
                    <div class="h-24 flex items-center justify-center bg-transparent rounded-lg p-8 transition-colors duration-200">
                        <img src="https://salogos.org/wp-content/uploads/2024/01/STC-01-2048x1023.png"
                             alt="STC"
                             class="h-12 w-auto object-contain"
                             loading="lazy">
                    </div>
                    <!-- Aramco -->
                    <div class="h-24 flex items-center justify-center bg-transparent rounded-lg p-8 transition-colors duration-200">
                        <img src="https://thegulfobserver.com/wp-content/uploads/2024/02/Saudi-Aramco-logo-2048x1152.png"
                             alt="Aramco"
                             class="h-12 w-auto object-contain"
                             loading="lazy">
                    </div>
                    <!-- SABIC -->
                    <div class="h-24 flex items-center justify-center bg-transparent rounded-lg p-8 transition-colors duration-200">
                        <img src="https://www.sabic.com/en/Images/SABIC-LOGO_tcm1010-14323.svg"
                             alt="SABIC"
                             class="h-12 w-auto object-contain"
                             loading="lazy">
                    </div>
                    <!-- CCC -->
                    <div class="h-24 flex items-center justify-center bg-transparent rounded-lg p-8 transition-colors duration-200">
                        <img src="https://odoocdn.com/web/image/res.partner/11845367/avatar_1920/CCC%20by%20STC?unique=b05ef4c"
                             alt="CCC by STC"
                             class="h-12 w-auto object-contain"
                             loading="lazy">
                    </div>
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
                                {{ __('words.enterprise.title') }}
                            </h2>
                            <p class="text-xl text-gray-600">
                                {{ __('words.enterprise.tagline') }}
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
                                            {{ __('words.enterprise.benefits.vetted.title') }}
                                        </h3>
                                        <p class="mt-2 text-gray-600">
                                            {{ __('words.enterprise.benefits.vetted.description') }}
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
                                            {{ __('words.enterprise.benefits.time.title') }}
                                        </h3>
                                        <p class="mt-2 text-gray-600">
                                            {{ __('words.enterprise.benefits.time.description') }}
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
                                            {{ __('words.enterprise.benefits.cost.title') }}
                                        </h3>
                                        <p class="mt-2 text-gray-600">
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

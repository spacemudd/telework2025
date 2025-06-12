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
                                <a href="#contact" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
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
    <div class="py-12 bg-gray-50">
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

    <!-- Rating Section -->
    <div class="bg-white py-16 sm:py-24">
        <div class="relative">
            <div class="absolute inset-0 h-1/2 bg-gray-50"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-2">
                        <div class="px-6 py-8 sm:p-10">
                            <div class="flex items-center justify-center h-20 w-20 rounded-md bg-blue-500 text-white mx-auto">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <div class="mt-4 text-center">
                                <h3 class="text-5xl font-extrabold text-gray-900">{{ __('words.enterprise.rating') }}</h3>
                                <p class="mt-4 text-lg text-gray-500">{{ __('words.enterprise.rating_subtitle') }}</p>
                            </div>
                        </div>
                        <div class="py-8 px-6 text-center bg-gray-50 sm:p-10">
                            <div class="mt-4">
                                <a href="#contact" class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    {{ __('words.enterprise.cta.pricing') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div id="contact" class="bg-gray-50 py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
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
                <form action="{{ route('company.contact.submit') }}" method="POST" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
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

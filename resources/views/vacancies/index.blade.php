<x-visitor-layout>
    <x-slot name="seo">
        <title>{{ __('words.footer.company.careers') }} - {{ config('app.name') }}</title>
        <meta name="description" content="{{ __('words.footer.company.careers') }}">
    </x-slot>

    <div class="bg-gray-50 min-h-screen py-12 flex items-center justify-center">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex justify-center mb-6">
                        <div class="bg-blue-100 rounded-full p-4">
                            <svg class="h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        {{ __('words.vacancies.no_vacancies_title') }}
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        {{ __('words.vacancies.no_vacancies_message') }}
                    </p>
                            <div class="mt-8">
                                <a href="/{{ app()->getLocale() }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out transform hover:shadow-lg">
                                    <span>{{ __('words.vacancies.back_home') }}</span>
                                </a>
                            </div>
                </div>
            </div>
        </div>
    </div>
</x-visitor-layout>

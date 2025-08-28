<x-visitor-layout>
    <x-slot name="seo">
        <title>{{ __('words.talent_categories') }} - {{ __('words.app_name') }}</title>
        <meta name="description" content="{{ __('words.explore_talent_categories_description') }}">
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ __('words.talent_categories') }}</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __('words.explore_talent_categories_description') }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
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
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors duration-200">
                        {{ __('words.view_talents') }}
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-visitor-layout>

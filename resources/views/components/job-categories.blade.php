<section class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('words.all_sectors') }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($categories as $category)
                <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $category->icon_svg !!}
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left">{{ $category->localized_name }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="#" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">{{ __('words.view_more_sectors') }}</a>
        </div>
    </div>
</section>
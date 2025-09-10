<section class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __('words.all_sectors') }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            @foreach($categories as $category)
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale(), 'job_category_id' => $category->id]) }}" 
                   class="block bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $category->icon_svg !!}
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 rtl:text-right ltr:text-left group-hover:text-blue-700 transition-colors duration-200">{{ $category->localized_name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>

        
    </div>
</section>
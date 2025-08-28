<x-visitor-layout>
    <x-slot name="seo">
        <title>{{ $category->localized_name }} - {{ __('words.talent_categories') }} - {{ __('words.app_name') }}</title>
        <meta name="description" content="{{ $category->localized_description }}">
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $category->localized_name }}</h1>
            <p class="text-lg text-gray-600">{{ $category->localized_description }}</p>
        </div>
        
        <!-- Search and Filter -->
        <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">{{ __('words.search_placeholder') }}</label>
                    <input type="text" id="search" placeholder="{{ __('words.search_placeholder') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="md:w-48">
                    <label for="experience-filter" class="block text-sm font-medium text-gray-700 mb-2">{{ __('auth.experience_level') }}</label>
                    <select id="experience-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{ __('words.all_experience_levels') }}</option>
                        <option value="entry">{{ __('auth.entry_level') }}</option>
                        <option value="mid_level">{{ __('auth.mid_level') }}</option>
                        <option value="senior">{{ __('auth.senior_level') }}</option>
                        <option value="expert">{{ __('auth.expert_level') }}</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Job Seekers Grid -->
        <div id="job-seekers-container">
            @include('talent-categories.partials.job-seekers-grid', ['jobSeekers' => $jobSeekers])
        </div>
    </div>

    @push('scripts')
    <script>
    // Add search and filter functionality
    document.getElementById('search').addEventListener('input', debounce(performSearch, 300));
    document.getElementById('experience-filter').addEventListener('change', performSearch);

    function performSearch() {
        const search = document.getElementById('search').value;
        const experience = document.getElementById('experience-filter').value;
        
        fetch('{{ route("talent-categories.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                q: search,
                category_id: {{ $category->id }},
                experience_level: experience
            })
        })
        .then(response => response.json())
        .then(data => {
            // Update the job seekers grid
            document.getElementById('job-seekers-container').innerHTML = data.html;
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    </script>
    @endpush
</x-visitor-layout>

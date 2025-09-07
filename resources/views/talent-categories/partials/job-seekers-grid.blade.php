@if($jobSeekers->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($jobSeekers as $jobSeeker)
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                <span class="text-blue-600 font-semibold text-lg">{{ substr($jobSeeker->name, 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900">{{ $jobSeeker->name }}</h3>
                <p class="text-sm text-gray-500">{{ $jobSeeker->email }}</p>
            </div>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-700 text-sm line-clamp-3">{{ $jobSeeker->skills }}</p>
        </div>
        
        <div class="flex justify-between items-center mb-4">
            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                {{ __('auth.' . $jobSeeker->experience_level) }}
            </span>
            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                {{ __('auth.' . $jobSeeker->preferred_work_type) }}
            </span>
        </div>
        
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($jobSeeker->talentCategories as $talentCategory)
            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                {{ $talentCategory->localized_name }}
            </span>
            @endforeach
        </div>
        
        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200">
            {{ __('words.view_profile') }}
        </button>
    </div>
    @endforeach
</div>

<div class="mt-8">
    {{ $jobSeekers->links() }}
</div>
@else
<div class="text-center py-12">
    <div class="text-gray-400 mb-4">
        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    </div>
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('words.no_job_seekers_found') }}</h3>
    <p class="text-gray-500">{{ __('words.no_job_seekers_in_category') }}</p>
</div>
@endif

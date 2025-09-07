<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('words.my_applications') }}</h1>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($applications as $application)
                <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-grow">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 flex-shrink-0 mr-4 overflow-hidden rounded bg-gray-100">
                                        @if($application->jobPosting->company->getFirstMedia('logos'))
                                            <img src="{{ $application->jobPosting->company->getSecureMediaUrlForCollection('logos') }}" alt="{{ $application->jobPosting->company->name }}" class="w-full h-full object-cover object-center">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                                                <span class="text-xs">{{ __('words.no_logo') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-800">{{ $application->jobPosting->title }}</h2>
                                        <p class="text-gray-600">{{ $application->jobPosting->company->name }}</p>
                                        
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($application->status == 'pending')
                                                    bg-yellow-100 text-yellow-800
                                                @elseif($application->status == 'reviewing')
                                                    bg-blue-100 text-blue-800
                                                @elseif($application->status == 'interview')
                                                    bg-purple-100 text-purple-800
                                                @elseif($application->status == 'accepted')
                                                    bg-green-100 text-green-800
                                                @elseif($application->status == 'rejected')
                                                    bg-red-100 text-red-800
                                                @endif
                                            ">
                                                {{ __('words.' . $application->status) }}
                                            </span>
                                            <span class="text-sm text-gray-500">{{ __('words.applied_on') }}: {{ $application->created_at->format('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 md:ml-4">
                                <a href="{{ route('jobs.show', ['jobPosting' => $application->jobPosting->id, 'locale' => app()->getLocale()]) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('words.view_job') }}
                                </a>
                            </div>
                        </div>
                        
                        @if($application->cover_letter)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">{{ __('words.your_cover_letter') }}</h3>
                                <p class="text-sm text-gray-600">{{ $application->cover_letter }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('words.no_applications_found') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('words.start_applying_to_jobs') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('words.browse_jobs') }}
                        </a>
                    </div>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</x-visitor-layout>

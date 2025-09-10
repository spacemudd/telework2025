<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start mb-6">
                        <div class="w-16 h-16 flex-shrink-0 rtl:ml-4 ltr:mr-4 overflow-hidden rounded bg-gray-100">
                            @if($jobPosting->company->getFirstMedia('logos'))
                                <img src="{{ $jobPosting->company->getSecureMediaUrlForCollection('logos') }}" alt="{{ $jobPosting->company->name }}" class="w-full h-full object-cover object-center">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                                    <span class="text-xs">{{ __('words.no_logo') }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $jobPosting->title }}</h1>
                            <p class="text-lg text-gray-600">{{ $jobPosting->company->name }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 border-b border-gray-200 pb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('words.' . $jobPosting->employment_type) }}</span>
                            </div>
                        </div>

                        @if($jobPosting->sector)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l3-3h12l3 3M9 21V10h6v11"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $jobPosting->sector->localized_name }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($jobPosting->location)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $jobPosting->location }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($jobPosting->salary_min || $jobPosting->salary_max)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path>
                                    </svg>
                                    <span class="text-gray-700">
                                        @if($jobPosting->salary_min && $jobPosting->salary_max)
                                            {{ number_format($jobPosting->salary_min) }} - {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                                        @elseif($jobPosting->salary_min)
                                            {{ __('words.from') }} {{ number_format($jobPosting->salary_min) }} {{ __('words.currency') }}
                                        @elseif($jobPosting->salary_max)
                                            {{ __('words.up_to') }} {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('words.job_description') }}</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($jobPosting->description)) !!}
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-center border-t border-gray-200 pt-6">
                        <div class="mb-4 md:mb-0">
                            <p class="text-sm text-gray-500">{{ __('words.posted_date') }}: {{ $jobPosting->created_at->format('Y-m-d') }}</p>
                            @if($jobPosting->closing_date)
                                <p class="text-sm text-gray-500">{{ __('words.closing_date') }}: {{ $jobPosting->closing_date->format('Y-m-d') }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-4">
                            <button id="share-button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12s-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path></svg>
                                {{ __('words.share') }}
                            </button>
                            @if(Auth::check())
                                @if($hasApplied)
                                    <button disabled class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium">
                                        {{ __('words.already_applied') }}
                                    </button>
                                @else
                                    <button onclick="document.getElementById('application-form-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                                        {{ __('words.apply_for_job') }}
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                                    {{ __('words.login_to_apply') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-center">
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; {{ __('words.back_to_jobs') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('share-button').addEventListener('click', function() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: url
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Job URL copied to clipboard!');
                }).catch(err => {
                    console.error('Could not copy text: ', err);
                });
            }
        });
    </script>

    <!-- Application Modal -->
    @if(Auth::check() && !$hasApplied)
        <div id="application-form-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">{{ __('words.apply_for_job') }}</h2>
                        <button onclick="document.getElementById('application-form-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <form action="{{ route('jobs.apply', ['jobPosting' => $jobPosting->id, 'locale' => app()->getLocale()]) }}" method="POST" class="p-4">
                    @csrf
                    <div class="mb-6">
                        <p class="text-gray-700">{{ __('words.confirm_application') }}</p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('application-form-modal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            {{ __('words.cancel') }}
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                            {{ __('words.submit_application') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-visitor-layout>

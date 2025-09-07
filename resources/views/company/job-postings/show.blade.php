@extends('layouts.company')

@section('title', $jobPosting->title)

@section('company-content')
    <div class="p-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $jobPosting->title }}</h1>
            <div class="flex space-x-3 rtl:space-x-reverse">
                <a href="{{ route('company.job-postings.edit', $jobPosting) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    {{ __('words.edit') }}
                </a>
                <a href="{{ route('company.job-postings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    {{ __('words.back') }}
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $jobPosting->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $jobPosting->is_active ? __('words.active') : __('words.inactive') }}
                        </span>
                        <span class="text-sm text-gray-500">{{ __('words.created') }}: {{ $jobPosting->created_at->format('Y-m-d') }}</span>
                    </div>
                    <form action="{{ route('company.job-postings.toggle-status', $jobPosting) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm {{ $jobPosting->is_active ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }}">
                            {{ $jobPosting->is_active ? __('words.deactivate') : __('words.activate') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.category') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $jobPosting->jobCategory->localized_name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.employment_type') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ __('words.employment_types.' . $jobPosting->employment_type) }}</p>
                    </div>
                    @if($jobPosting->location)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('words.location') }}</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPosting->location }}</p>
                        </div>
                    @endif
                    @if($jobPosting->closing_date)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('words.closing_date') }}</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPosting->closing_date->format('Y-m-d') }}</p>
                        </div>
                    @endif
                    @if($jobPosting->salary_min || $jobPosting->salary_max)
                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500">{{ __('words.salary_range') }}</h3>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($jobPosting->salary_min && $jobPosting->salary_max)
                                    {{ number_format($jobPosting->salary_min) }} - {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                                @elseif($jobPosting->salary_min)
                                    {{ __('words.from') }} {{ number_format($jobPosting->salary_min) }} {{ __('words.currency') }}
                                @elseif($jobPosting->salary_max)
                                    {{ __('words.up_to') }} {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">{{ __('words.description') }}</h3>
                    <div class="prose max-w-none text-sm text-gray-900">
                        {!! nl2br(e($jobPosting->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications Section -->
        @if($jobPosting->applications->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('words.applications') }} ({{ $jobPosting->applications->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($jobPosting->applications as $application)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $application->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $application->created_at->format('Y-m-d H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

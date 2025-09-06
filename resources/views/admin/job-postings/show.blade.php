@extends('layouts.admin')

@section('title', __('words.job_posting_details'))

@section('admin-content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('words.job_posting_details') }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.job-postings.edit', $jobPosting->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    {{ __('words.edit') }}
                </a>
                <a href="{{ route('admin.job-postings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    {{ __('words.back') }}
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800">{{ $jobPosting->title }}</h2>
                        <p class="text-gray-600">{{ $jobPosting->company->name }}</p>
                    </div>
                    <div>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $jobPosting->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $jobPosting->is_active ? __('words.active') : __('words.inactive') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.job_category') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $jobPosting->jobCategory->localized_name ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.employment_type') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ __('words.' . $jobPosting->employment_type) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.location') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $jobPosting->location ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.salary_range') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($jobPosting->salary_min && $jobPosting->salary_max)
                                {{ number_format($jobPosting->salary_min) }} - {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                            @elseif($jobPosting->salary_min)
                                {{ __('words.from') }} {{ number_format($jobPosting->salary_min) }} {{ __('words.currency') }}
                            @elseif($jobPosting->salary_max)
                                {{ __('words.up_to') }} {{ number_format($jobPosting->salary_max) }} {{ __('words.currency') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.closing_date') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $jobPosting->closing_date ? $jobPosting->closing_date->format('Y-m-d') : '-' }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('words.created_at') }}</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $jobPosting->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">{{ __('words.description') }}</h3>
                    <div class="mt-1 prose max-w-full">
                        {!! nl2br(e($jobPosting->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Applicants -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">{{ __('words.applicants') }}</h2>
            </div>
            <div class="p-6">
                @if($jobPosting->applications->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.applicant') }}
                                </th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.status') }}
                                </th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.applied_date') }}
                                </th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jobPosting->applications as $application)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $application->user->name }}
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $application->user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $application->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900" onclick="toggleCoverLetter('{{ $application->id }}')">
                                            {{ __('words.view_cover_letter') }}
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 hidden" id="cover-letter-{{ $application->id }}">
                                    <td colspan="4" class="px-6 py-4">
                                        <div class="text-sm text-gray-800">
                                            <h4 class="font-medium mb-2">{{ __('words.cover_letter') }}</h4>
                                            <p>{{ $application->cover_letter ?? __('words.no_cover_letter_provided') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-4 text-gray-500">
                        {{ __('words.no_applicants_found') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleCoverLetter(id) {
            const element = document.getElementById('cover-letter-' + id);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
@endsection

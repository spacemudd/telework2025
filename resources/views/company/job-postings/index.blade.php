@extends('layouts.company')

@section('title', __('words.job_postings'))

@section('company-content')
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('words.job_postings') }}</h1>
            <a href="{{ route('company.job-postings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                {{ __('words.create_job_posting') }}
            </a>
        </div>

        @if($jobPostings->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.title') }}
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.category') }}
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.employment_type') }}
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.applications') }}
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.status') }}
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('words.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jobPostings as $jobPosting)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $jobPosting->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $jobPosting->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jobPosting->jobCategory->localized_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ __('words.employment_types.' . $jobPosting->employment_type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jobPosting->applications_count ?? $jobPosting->applications->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $jobPosting->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $jobPosting->is_active ? __('words.active') : __('words.inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 rtl:space-x-reverse">
                                        <a href="{{ route('company.job-postings.show', $jobPosting) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ __('words.view') }}
                                        </a>
                                        <a href="{{ route('company.job-postings.edit', $jobPosting) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ __('words.edit') }}
                                        </a>
                                        <form action="{{ route('company.job-postings.toggle-status', $jobPosting) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                {{ $jobPosting->is_active ? __('words.deactivate') : __('words.activate') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('company.job-postings.destroy', $jobPosting) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('words.are_you_sure') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                {{ __('words.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-3 border-t border-gray-200">
                    {{ $jobPostings->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6z"></path>
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('words.no_job_postings') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('words.get_started_by_creating_job_posting') }}</p>
                <div class="mt-6">
                    <a href="{{ route('company.job-postings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        {{ __('words.create_job_posting') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

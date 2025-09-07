@extends('layouts.admin')

@section('title', __('words.job_postings'))

@section('admin-content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('words.job_postings') }}</h1>
            <a href="{{ route('admin.job-postings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                {{ __('words.create_job_posting') }}
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.title') }}
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.company') }}
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.employment_type') }}
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.location') }}
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.posted_date') }}
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.status') }}
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('words.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobPostings as $jobPosting)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $jobPosting->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $jobPosting->company->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ __('words.' . $jobPosting->employment_type) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $jobPosting->location ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $jobPosting->created_at->format('Y-m-d') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $jobPosting->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $jobPosting->is_active ? __('words.active') : __('words.inactive') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <a href="{{ route('admin.job-postings.show', $jobPosting) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ __('words.view') }}
                                    </a>
                                    <a href="{{ route('admin.job-postings.edit', $jobPosting) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ __('words.edit') }}
                                    </a>
                                    <form action="{{ route('admin.job-postings.toggle-status', $jobPosting) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="{{ $jobPosting->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}">
                                            {{ $jobPosting->is_active ? __('words.disable') : __('words.enable') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.job-postings.destroy', $jobPosting) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('words.are_you_sure') }}')">
                                            {{ __('words.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                {{ __('words.no_job_postings_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile/Tablet Card View -->
        <div class="md:hidden space-y-4">
            @forelse($jobPostings as $jobPosting)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $jobPosting->title }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $jobPosting->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $jobPosting->is_active ? __('words.active') : __('words.inactive') }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-20">{{ __('words.company') }}:</span>
                            <span class="text-sm text-gray-900">{{ $jobPosting->company->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-20">{{ __('words.type') }}:</span>
                            <span class="text-sm text-gray-900">{{ __('words.' . $jobPosting->employment_type) }}</span>
                        </div>
                        @if($jobPosting->location)
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-20">{{ __('words.location') }}:</span>
                            <span class="text-sm text-gray-900">{{ $jobPosting->location }}</span>
                        </div>
                        @endif
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-20">{{ __('words.posted_date') }}:</span>
                            <span class="text-sm text-gray-900">{{ $jobPosting->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.job-postings.show', $jobPosting) }}" 
                           class="flex-1 bg-indigo-50 text-indigo-700 px-3 py-2 rounded-md text-sm font-medium text-center hover:bg-indigo-100">
                            {{ __('words.view') }}
                        </a>
                        <a href="{{ route('admin.job-postings.edit', $jobPosting) }}" 
                           class="flex-1 bg-blue-50 text-blue-700 px-3 py-2 rounded-md text-sm font-medium text-center hover:bg-blue-100">
                            {{ __('words.edit') }}
                        </a>
                        <form action="{{ route('admin.job-postings.toggle-status', $jobPosting) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full {{ $jobPosting->is_active ? 'bg-orange-50 text-orange-700 hover:bg-orange-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }} px-3 py-2 rounded-md text-sm font-medium">
                                {{ $jobPosting->is_active ? __('words.disable') : __('words.enable') }}
                            </button>
                        </form>
                        <form action="{{ route('admin.job-postings.destroy', $jobPosting) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-700 px-3 py-2 rounded-md text-sm font-medium hover:bg-red-100" 
                                    onclick="return confirm('{{ __('words.are_you_sure') }}')">
                                {{ __('words.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <div class="text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('words.no_job_postings_found') }}</h3>
                        <p class="text-gray-500">{{ __('words.create_your_first_job_posting') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $jobPostings->links() }}
        </div>
    </div>
@endsection
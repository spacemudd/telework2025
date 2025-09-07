@extends('layouts.company')

@section('title', __('words.edit_job_posting'))

@section('company-content')
    <div class="p-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('words.edit_job_posting') }}</h1>
            <a href="{{ route('company.job-postings.show', $jobPosting) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                {{ __('words.back') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('company.job-postings.update', $jobPosting) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Job Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.title') }} *
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobPosting->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Category -->
                    <div>
                        <label for="job_category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.category') }} *
                        </label>
                        <select name="job_category_id" id="job_category_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('words.select_category') }}</option>
                            @foreach($jobCategories as $category)
                                <option value="{{ $category->id }}" {{ old('job_category_id', $jobPosting->job_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->localized_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employment Type -->
                    <div>
                        <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.employment_type') }} *
                        </label>
                        <select name="employment_type" id="employment_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('words.select_employment_type') }}</option>
                            <option value="full_time" {{ old('employment_type', $jobPosting->employment_type) == 'full_time' ? 'selected' : '' }}>{{ __('words.employment_types.full_time') }}</option>
                            <option value="part_time" {{ old('employment_type', $jobPosting->employment_type) == 'part_time' ? 'selected' : '' }}>{{ __('words.employment_types.part_time') }}</option>
                            <option value="contract" {{ old('employment_type', $jobPosting->employment_type) == 'contract' ? 'selected' : '' }}>{{ __('words.employment_types.contract') }}</option>
                            <option value="freelance" {{ old('employment_type', $jobPosting->employment_type) == 'freelance' ? 'selected' : '' }}>{{ __('words.employment_types.freelance') }}</option>
                            <option value="remote" {{ old('employment_type', $jobPosting->employment_type) == 'remote' ? 'selected' : '' }}>{{ __('words.employment_types.remote') }}</option>
                        </select>
                        @error('employment_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.location') }}
                        </label>
                        <input type="text" name="location" id="location" value="{{ old('location', $jobPosting->location) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Closing Date -->
                    <div>
                        <label for="closing_date" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.closing_date') }}
                        </label>
                        <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date', $jobPosting->closing_date?->format('Y-m-d')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('closing_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary Range -->
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.salary_min') }}
                        </label>
                        <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min', $jobPosting->salary_min) }}" min="0" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('salary_min')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.salary_max') }}
                        </label>
                        <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max', $jobPosting->salary_max) }}" min="0" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('salary_max')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $jobPosting->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="mr-2 rtl:ml-2 text-sm text-gray-700">{{ __('words.active') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.description') }} *
                    </label>
                    <textarea name="description" id="description" rows="8" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $jobPosting->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-3 rtl:space-x-reverse">
                    <a href="{{ route('company.job-postings.show', $jobPosting) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                        {{ __('words.cancel') }}
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        {{ __('words.update_job_posting') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

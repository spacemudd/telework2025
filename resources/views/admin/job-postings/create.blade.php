@extends('layouts.admin')

@section('title', __('words.create_job_posting'))

@section('admin-content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('words.create_job_posting') }}</h1>
            <a href="{{ route('admin.job-postings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                {{ __('words.back') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.job-postings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.title') }} *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Selection/Creation Toggle -->
                <div class="mb-6">
                    <div class="flex space-x-4 rtl:space-x-reverse mb-4">
                        <label class="flex items-center">
                            <input type="radio" name="company_option" value="existing" id="existing_company" checked
                                   class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" onchange="toggleCompanyOption()">
                            <span class="ml-2 text-sm text-gray-700">{{ __('words.select_existing_company') }}</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="company_option" value="new" id="new_company"
                                   class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" onchange="toggleCompanyOption()">
                            <span class="ml-2 text-sm text-gray-700">{{ __('words.create_new_company') }}</span>
                        </label>
                    </div>

                    <!-- Existing Company Selection -->
                    <div id="existing_company_section">
                        <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.company') }} *
                        </label>
                        <select name="company_id" id="company_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('words.select_company') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Company Creation -->
                    <div id="new_company_section" style="display: none;">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('words.company_information') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('words.company_name') }} *
                                    </label>
                                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('company_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="company_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('words.email') }}
                                    </label>
                                    <input type="email" name="company_email" id="company_email" value="{{ old('company_email') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('company_email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('words.phone') }}
                                    </label>
                                    <input type="text" name="company_phone" id="company_phone" value="{{ old('company_phone') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('company_phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="company_website" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ __('words.website') }}
                                    </label>
                                    <input type="url" name="company_website" id="company_website" value="{{ old('company_website') }}"
                                           placeholder="https://example.com"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('company_website')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="company_logo" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('words.company_logo') }}
                                </label>
                                <input type="file" name="company_logo" id="company_logo" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">{{ __('words.logo_upload_help') }}</p>
                                @error('company_logo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="job_category_id" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.job_categories') }} *
                    </label>
                    <select name="job_category_id" id="job_category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">{{ __('words.select_option') }}</option>
                        @foreach($jobCategories as $category)
                            <option value="{{ $category->id }}" {{ old('job_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->localized_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('job_category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.employment_type') }} *
                    </label>
                    <select name="employment_type" id="employment_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>
                            {{ __('words.full_time') }}
                        </option>
                        <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>
                            {{ __('words.part_time') }}
                        </option>
                        <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>
                            {{ __('words.contract') }}
                        </option>
                        <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>
                            {{ __('words.freelance') }}
                        </option>
                        <option value="remote" {{ old('employment_type') == 'remote' ? 'selected' : '' }}>
                            {{ __('words.remote') }}
                        </option>
                    </select>
                    @error('employment_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.location') }}
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.salary_min') }}
                        </label>
                        <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min') }}"
                               min="0" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('salary_min')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('words.salary_max') }}
                        </label>
                        <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max') }}"
                               min="0" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('salary_max')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="closing_date" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.closing_date') }}
                    </label>
                    <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('closing_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('words.description') }} *
                    </label>
                    <textarea name="description" id="description" rows="8" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            {{ __('words.is_active') }}
                        </label>
                    </div>
                    @error('is_active')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        {{ __('words.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleCompanyOption() {
            const existingCompany = document.getElementById('existing_company');
            const newCompany = document.getElementById('new_company');
            const existingSection = document.getElementById('existing_company_section');
            const newSection = document.getElementById('new_company_section');
            const companyIdSelect = document.getElementById('company_id');
            const companyNameInput = document.getElementById('company_name');

            if (existingCompany.checked) {
                existingSection.style.display = 'block';
                newSection.style.display = 'none';
                companyIdSelect.required = true;
                companyNameInput.required = false;
            } else if (newCompany.checked) {
                existingSection.style.display = 'none';
                newSection.style.display = 'block';
                companyIdSelect.required = false;
                companyNameInput.required = true;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleCompanyOption();
        });
    </script>
@endsection

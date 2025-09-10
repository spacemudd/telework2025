<x-guest-layout>
    <!-- Step Indicator -->
    <x-onboarding-steps :currentStep="2" />

    <div class="mb-8">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            {{ __('auth.work_experience') }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ __('auth.add_work_experience_help') }}
        </p>

        <form class="my-10 space-y-6" action="{{ route('onboarding.job-seeker.step2.complete', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf

            <div id="experiences-container">
                <!-- Experience Entry Template -->
                <div class="experience-entry bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('auth.work_experience') }}</h3>
                        <button type="button" class="remove-experience text-red-600 hover:text-red-800 hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Job Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('auth.job_title') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="experiences[0][job_title]" 
                                       required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Company Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('auth.company_name') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="experiences[0][company_name]" 
                                       required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('auth.start_date') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1">
                                <input type="month" 
                                       name="experiences[0][start_date]" 
                                       required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- End Date / Current -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('auth.end_date') }}
                            </label>
                            <div class="mt-1">
                                <input type="month" 
                                       name="experiences[0][end_date]" 
                                       class="end-date appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" 
                                           name="experiences[0][is_current]" 
                                           value="1"
                                           class="is-current rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('auth.currently_working_here') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">
                            {{ __('auth.job_description') }}
                        </label>
                        <div class="mt-1">
                            <textarea name="experiences[0][description]" 
                                      rows="3"
                                      placeholder="{{ __('auth.describe_responsibilities') }}"
                                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Experience Button -->
            <div class="text-center">
                <button type="button" 
                        id="add-experience" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('auth.add_another_experience') }}
                </button>
            </div>

            <!-- Skip Option -->
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-4">{{ __('auth.no_work_experience_yet') }}</p>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('onboarding.job-seeker', ['locale' => app()->getLocale()]) }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} {{ app()->getLocale() === 'ar' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('auth.back') }}
                </a>

                <div class="flex gap-3">
                    <button type="submit" 
                            name="skip" 
                            value="1"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        {{ __('auth.skip_for_now') }}
                    </button>

                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('auth.next') }}
                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }} {{ app()->getLocale() === 'ar' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let experienceCount = 1;

        document.getElementById('add-experience').addEventListener('click', function() {
            const container = document.getElementById('experiences-container');
            const template = container.querySelector('.experience-entry').cloneNode(true);
            
            // Update field names with new index
            const inputs = template.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('[0]', `[${experienceCount}]`);
                    input.value = '';
                    input.checked = false;
                }
            });

            // Show remove button for new entries
            const removeBtn = template.querySelector('.remove-experience');
            removeBtn.classList.remove('hidden');
            
            // Add remove functionality
            removeBtn.addEventListener('click', function() {
                template.remove();
                updateExperienceIndices();
            });

            container.appendChild(template);
            experienceCount++;
            
            // Update remove button visibility
            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            const entries = document.querySelectorAll('.experience-entry');
            entries.forEach((entry, index) => {
                const removeBtn = entry.querySelector('.remove-experience');
                if (entries.length > 1) {
                    removeBtn.classList.remove('hidden');
                } else {
                    removeBtn.classList.add('hidden');
                }
            });
        }

        function updateExperienceIndices() {
            const entries = document.querySelectorAll('.experience-entry');
            entries.forEach((entry, index) => {
                const inputs = entry.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                    }
                });
            });
        }

        // Handle current job checkboxes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('is-current')) {
                const endDateInput = e.target.closest('.experience-entry').querySelector('.end-date');
                if (e.target.checked) {
                    endDateInput.disabled = true;
                    endDateInput.value = '';
                    endDateInput.classList.add('bg-gray-100');
                } else {
                    endDateInput.disabled = false;
                    endDateInput.classList.remove('bg-gray-100');
                }
            }
        });

        // Initialize remove button functionality for existing entries
        document.querySelectorAll('.remove-experience').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.experience-entry').remove();
                updateExperienceIndices();
                updateRemoveButtons();
            });
        });

        // Initialize remove button visibility
        updateRemoveButtons();
    </script>
</x-guest-layout>

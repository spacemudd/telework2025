<x-guest-layout>
    <!-- Step Indicator -->
    <x-onboarding-steps :currentStep="1" />

    <div class="mb-8">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            {{ __('auth.tell_us_about_yourself') }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ __('auth.help_customize_job_experience') }}
        </p>

        <form class="my-10 space-y-6" action="{{ route('onboarding.job-seeker.step1.complete', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf

            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.first_name') }} <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <input id="first_name" 
                           name="first_name" 
                           type="text" 
                           autocomplete="given-name" 
                           required 
                           value="{{ old('first_name', auth()->user()->first_name) }}"
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                @error('first_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.last_name') }} <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <input id="last_name" 
                           name="last_name" 
                           type="text" 
                           autocomplete="family-name" 
                           required 
                           value="{{ old('last_name', auth()->user()->last_name) }}"
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                @error('last_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Skills -->
            <div>
                <label for="skills" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.skills') }} <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <select id="skills-select" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">{{ __('auth.select_skills') }}</option>
                        @foreach($skills as $skill)
                            <option value="{{ $skill->id }}" data-name="{{ $skill->display_name }}">{{ $skill->display_name }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Selected Skills Breadcrumbs -->
                    <div id="selected-skills" class="mt-3 flex flex-wrap gap-2 min-h-[40px] p-2 border border-gray-200 rounded-md bg-gray-50">
                        @if(old('skills'))
                            @foreach(old('skills') as $skillId)
                                @php
                                    $skill = $skills->find($skillId);
                                @endphp
                                @if($skill)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $skill->display_name }}
                                        <button type="button" class="ml-2 text-blue-600 hover:text-blue-800" onclick="removeSkill({{ $skill->id }})">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    
                    <!-- Hidden input to store selected skill IDs -->
                    <input type="hidden" name="skills" id="skills-input" value="{{ old('skills') ? implode(',', old('skills')) : '' }}">
                </div>
                <p class="mt-2 text-sm text-gray-500">{{ __('auth.skills_help_text') }}</p>
                @error('skills')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Years of Experience -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    {{ __('auth.years_of_experience') }} <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <!-- None -->
                    <div class="relative">
                        <input type="radio" 
                               id="experience_none" 
                               name="experience_level" 
                               value="none" 
                               class="sr-only peer" 
                               required
                               {{ old('experience_level') == 'none' ? 'checked' : '' }}>
                        <label for="experience_none" 
                               class="flex items-center justify-center w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                            <span class="text-sm font-medium">{{ __('auth.none') }}</span>
                        </label>
                    </div>

                    <!-- 1-3 years -->
                    <div class="relative">
                        <input type="radio" 
                               id="experience_1_3" 
                               name="experience_level" 
                               value="1_3_years" 
                               class="sr-only peer" 
                               required
                               {{ old('experience_level') == '1_3_years' ? 'checked' : '' }}>
                        <label for="experience_1_3" 
                               class="flex items-center justify-center w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                            <span class="text-sm font-medium">{{ __('auth.1_3_years') }}</span>
                        </label>
                    </div>

                    <!-- 3-5 years -->
                    <div class="relative">
                        <input type="radio" 
                               id="experience_3_5" 
                               name="experience_level" 
                               value="3_5_years" 
                               class="sr-only peer" 
                               required
                               {{ old('experience_level') == '3_5_years' ? 'checked' : '' }}>
                        <label for="experience_3_5" 
                               class="flex items-center justify-center w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                            <span class="text-sm font-medium">{{ __('auth.3_5_years') }}</span>
                        </label>
                    </div>

                    <!-- 5+ years -->
                    <div class="relative">
                        <input type="radio" 
                               id="experience_5_plus" 
                               name="experience_level" 
                               value="5_plus_years" 
                               class="sr-only peer" 
                               required
                               {{ old('experience_level') == '5_plus_years' ? 'checked' : '' }}>
                        <label for="experience_5_plus" 
                               class="flex items-center justify-center w-full p-3 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                            <span class="text-sm font-medium">{{ __('auth.5_plus_years') }}</span>
                        </label>
                    </div>
                </div>
                @error('experience_level')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preferred Work Type -->
            <div>
                <label for="preferred_work_type" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.preferred_work_type') }} <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <select id="preferred_work_type" 
                            name="preferred_work_type" 
                            required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">{{ __('auth.select_work_type') }}</option>
                        <option value="full_time" {{ old('preferred_work_type') == 'full_time' ? 'selected' : '' }}>{{ __('auth.full_time') }}</option>
                        <option value="part_time" {{ old('preferred_work_type') == 'part_time' ? 'selected' : '' }}>{{ __('auth.part_time') }}</option>
                        <option value="contract" {{ old('preferred_work_type') == 'contract' ? 'selected' : '' }}>{{ __('auth.contract') }}</option>
                    </select>
                </div>
                @error('preferred_work_type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex items-center justify-between">
                <a href="{{ route('onboarding.index', ['locale' => app()->getLocale()]) }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} {{ app()->getLocale() === 'ar' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('auth.back') }}
                </a>

                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('auth.next') }}
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }} {{ app()->getLocale() === 'ar' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        let selectedSkills = [];
        
        // Initialize selected skills from old input
        @if(old('skills'))
            selectedSkills = {!! json_encode(old('skills')) !!};
        @endif

        document.getElementById('skills-select').addEventListener('change', function() {
            const skillId = this.value;
            const skillName = this.options[this.selectedIndex].getAttribute('data-name');
            
            if (skillId && !selectedSkills.includes(skillId)) {
                selectedSkills.push(skillId);
                addSkillBreadcrumb(skillId, skillName);
                updateHiddenInput();
            }
            
            // Reset select
            this.value = '';
        });

        function addSkillBreadcrumb(skillId, skillName) {
            const container = document.getElementById('selected-skills');
            const breadcrumb = document.createElement('span');
            breadcrumb.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
            breadcrumb.innerHTML = `
                ${skillName}
                <button type="button" class="ml-2 text-blue-600 hover:text-blue-800" onclick="removeSkill(${skillId})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(breadcrumb);
        }

        function removeSkill(skillId) {
            selectedSkills = selectedSkills.filter(id => id != skillId);
            updateHiddenInput();
            
            // Remove breadcrumb from DOM
            const container = document.getElementById('selected-skills');
            const breadcrumbs = container.querySelectorAll('span');
            breadcrumbs.forEach(breadcrumb => {
                const button = breadcrumb.querySelector('button');
                if (button && button.getAttribute('onclick').includes(skillId)) {
                    breadcrumb.remove();
                }
            });
        }

        function updateHiddenInput() {
            document.getElementById('skills-input').value = selectedSkills.join(',');
        }
    </script>
</x-guest-layout>

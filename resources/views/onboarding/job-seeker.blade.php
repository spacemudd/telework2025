<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-2xl w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('auth.tell_us_about_yourself') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ __('auth.help_customize_job_experience') }}
                </p>
            </div>

            <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
                <form class="space-y-6" action="{{ route('onboarding.job-seeker.complete') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.full_name') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="full_name" 
                                   name="full_name" 
                                   type="text" 
                                   autocomplete="name" 
                                   required 
                                   value="{{ old('full_name', auth()->user()->name) }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        @error('full_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.skills') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <textarea id="skills" 
                                      name="skills" 
                                      rows="3"
                                      placeholder="{{ __('auth.describe_your_skills') }}"
                                      required
                                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('skills') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">{{ __('auth.skills_help_text') }}</p>
                        @error('skills')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience Level -->
                    <div>
                        <label for="experience_level" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.experience_level') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="experience_level" 
                                    name="experience_level" 
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">{{ __('auth.select_experience_level') }}</option>
                                <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>{{ __('auth.entry_level') }}</option>
                                <option value="mid_level" {{ old('experience_level') == 'mid_level' ? 'selected' : '' }}>{{ __('auth.mid_level') }}</option>
                                <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>{{ __('auth.senior_level') }}</option>
                                <option value="expert" {{ old('experience_level') == 'expert' ? 'selected' : '' }}>{{ __('auth.expert_level') }}</option>
                            </select>
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
                                <option value="freelance" {{ old('preferred_work_type') == 'freelance' ? 'selected' : '' }}>{{ __('auth.freelance') }}</option>
                            </select>
                        </div>
                        @error('preferred_work_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('onboarding.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('auth.back') }}
                        </a>

                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('auth.complete_setup') }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

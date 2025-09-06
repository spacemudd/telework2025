<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-2xl w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('auth.tell_us_about_company') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ __('auth.help_customize_experience') }}
                </p>
            </div>

            <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
                <form class="space-y-6" action="{{ route('onboarding.company.complete', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.company_name') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="company_name" 
                                   name="company_name" 
                                   type="text" 
                                   autocomplete="organization" 
                                   required 
                                   value="{{ old('company_name') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        @error('company_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Size -->
                    <div>
                        <label for="company_size" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.company_size') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="company_size" 
                                    name="company_size" 
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">{{ __('auth.select_company_size') }}</option>
                                <option value="1-10" {{ old('company_size') == '1-10' ? 'selected' : '' }}>1-10 {{ __('auth.employees') }}</option>
                                <option value="11-50" {{ old('company_size') == '11-50' ? 'selected' : '' }}>11-50 {{ __('auth.employees') }}</option>
                                <option value="51-200" {{ old('company_size') == '51-200' ? 'selected' : '' }}>51-200 {{ __('auth.employees') }}</option>
                                <option value="201-500" {{ old('company_size') == '201-500' ? 'selected' : '' }}>201-500 {{ __('auth.employees') }}</option>
                                <option value="500+" {{ old('company_size') == '500+' ? 'selected' : '' }}>500+ {{ __('auth.employees') }}</option>
                            </select>
                        </div>
                        @error('company_size')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Industry -->
                    <div>
                        <label for="industry" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.industry') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="industry" 
                                    name="industry" 
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">{{ __('auth.select_your_industry') }}</option>
                                <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>{{ __('auth.technology') }}</option>
                                <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>{{ __('auth.healthcare') }}</option>
                                <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>{{ __('auth.finance') }}</option>
                                <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>{{ __('auth.education') }}</option>
                                <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>{{ __('auth.retail') }}</option>
                                <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>{{ __('auth.manufacturing') }}</option>
                                <option value="Consulting" {{ old('industry') == 'Consulting' ? 'selected' : '' }}>{{ __('auth.consulting') }}</option>
                                <option value="Real Estate" {{ old('industry') == 'Real Estate' ? 'selected' : '' }}>{{ __('auth.real_estate') }}</option>
                                <option value="Media & Marketing" {{ old('industry') == 'Media & Marketing' ? 'selected' : '' }}>{{ __('auth.media_marketing') }}</option>
                                <option value="Government" {{ old('industry') == 'Government' ? 'selected' : '' }}>{{ __('auth.government') }}</option>
                                <option value="Non-profit" {{ old('industry') == 'Non-profit' ? 'selected' : '' }}>{{ __('auth.non_profit') }}</option>
                                <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>{{ __('auth.other') }}</option>
                            </select>
                        </div>
                        @error('industry')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expected Time to Hire -->
                    <div>
                        <label for="expected_time_to_hire" class="block text-sm font-medium text-gray-700">
                            {{ __('auth.when_expect_start_hiring') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="expected_time_to_hire" 
                                    name="expected_time_to_hire" 
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">{{ __('auth.select_timeframe') }}</option>
                                <option value="immediately" {{ old('expected_time_to_hire') == 'immediately' ? 'selected' : '' }}>{{ __('auth.immediately') }}</option>
                                <option value="1-2_weeks" {{ old('expected_time_to_hire') == '1-2_weeks' ? 'selected' : '' }}>{{ __('auth.in_1_2_weeks') }}</option>
                                <option value="1_month" {{ old('expected_time_to_hire') == '1_month' ? 'selected' : '' }}>{{ __('auth.in_1_month') }}</option>
                                <option value="3_months" {{ old('expected_time_to_hire') == '3_months' ? 'selected' : '' }}>{{ __('auth.in_3_months') }}</option>
                                <option value="6_months" {{ old('expected_time_to_hire') == '6_months' ? 'selected' : '' }}>{{ __('auth.in_6_months') }}</option>
                                <option value="not_sure" {{ old('expected_time_to_hire') == 'not_sure' ? 'selected' : '' }}>{{ __('auth.not_sure_yet') }}</option>
                            </select>
                        </div>
                        @error('expected_time_to_hire')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('onboarding.index', ['locale' => app()->getLocale()]) }}" 
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
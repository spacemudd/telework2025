<x-guest-layout>
    <form method="POST" action="{{ route('register', ['locale' => app()->getLocale()]) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
        @csrf

        <!-- Account Type -->
        @if(request()->filled('role'))
        <input type="hidden" name="role_type" value="{{ request('role') }}">
        @else
        <div class="mt-2">
            <x-input-label for="role_type" :value="__('auth.select_what_describes_you')" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div class="relative">
                    <input type="radio"
                           id="register_company"
                           name="role_type"
                           value="company"
                           class="sr-only peer"
                           @checked(old('role_type', request('role')) === 'company')
                           required>
                    <label for="register_company"
                           class="flex items-center justify-center w-full h-full min-h-[100px] p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                        <div class="flex items-center justify-center w-10 h-10 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-base font-semibold text-center">{{ __('auth.i_represent_company') }}</div>
                            @if(__('auth.i_want_hire_remote_workers'))
                            <div class="text-xs text-center">{{ __('auth.i_want_hire_remote_workers') }}</div>
                            @endif
                        </div>
                    </label>
                </div>

                <div class="relative">
                    <input type="radio"
                           id="register_job_seeker"
                           name="role_type"
                           value="job_seeker"
                           class="sr-only peer"
                           @checked(old('role_type', request('role')) === 'job_seeker')
                           required>
                    <label for="register_job_seeker"
                           class="flex items-center justify-center w-full h-full min-h-[100px] p-4 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                        <div class="flex items-center justify-center w-10 h-10 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-base font-semibold text-center">{{ __('auth.im_looking_for_job') }}</div>
                            @if(__('auth.i_want_find_remote_work'))
                            <div class="text-xs text-center">{{ __('auth.i_want_find_remote_work') }}</div>
                            @endif
                        </div>
                    </label>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role_type')" class="mt-2" />
        </div>
        @endif

        <!-- First Name -->
        <div class="mt-6">
            <x-input-label for="first_name" :value="__('auth.first_name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('auth.last_name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('auth.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" dir="ltr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mobile -->
        <div class="mt-4">
            <x-input-label for="mobile" :value="__('words.mobile')" />
            <x-text-input id="mobile" class="block mt-1 w-full" type="tel" name="mobile" :value="old('mobile')" required autocomplete="tel" dir="ltr" />
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('auth.password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            dir="ltr"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('auth.password_confirmation')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            dir="ltr"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login', ['locale' => app()->getLocale()]) }}">
                {{ __('auth.already_registered') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('auth.register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <!-- Social Sign In Section -->
    <div class="mb-6">
        <div class="flex flex-col gap-4 justify-center items-center">
            <!-- Google Sign In Button -->
            <a href="{{ route('auth.google') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105 transition-all duration-200 bg-white shadow-md">
                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                {{ app()->getLocale() === 'ar' ? 'التسجيل عبر جوجل' : 'Sign in with Google' }}
            </a>
            
            <!-- LinkedIn Sign In Button -->
            <a href="{{ route('auth.linkedin') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-full border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105 transition-all duration-200 bg-white shadow-md">
                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                {{ app()->getLocale() === 'ar' ? 'التسجيل عبر لينكد إن' : 'Sign in with LinkedIn' }}
            </a>
        </div>
    </div>

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

        <!-- First Name and Last Name -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_name" :value="__('auth.first_name')" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="last_name" :value="__('auth.last_name')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
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

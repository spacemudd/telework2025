<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('auth.welcome_get_started') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ __('auth.select_what_describes_you') }}
                </p>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('onboarding.select-role') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- Company Option -->
                    <div class="relative">
                        <input type="radio" 
                               id="company" 
                               name="role_type" 
                               value="company" 
                               class="sr-only peer" 
                               required>
                        <label for="company" 
                               class="flex flex-col items-center justify-center w-full p-6 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                            <div class="flex items-center justify-center w-16 h-16 mb-4 bg-blue-100 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="text-lg font-semibold text-left rtl:text-left ltr:text-right">{{ __('auth.i_represent_company') }}</div>
                            <div class="text-sm text-left rtl:text-left ltr:text-right mt-2">{{ __('auth.i_want_hire_remote_workers') }}</div>
                        </label>
                    </div>

                    <!-- Job Seeker Option (Disabled) -->
                    <div class="relative opacity-50">
                        <input type="radio" 
                               id="job_seeker" 
                               name="role_type" 
                               value="job_seeker" 
                               class="sr-only peer" 
                               disabled>
                        <label for="job_seeker" 
                               class="flex flex-col items-center justify-center w-full p-6 text-gray-400 bg-gray-100 border-2 border-gray-200 rounded-lg cursor-not-allowed">
                            <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gray-200 rounded-full">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="text-lg font-semibold text-left rtl:text-left ltr:text-right">{{ __('auth.im_looking_for_job') }}</div>
                            <div class="text-sm text-left rtl:text-left ltr:text-right mt-2">{{ __('auth.i_want_find_remote_work') }}</div>
                            <div class="text-xs text-left rtl:text-left ltr:text-right mt-2 text-red-500">{{ __('auth.coming_soon') }}</div>
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('auth.continue') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout> 
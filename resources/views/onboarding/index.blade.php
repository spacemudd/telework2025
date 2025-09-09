<x-guest-layout>
    <div>
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            <strong>{{ __('auth.welcome_get_started') }}</strong>
        </h2>
        @if(__('auth.select_what_describes_you'))
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ __('auth.select_what_describes_you') }}
        </p>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('onboarding.select-role', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Company Option -->
                <div class="relative">
                    <input type="radio" 
                           id="company" 
                           name="role_type" 
                           value="company" 
                           class="sr-only peer" 
                           required>
                    <label for="company" 
                           class="flex items-center justify-center w-full h-full min-h-[120px] p-6 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-lg font-semibold text-center">{{ __('auth.i_represent_company') }}</div>
                            @if(__('auth.i_want_hire_remote_workers'))
                            <div class="text-sm text-center">{{ __('auth.i_want_hire_remote_workers') }}</div>
                            @endif
                        </div>
                    </label>
                </div>

                <!-- Job Seeker Option (Enabled) -->
                <div class="relative">
                    <input type="radio" 
                           id="job_seeker" 
                           name="role_type" 
                           value="job_seeker" 
                           class="sr-only peer" 
                           required>
                    <label for="job_seeker" 
                           class="flex items-center justify-center w-full h-full min-h-[120px] p-6 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-blue-50">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-lg font-semibold text-center">{{ __('auth.im_looking_for_job') }}</div>
                            @if(__('auth.i_want_find_remote_work'))
                            <div class="text-sm  text-center">{{ __('auth.i_want_find_remote_work') }}</div>
                            @endif
                        </div>
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
</x-guest-layout> 
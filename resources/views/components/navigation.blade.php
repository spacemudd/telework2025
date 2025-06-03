<!-- Navigation -->
<nav class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0">
                    <x-application-logo class="w-12 h-12 fill-current text-gray-500" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
                <a href="{{ \LaravelLocalization::localizeURL('/') }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    {{ __('words.home') }}
                </a>
                
            </div>

            <!-- Language Switcher -->
            <div class="hidden sm:flex sm:items-center">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <a href="/en" class="text-sm text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">English</a>
                    <span class="text-gray-300">|</span>
                    <a href="/ar" class="text-sm text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">العربية</a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden" x-show="open" @click.away="open = false">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ \LaravelLocalization::localizeURL('/') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                {{ __('words.home') }}
            </a>
            <div class="pl-3 pr-4 py-2 border-t border-gray-100">
                <div class="flex space-x-4 rtl:space-x-reverse">
                    <a href="/en" class="text-sm text-gray-600 hover:text-gray-900">English</a>
                    <span class="text-gray-300">|</span>
                    <a href="/ar" class="text-sm text-gray-600 hover:text-gray-900">العربية</a>
                </div>
            </div>
        </div>
    </div>
</nav> 
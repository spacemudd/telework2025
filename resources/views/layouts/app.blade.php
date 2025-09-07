<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('words.app_name') }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="/android-chrome-512x512.png">
        <link rel="shortcut icon" href="/favicon.ico">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Arabic:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zain:ital,wght@0,200;0,300;0,400;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
        
        <style>
            @if(app()->getLocale() === 'ar')
                body { font-family: 'IBM Plex Arabic', 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
            @else
                body { font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
            @endif
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @php use Illuminate\Support\Str; @endphp
    <body class="font-sans antialiased">
        @if(session()->has('impersonated_by'))
            <div class="bg-red-100 border border-red-300 text-red-800 text-sm px-4 py-3 flex justify-between items-center">
                <span>أنت حالياً في وضع الدخول بمستخدم آخر.</span>
                <a href="{{ route('admin.impersonate.stop') }}" class="underline font-semibold hover:text-red-600">إنهاء الدخول</a>
            </div>
        @endif
        @if(Str::contains(request()->getHost(), 'test.hadaf-hq.com'))
            <div class="bg-red-600 text-white text-sm px-4 py-3 text-center">
                بيئة تجريبية
            </div>
        @endif
        <div class="min-h-screen bg-gray-100 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-900">
                <div class="container mx-auto px-4 py-12">
                    <!-- Main Footer -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                        <!-- Hadaf Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('words.footer.company.title') }}
                            </h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.company.about') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.company.careers') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.company.contact') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Companies Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('words.footer.companies.title') }}
                            </h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.companies.post_job') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.companies.browse_candidates') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.companies.pricing') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Jobs Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('words.footer.jobs.title') }}
                            </h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.jobs.submit_cv') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ __('words.footer.jobs.search') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Social Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('words.footer.social.title') }}
                            </h3>
                            <div class="flex space-x-4 rtl:space-x-reverse">
                                <a href="https://x.com/hadaf_saudi" target="_blank" rel="noopener noreferrer" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                    <span class="sr-only">{{ __('words.footer.social.x') }}</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>
                                <a href="https://www.instagram.com/hadaf_saudi" target="_blank" rel="noopener noreferrer" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                    <span class="sr-only">{{ __('words.footer.social.instagram') }}</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Language Switcher and Legal -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <!-- Language Switcher -->
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <a href="/lang/en" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">English</a>
                                <a href="/lang/ar" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">العربية</a>
                            </div>

                            <!-- Legal Links -->
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <a href="{{ route('legal.privacy') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm">
                                    {{ __('words.footer.legal.privacy') }}
                                </a>
                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                <a href="{{ route('legal.terms') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm">
                                    {{ __('words.footer.legal.terms') }}
                                </a>
                            </div>
                        </div>

                        <!-- Copyright -->
                        <div class="text-center mt-8 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('words.footer.legal.copyright') }}
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        @stack('scripts')
    </body>
</html>

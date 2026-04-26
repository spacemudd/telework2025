<!-- Navigation -->
<nav class="bg-white border-b border-gray-100">
    <!-- Announcement Bar -->
    <div class="bg-blue-600 text-white text-sm">
        <div class="container mx-auto px-4 py-3 text-center">
            @if(app()->getLocale() === 'ar')
                <p class="text-lg font-semibold">
                    <a href="https://form.jotform.com/MajidSociety/TamkeenAttendance" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-100 underline decoration-white/80 hover:decoration-white underline-offset-2 transition-colors">✨ ندعوكم لحضور معرض توظيف ملتقى تمكين – النسخة الرابعة 2026م</a>
                </p>
            @else
                <p class="text-lg font-semibold">
                    <a href="https://form.jotform.com/MajidSociety/TamkeenAttendance" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-100 underline decoration-white/80 hover:decoration-white underline-offset-2 transition-colors">✨ You're invited to the Tamkeen Job Fair employment exhibition — fourth edition (2026).</a>
                </p>
            @endif
        </div>
    </div>
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0">
                    <img src="{{ LaravelLocalization::getCurrentLocaleDirection() === 'ltr' ? asset('img/logo_v2_on_white_en.png') : asset('img/logo_v2_on_white.png') }}" alt="Hadaf" class="h-12 w-auto" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8 rtl:space-x-reverse">
                <a href="{{ \LaravelLocalization::localizeURL('/') }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    {{ __('words.home') }}
                </a>
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    {{ __('words.nav.jobs') }}
                </a>
                <a href="{{ \LaravelLocalization::localizeURL('/for-companies') }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    {{ __('words.nav.for_companies') }}
                </a>
                @auth
                    @hasrole('admin')
                        <a href="/admin/dashboard" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    @elsehasrole('company')
                        <a href="/company/dashboard" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    @elsehasrole('employee')
                        @php
                            $employee = auth()->user()->employee;
                            $isJobSeeker = $employee && $employee->company && $employee->company->name === 'Job Seeker Platform';
                        @endphp
                        @if($isJobSeeker)
                            <a href="/employee/job-seeker-dashboard" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                        @else
                            <a href="/employee/dashboard" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                        @endif
                    @else
                        <a href="{{ route('onboarding.index', ['locale' => app()->getLocale()]) }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    @endhasrole
                        {{ __('words.dashboard') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                            {{ app()->getLocale() === 'ar' ? 'تسجيل خروج' : 'Log out' }}
                        </button>
                    </form>
                @else
                    <a href="{{ URL::localized('login') }}" class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                        {{ __('words.login') }}
                    </a>
                @endauth
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
            <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                {{ __('words.nav.jobs') }}
            </a>
            <a href="#" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                {{ __('words.nav.for_companies') }}
            </a>
            @auth
                @hasrole('admin')
                    <a href="/admin/dashboard" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                @elsehasrole('company')
                    <a href="/company/dashboard" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                @elsehasrole('employee')
                    @php
                        $employee = auth()->user()->employee;
                        $isJobSeeker = $employee && $employee->company && $employee->company->name === 'Job Seeker Platform';
                    @endphp
                    @if($isJobSeeker)
                        <a href="/employee/job-seeker-dashboard" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                    @else
                        <a href="/employee/dashboard" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                    @endif
                @else
                    <a href="{{ route('onboarding.index', ['locale' => app()->getLocale()]) }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                @endhasrole
                    {{ __('words.dashboard') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                        {{ app()->getLocale() === 'ar' ? 'تسجيل خروج' : 'Log out' }}
                    </button>
                </form>
            @else
                <a href="{{ URL::localized('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out">
                    {{ __('words.login') }}
                </a>
            @endauth
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

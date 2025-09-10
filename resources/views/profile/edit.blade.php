@extends('layouts.employee')

@section('title', 'تعديل الملف الشخصي')

@section('employee-content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة إلى لوحة التحكم
                </a>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm transition-opacity duration-300" role="alert" data-auto-dismiss="4000">
                    <div class="flex items-start">
                        <div class="py-1 mr-4 rtl:ml-4 rtl:mr-0 flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold">نجاح</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                <!-- Profile Information -->
                <div class="bg-white shadow rounded-2xl p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Change Password -->
                <div class="bg-white shadow rounded-2xl p-6">
                    @include('profile.partials.update-password-form')
                </div>

            </div>
        </div>
    </div>

    <script>
    // Auto-dismiss flash alerts
    document.querySelectorAll('[data-auto-dismiss]').forEach(function(el) {
        var timeoutMs = parseInt(el.getAttribute('data-auto-dismiss'), 10) || 4000;
        setTimeout(function() {
            el.classList.add('opacity-0');
            setTimeout(function() { el.remove(); }, 300);
        }, timeoutMs);
    });
    </script>
@endsection

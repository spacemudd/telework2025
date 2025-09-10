@props(['currentStep' => 1])

<div class="flex justify-center mb-8">
    <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
        <!-- Step 1: Personal Info -->
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= 1 ? ($currentStep > 1 ? 'bg-green-500 text-white' : 'bg-blue-500 text-white') : 'bg-gray-300 text-gray-600' }}">
                @if($currentStep > 1)
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    1
                @endif
            </div>
            <span class="ml-3 text-sm font-medium {{ $currentStep >= 1 ? 'text-gray-900' : 'text-gray-500' }} {{ app()->getLocale() === 'ar' ? 'mr-3 ml-0' : '' }}">
                {{ __('auth.personal_info') }}
            </span>
        </div>

        <!-- Connector -->
        <div class="flex-1 h-0.5 {{ $currentStep > 1 ? 'bg-green-500' : 'bg-gray-300' }} mx-4"></div>

        <!-- Step 2: Experience -->
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= 2 ? ($currentStep > 2 ? 'bg-green-500 text-white' : 'bg-blue-500 text-white') : 'bg-gray-300 text-gray-600' }}">
                @if($currentStep > 2)
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    2
                @endif
            </div>
            <span class="ml-3 text-sm font-medium {{ $currentStep >= 2 ? 'text-gray-900' : 'text-gray-500' }} {{ app()->getLocale() === 'ar' ? 'mr-3 ml-0' : '' }}">
                {{ __('auth.experience') }}
            </span>
        </div>

        <!-- Connector -->
        <div class="flex-1 h-0.5 {{ $currentStep > 2 ? 'bg-green-500' : 'bg-gray-300' }} mx-4"></div>

        <!-- Step 3: Education -->
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= 3 ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                @if($currentStep > 3)
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    3
                @endif
            </div>
            <span class="ml-3 text-sm font-medium {{ $currentStep >= 3 ? 'text-gray-900' : 'text-gray-500' }} {{ app()->getLocale() === 'ar' ? 'mr-3 ml-0' : '' }}">
                {{ __('auth.education') }}
            </span>
        </div>
    </div>
</div>

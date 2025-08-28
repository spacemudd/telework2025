@switch($icon)
    @case('code')
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" />
            <path d="M8 9l-2 3 2 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 9l2 3-2 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case('design')
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor"/>
            <path d="M8 8l8 8M16 8l-8 8" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case('chart')
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <rect x="3" y="13" width="4" height="8" rx="1" stroke="currentColor"/>
            <rect x="10" y="9" width="4" height="12" rx="1" stroke="currentColor"/>
            <rect x="17" y="5" width="4" height="16" rx="1" stroke="currentColor"/>
        </svg>
        @break
    @case('project')
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="8" stroke="currentColor"/>
            <path d="M12 8v4l3 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case('product')
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @case('marketing')
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M13 13l6 6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @break
    @default
        <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor"/>
            <path d="M12 16v-4M12 8h.01" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
@endswitch

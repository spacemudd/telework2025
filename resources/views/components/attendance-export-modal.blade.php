@props(['company'])

@if(!$company)
    @php
        // If no company is provided, don't render the modal
        return;
    @endphp
@endif

@php
    $now = \Carbon\Carbon::now();
    $companyCreatedAt = \Carbon\Carbon::parse($company->created_at);
    $currentMonth = $now->month;
    $currentYear = $now->year;
    $isBeforeToday20th = $now->day < 20;
    
    $months = [];
    $tempDate = $companyCreatedAt->copy()->startOfMonth();
    
    while ($tempDate->lte($now->copy()->startOfMonth())) {
        $isCurrentMonth = $tempDate->year == $currentYear && $tempDate->month == $currentMonth;
        $disabled = $isCurrentMonth && $isBeforeToday20th;
        
        $months[] = [
            'value' => $tempDate->format('Y-m'),
            'label' => __('words.' . strtolower($tempDate->format('F'))) . ' ' . $tempDate->year,
            'disabled' => $disabled,
            'isCurrentMonth' => $isCurrentMonth
        ];
        
        $tempDate->addMonth();
    }
    
    $months = array_reverse($months); // Show most recent first
@endphp

<!-- Attendance Export Modal -->
<div id="attendanceExportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">{{ __('words.attendance_export') }}</h3>
                <button onclick="closeAttendanceExportModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="attendanceExportForm" method="GET" action="{{ route('company.attendance.export') }}">
                <!-- Month Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">{{ __('words.select_month_to_export') }}:</label>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($months as $month)
                            <label class="flex items-center {{ $month['disabled'] ? 'opacity-50' : '' }}">
                                <input type="radio" 
                                       name="month" 
                                       value="{{ $month['value'] }}" 
                                       {{ $month['disabled'] ? 'disabled' : '' }}
                                       class="mx-3"
                                       {{ !$month['disabled'] && $loop->first ? 'checked' : '' }}>
                                <span class="text-sm flex-1">{{ $month['label'] }}</span>
                                @if($month['disabled'])
                                    <span class="text-xs text-gray-500">({{ __('words.enabled_on_20th') }})</span>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    @if($isBeforeToday20th)
                        <p class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-info-circle"></i>
                            {{ __('words.current_month_restriction') }}
                        </p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeAttendanceExportModal()" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm">
                        {{ __('words.close') }}
                    </button>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                        {{ __('words.download_report') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAttendanceExportModal() {
    document.getElementById('attendanceExportModal').classList.remove('hidden');
}

function closeAttendanceExportModal() {
    document.getElementById('attendanceExportModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('attendanceExportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAttendanceExportModal();
    }
});
</script>
@endif 
<!-- Task Download Modal -->
<div id="taskDownloadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">تحميل تقرير المهام</h3>
                <button onclick="closeTaskDownloadModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="taskDownloadForm" method="GET" action="{{ route('company.tasks.export') }}">
                <!-- Task Status Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">نوع المهام المراد تحميلها:</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="statuses[]" value="pending" checked class="mx-3">
                            <span class="text-sm">{{ __('words.pending') }}</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="statuses[]" value="in_progress" checked class="mx-3">
                            <span class="text-sm">{{ __('words.in_progress') }}</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="statuses[]" value="completed" checked class="mx-3">
                            <span class="text-sm">{{ __('words.completed') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Date Range Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">فترة إنشاء المهام (اختياري):</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">من تاريخ</label>
                            <input type="date" name="date_from" class="w-full border rounded p-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">إلى تاريخ</label>
                            <input type="date" name="date_to" class="w-full border rounded p-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Format Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">تنسيق التقرير:</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="format" value="excel" checked class="mx-3">
                            <span class="text-sm">Excel</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="format" value="csv" class="mx-3">
                            <span class="text-sm">CSV</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-2 space-x-reverse">
                    <button type="button" onclick="closeTaskDownloadModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        إلغاء
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        تحميل التقرير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTaskDownloadModal() {
    document.getElementById('taskDownloadModal').classList.remove('hidden');
}

function closeTaskDownloadModal() {
    document.getElementById('taskDownloadModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('taskDownloadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTaskDownloadModal();
    }
});
</script> 
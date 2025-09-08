@extends('layouts.employee')

@section('title', 'إضافة خبرة جديدة')

@section('employee-content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">إضافة خبرة جديدة</h1>

        <form action="{{ route('employee.experiences.store', ['locale' => app()->getLocale()]) }}" method="POST" class="bg-white border border-gray-200 rounded-lg p-6">
            @csrf
            
            <div class="mb-4">
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">اسم الشركة</label>
                <input type="text" name="company_name" id="company_name" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       value="{{ old('company_name') }}" required>
                @error('company_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">المسمى الوظيفي</label>
                <input type="text" name="job_title" id="job_title" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       value="{{ old('job_title') }}" required>
                @error('job_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ البداية</label>
                <input type="date" name="start_date" id="start_date" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       value="{{ old('start_date') }}" required>
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_current" id="is_current" value="1" 
                           class="mr-2" {{ old('is_current') ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">أعمل حالياً في هذه الوظيفة</span>
                </label>
            </div>

            <div class="mb-4" id="end_date_container">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ النهاية</label>
                <input type="date" name="end_date" id="end_date" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       value="{{ old('end_date') }}">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف (اختياري)</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    إضافة الخبرة
                </button>
                <a href="{{ route('employee.experiences.index', ['locale' => app()->getLocale()]) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('is_current').addEventListener('change', function() {
    const endDateContainer = document.getElementById('end_date_container');
    const endDateInput = document.getElementById('end_date');
    
    if (this.checked) {
        endDateContainer.style.display = 'none';
        endDateInput.value = '';
    } else {
        endDateContainer.style.display = 'block';
    }
});

// Initialize on page load
if (document.getElementById('is_current').checked) {
    document.getElementById('end_date_container').style.display = 'none';
}
</script>
@endsection

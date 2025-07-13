@extends('layouts.admin')

@section('title', 'إعدادات المحاكاة للشركة')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <div class="col-span-12">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-xl font-semibold mb-4">إعدادات المحاكاة لشركة: {{ $company->name }}</h1>

                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                        <div class="text-red-600 font-semibold mb-2">خطأ في الإعدادات:</div>
                        <ul class="text-red-600 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.companies.simulation-config.update', $company->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="tasks_per_day" class="block mb-1 text-sm font-medium text-gray-700">عدد الأقصى المهام لكل موظف يومياً</label>
                        <input type="number" name="tasks_per_day" id="tasks_per_day" min="1"
                               value="{{ old('tasks_per_day', $config->tasks_per_day) }}"
                               class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="auto_complete" id="auto_complete" value="1"
                               {{ old('auto_complete', $config->auto_complete) ? 'checked' : '' }}>
                        <label for="auto_complete" class="text-sm">تمكين الاستجابة التلقائية من الموظف</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_enabled" id="is_enabled" value="1"
                               {{ old('is_enabled', $config->is_enabled) ? 'checked' : '' }}>
                        <label for="is_enabled" class="text-sm">تفعيل المحاكاة لهذه الشركة</label>
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <h3 class="text-lg font-medium mb-4">إعدادات معدلات الاستجابة</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="completion_rate" class="block mb-1 text-sm font-medium text-gray-700">
                                    معدل إكمال المهام (%)
                                </label>
                                <input type="number" name="completion_rate" id="completion_rate" 
                                       min="0" max="100" value="{{ old('completion_rate', $config->completion_rate ?? 70) }}"
                                       class="w-full border-gray-300 rounded shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">احتمالية إكمال المهام عند الاستجابة</p>
                            </div>

                            <div>
                                <label for="in_progress_rate" class="block mb-1 text-sm font-medium text-gray-700">
                                    معدل المهام قيد التنفيذ (%)
                                </label>
                                <input type="number" name="in_progress_rate" id="in_progress_rate" 
                                       min="0" max="100" value="{{ old('in_progress_rate', $config->in_progress_rate ?? 20) }}"
                                       class="w-full border-gray-300 rounded shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">احتمالية تحديث المهام إلى "قيد التنفيذ"</p>
                            </div>

                            <div>
                                <label for="comment_only_rate" class="block mb-1 text-sm font-medium text-gray-700">
                                    معدل التعليقات فقط (%)
                                </label>
                                <input type="number" name="comment_only_rate" id="comment_only_rate" 
                                       min="0" max="100" value="{{ old('comment_only_rate', $config->comment_only_rate ?? 10) }}"
                                       class="w-full border-gray-300 rounded shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">احتمالية إضافة تعليق دون تغيير حالة المهمة</p>
                            </div>
                        </div>

                        <div class="p-4 bg-blue-50 rounded-lg mt-4">
                            <p class="text-sm text-blue-800">
                                <strong>ملاحظة:</strong> المتبقي من النسبة المئوية سيكون للمهام التي لن يتم الرد عليها في هذه الجولة.
                                <br>
                                <span class="text-xs">مثال: إذا كان الإكمال 70% والتقدم 20% والتعليقات 10%، فإن 0% من المهام ستبقى بدون رد.</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            حفظ الإعدادات
                        </button>

                    </div>
                </form>
                <form x-data="{ loading: false }" @submit="loading = true" class="mt-2" action="{{ route('admin.companies.simulation-config.run', $company->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            :disabled="loading"
                            :class="{ 'opacity-50 cursor-not-allowed': loading }"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition flex items-center gap-2">
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span x-text="loading ? 'جارٍ التنفيذ...' : 'تنفيذ المحاكاة الآن'"></span>
                    </button>
                </form>
                <form x-data="{ loading: false }" @submit="loading = true" class="mt-2" action="{{ route('admin.companies.simulation-config.respond', $company->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            :disabled="loading"
                            :class="{ 'opacity-50 cursor-not-allowed': loading }"
                            class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition flex items-center gap-2">
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span x-text="loading ? 'جارٍ الرد...' : 'تنفيذ رد الموظفين الآن'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

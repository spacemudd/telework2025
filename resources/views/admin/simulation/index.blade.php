
@extends('layouts.admin')

@section('title', 'إعدادات المحاكاة')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <div class="col-span-12">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-xl font-semibold mb-4">إعدادات المحاكاة</h1>

                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.simulation.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="tasks_per_day" class="block mb-1 text-sm font-medium text-gray-700">عدد المهام لكل موظف يومياً</label>
                        <input type="number" name="tasks_per_day" id="tasks_per_day" min="1"
                               value="{{ old('tasks_per_day', $config->tasks_per_day) }}"
                               class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="auto_complete" id="auto_complete" value="1"
                               {{ old('auto_complete', $config->auto_complete) ? 'checked' : '' }}>
                        <label for="auto_complete" class="text-sm">تمكين استجابة تلقائية من الموظف</label>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            حفظ الإعدادات
                        </button>

                        <a href="{{ route('admin.simulation.run') }}"
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            تشغيل المحاكاة الآن
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

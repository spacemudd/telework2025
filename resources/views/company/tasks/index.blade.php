@extends('layouts.company')

@section('title', 'إدارة المهام')

@section('company-content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">إدارة المهام</h2>
        <div class="flex gap-2">
            <button onclick="document.getElementById('exportForm').submit()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                تصدير CSV
            </button>
            <a href="{{ route('company.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm">
                العودة للوحة التحكم
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">تصفية المهام</h3>
        <form method="GET" action="{{ route('company.tasks.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">الموظف</label>
                <select name="employee_id" class="w-full border rounded p-2 text-sm">
                    <option value="">جميع الموظفين</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">الحالة</label>
                <select name="status" class="w-full border rounded p-2 text-sm">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('words.pending') }}</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('words.in_progress') }}</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('words.completed') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">الأولوية</label>
                <select name="priority" class="w-full border rounded p-2 text-sm">
                    <option value="">جميع الأولويات</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>{{ __('words.low') }}</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>{{ __('words.medium') }}</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>{{ __('words.high') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">من تاريخ</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border rounded p-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">إلى تاريخ</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border rounded p-2 text-sm">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    تصفية
                </button>
                <a href="{{ route('company.tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold">المهام ({{ $tasks->total() }})</h3>
        </div>

        @if($tasks->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">الموظف</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">المهمة</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">الأولوية</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">الحالة</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">تاريخ الاستحقاق</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">التعليقات</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($tasks as $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 text-sm">
                                    <div class="font-medium">{{ $task->employee->name }}</div>
                                    <div class="text-gray-500">{{ $task->employee->position }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <div class="font-medium">{{ $task->title }}</div>
                                    <div class="text-gray-500 mt-1">{{ Str::limit($task->description, 100) }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $task->priority == 'high' ? 'bg-red-100 text-red-800' : 
                                           ($task->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ __('words.' . $task->priority) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $task->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($task->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ __('words.' . $task->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    @if($task->comments->count() > 0)
                                        <div class="space-y-2 max-h-32 overflow-y-auto">
                                            @foreach($task->comments as $comment)
                                                <div class="bg-gray-50 p-2 rounded text-xs">
                                                    <div class="font-medium">{{ $comment->user->name }}</div>
                                                    <div class="text-gray-600">{{ $comment->comment }}</div>
                                                    <div class="text-gray-400 mt-1">{{ $comment->created_at->format('Y-m-d H:i') }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">لا توجد تعليقات</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $task->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t">
                {{ $tasks->withQueryString()->links() }}
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <p>لا توجد مهام تطابق معايير البحث</p>
            </div>
        @endif
    </div>

    <!-- Hidden Export Form -->
    <form id="exportForm" method="GET" action="{{ route('company.tasks.export') }}" style="display: none;">
        <input type="hidden" name="employee_id" value="{{ request('employee_id') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="hidden" name="priority" value="{{ request('priority') }}">
        <input type="hidden" name="date_from" value="{{ request('date_from') }}">
        <input type="hidden" name="date_to" value="{{ request('date_to') }}">
    </form>
</div>
@endsection 
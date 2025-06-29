@extends('layouts.admin')

@section('title', __('words.employee_details'))

@section('admin-content')
    <div class="p-6 max-w-4xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">{{ __('words.employee_details') }}</h2>
            <a href="{{ route('admin.companies.employees.edit', [$company->id, $employee->id]) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ __('words.edit_employee') }}
            </a>
        </div>

        <div class="mb-6 p-4 bg-white rounded shadow">
            <p><strong>{{ __('words.name') }}:</strong> {{ $employee->name }}</p>
            <p><strong>{{ __('words.email') }}:</strong> {{ $employee->email }}</p>
            <p><strong>{{ __('words.identity_number') }}:</strong> {{ $employee->identity_number }}</p>
            <p><strong>{{ __('words.phone') }}:</strong> {{ $employee->phone }}</p>
            <p><strong>{{ __('words.position') }}:</strong> {{ $employee->position }}</p>
            <p><strong>{{ __('words.company') }}:</strong>
                @if($employee->company)
                    <a href="{{ route('admin.companies.show', $employee->company->id) }}" class="text-blue-600 hover:underline">
                        {{ $employee->company->name }}
                    </a>
                @else
                    -
                @endif
            </p>
        </div>

        @if ($employee->tasks->count())
            <h2 class="text-xl font-bold mb-4">{{ __('words.assigned_tasks') }}</h2>

            <div class="overflow-x-auto mb-8">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">{{ __('words.task_title') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('words.due_date') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('words.priority') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('words.status') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('words.created_at') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('words.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employee->tasks as $task)
                            <tr class="border-t">
                                <td class="py-3 px-4">{{ $task->title }}</td>
                                <td class="py-3 px-4">{{ $task->due_date }}</td>
                                <td class="py-3 px-4">{{ __('words.' . $task->priority) }}</td>
                                <td class="py-3 px-4">{{ __('words.' . $task->status) }}</td>
                                <td class="py-3 px-4" title="{{ $task->created_at }}">{{ $task->created_at->diffForHumans() }}</td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه المهمة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">
                                            {{ __('words.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <h2 class="text-xl font-bold mb-4">{{ __('words.assign_new_task') }}</h2>

        <form action="{{ route('admin.employees.assignTask', [$company->id, $employee->id]) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-2">{{ __('words.task_title') }}</label>
                <input type="text" name="title" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">{{ __('words.task_description') }}</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">{{ __('words.due_date') }}</label>
                <input type="date" name="due_date" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">{{ __('words.priority') }}</label>
                <select name="priority" class="w-full border rounded p-2" required>
                    <option value="low">{{ __('words.low') }}</option>
                    <option value="medium">{{ __('words.medium') }}</option>
                    <option value="high">{{ __('words.high') }}</option>
                </select>
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ __('words.assign_task') }}
            </button>
        </form>

    </div>
@endsection

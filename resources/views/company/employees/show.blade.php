@extends('layouts.company')

@section('title', __('words.employee_details'))

@section('company-content')
<div class="p-6 max-w-4xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">{{ __('words.employee_details') }}</h2>

    <div class="mb-6 p-4 bg-white rounded shadow">
        <p><strong>{{ __('words.name') }}:</strong> {{ $employee->name }}</p>
        <p><strong>{{ __('words.email') }}:</strong> {{ $employee->email }}</p>
        <p><strong>{{ __('words.identity_number') }}:</strong> {{ $employee->identity_number }}</p>
        <p><strong>{{ __('words.phone') }}:</strong> {{ $employee->phone }}</p>
        <p><strong>{{ __('words.position') }}:</strong> {{ $employee->position }}</p>
    </div>

    <h2 class="text-xl font-bold mb-4">{{ __('words.assigned_tasks') }}</h2>

    @if($employee->tasks->count())
    <div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-right">{{ __('words.task_title') }}</th>
                        <th class="py-3 px-4 text-right">{{ __('words.due_date') }}</th>
                        <th class="py-3 px-4 text-right">{{ __('words.priority') }}</th>
                        <th class="py-3 px-4 text-right">{{ __('words.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee->tasks as $task)
                        <tr class="border-t">
                            <td class="py-3 px-4">
                                <p class="font-semibold">{{ $task->title }}</p>
                                <ul class="text-xs text-gray-600 mt-1 space-y-1">
                                    @foreach ($task->activities as $activity)
                                        @if(isset($activity->properties['attributes']['status']))
                                            <li>
                                                {{ $activity->created_at->format('Y-m-d H:i') }} -
                                                {{ __('words.status') }}:
                                                {{ __('words.' . $activity->properties['attributes']['status']) }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 px-4">{{ $task->due_date }}</td>
                            <td class="py-3 px-4">{{ __('words.' . $task->priority) }}</td>
                            <td class="py-3 px-4">{{ __('words.' . $task->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <p class="text-gray-500">{{ __('words.no_tasks_assigned') }}</p>
    @endif

    <h2 class="text-xl font-bold mt-8 mb-4">{{ __('words.assign_new_task') }}</h2>

    <form action="{{ route('company.employees.assignTask', $employee->id) }}" method="POST" class="bg-white p-6 rounded shadow">
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

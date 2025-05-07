@extends('layouts.employee')

@section('title', __('words.dashboard'))

@section('employee-content')
    <div class="container mx-auto">
        <div class="p-6 max-w-7xl mx-auto">

            <h1 class="text-2xl font-bold mb-6">{{ __('words.welcome') }} {{ auth()->user()->name }}</h1>

            @if(auth()->user()->employee && auth()->user()->employee->company)
                <div class="mb-6 bg-white rounded-lg shadow p-4">
                    <h2 class="text-md font-semibold mb-2 text-gray-700">{{ __('words.company_details') }}</h2>
                    <p class="text-sm text-gray-600"><strong>{{ __('words.name') }}:</strong> {{ auth()->user()->employee->company->name }}</p>
                    <p class="text-sm text-gray-600"><strong>{{ __('words.email') }}:</strong> {{ auth()->user()->employee->company->email }}</p>
                </div>
            @endif

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">{{ __('words.assigned_tasks') }}</h2>
                <div x-data="{
                        active: false,
                        interval: null,
                        startPing() {
                            this.interval = setInterval(() => {
                                fetch('{{ route('employee.tracker.ping') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({})
                                }).then(response => {
                                    if (!response.ok) {
                                        this.active = false;
                                        localStorage.setItem('tracker_active', 'false');
                                        clearInterval(this.interval);
                                    }
                                });
                            }, 600000);
                        },
                        stopPing() {
                            clearInterval(this.interval);
                        }
                    }"
                    x-init="
                        if (localStorage.getItem('tracker_active') === 'true') {
                            active = true;
                            startPing();
                        }
                    "
                >
                    <button
                        :class="active ? 'bg-red-600' : 'bg-green-600'"
                        class="px-4 py-2 text-white rounded shadow hover:opacity-90 transition-all"
                        @click="
                            active = !active;
                            localStorage.setItem('tracker_active', active);
                            if (active) {
                                startPing();
                            } else {
                                stopPing();
                                fetch('{{ route('employee.tracker.stop') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({})
                                });
                            }
                        "
                    >
                        <span x-text="active ? 'إيقاف العمل' : 'بدء العمل'"></span>
                    </button>
                </div>
            </div>

            @if ($tasks->count())
                @php
                    $grouped = $tasks->groupBy('status');
                    $statuses = ['pending' => 'قيد الانتظار', 'in_progress' => 'قيد التنفيذ', 'completed' => 'مكتملة'];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($statuses as $key => $label)
                        <div class="bg-gray-100 rounded-lg p-4">
                            <h3 class="text-lg font-bold mb-4 text-center text-gray-700">{{ $label }}</h3>
                            <div class="space-y-4">
                                @forelse ($grouped[$key] ?? [] as $task)
                                    <div class="bg-white rounded-lg shadow p-4">
                                        <h4 class="text-md font-semibold mb-2">{{ $task->title }}</h4>
                                        <p class="text-sm text-gray-600 mb-1"><strong>{{ __('words.due_date') }}:</strong> {{ $task->due_date }}</p>
                                        <p class="text-sm text-gray-600 mb-1"><strong>{{ __('words.priority') }}:</strong> {{ __('words.' . $task->priority) }}</p>
                                        @if ($task->status !== 'completed')
                                            <form action="{{ route('employee.tasks.updateStatus', $task->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex flex-col gap-2">
                                                    <select name="status" class="text-sm border rounded p-1 w-full">
                                                        <option value="pending" @selected($task->status === 'pending')>{{ __('words.pending') }}</option>
                                                        <option value="in_progress" @selected($task->status === 'in_progress')>{{ __('words.in_progress') }}</option>
                                                        <option value="completed" @selected($task->status === 'completed')>{{ __('words.completed') }}</option>
                                                    </select>
                                                    <textarea name="comment" rows="2" placeholder="اكتب تعليقاً حول التحديث..." class="text-sm border rounded p-2 w-full"></textarea>
                                                    <button type="submit" class="self-end text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                                        {{ __('words.update') }}
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                        @if ($task->audit_logs && $task->audit_logs->count())
                                            <div class="mt-4 border-t pt-2">
                                                <h5 class="text-sm font-semibold mb-1 text-gray-600">سجل التعديلات:</h5>
                                                <ul class="text-xs text-gray-500 list-disc pl-4">
                                                    @foreach ($task->audit_logs as $log)
                                                        <li>
                                                            {{ $log->status }} - {{ $log->created_at->format('Y-m-d H:i') }}
                                                            @if(!empty($log->comment))
                                                                <br><span class="text-gray-700">تعليق: {{ $log->comment }}</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if ($task->comments && $task->comments->count())
                                            <div class="mt-4 border-t pt-2">
                                                <h5 class="text-sm font-semibold mb-1 text-gray-600">المناقشات:</h5>
                                                <ul class="text-xs text-gray-700 space-y-2">
                                                    @foreach ($task->comments as $comment)
                                                        <li class="border p-2 rounded bg-gray-50">
                                                            <span class="font-semibold">{{ $comment->user->name }}</span>:
                                                            <span>{{ $comment->comment }}</span>
                                                            <br>
                                                            <span class="text-gray-400">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 text-center">لا توجد مهام</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">{{ __('words.no_tasks_assigned') }}</p>
            @endif

        </div>
    </div>
@endsection

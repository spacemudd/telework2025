@extends('layouts.admin')

@section('title', __('words.company_details'))

@section('admin-content')
<div class="p-6 max-w-4xl mx-auto">
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold"><span class="border border-orange-600 border-1 p-1">{{ $company->code }}</span> - {{ $company->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.companies.edit', $company->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm text-white hover:bg-blue-700 focus:outline-none transition">
                    {{ __('words.edit') }}
                </a>
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-200 focus:outline-none transition">
                            {{ __('words.actions') }}
                            <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('admin.companies.sync', $company->id) }}">
                            {{ __('words.sync') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('admin.companies.email', $company->id) }}">
                            {{ __('words.send_email') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('admin.companies.audit', $company->id) }}">
                            {{ __('words.communication-log') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('admin.companies.simulation-config.index', $company->id) }}">
                            {{ __('words.simulation-config') }}
                        </x-dropdown-link>
                        @if ($company->owner)
                            <x-dropdown-link href="{{ route('admin.impersonate', $company->owner->id) }}">
                                {{ __('words.login') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <tbody>
                    <tr class="border-b">
                        <th class="text-left py-2 px-4 font-semibold">{{ __('words.email') }}</th>
                        <td class="py-2 px-4">{{ $company->email }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 px-4 font-semibold">{{ __('words.address') }}</th>
                        <td class="py-2 px-4">{{ $company->address }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 px-4 font-semibold">{{ __('words.cr_number') }}</th>
                        <td class="py-2 px-4">{{ $company->cr_number }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 px-4 font-semibold">{{ __('words.created_at') }}</th>
                        <td class="py-2 px-4">{{ $company->created_at->format('Y-m-d') }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 px-4 font-semibold">AI Calls - YTD</th>
                        <td class="px-4 py-2">
                            <span class="font-semibold text-blue-600">${{ number_format($company->getYtdAiCosts(), 2) }}</span>
                            <span class="text-sm text-gray-500 ml-2">({{ $company->apiCalls()->whereYear('created_at', date('Y'))->count() }} calls)</span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 px-4 font-semibold">AI Calls - MTD</th>
                        <td class="px-4 py-2">
                            <span class="font-semibold text-green-600">${{ number_format($company->getMtdAiCosts(), 2) }}</span>
                            <span class="text-sm text-gray-500 ml-2">({{ $company->apiCalls()->whereYear('created_at', date('Y'))->whereMonth('created_at', date('n'))->count() }} calls)</span>
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th class="text-left py-2 px-4 font-semibold">{{ __('words.phone') }}</th>--}}
{{--                        <td class="py-2 px-4">{{ $company->phone }}</td>--}}
{{--                    </tr>--}}
                </tbody>
            </table>
        </div>

        <!-- Task Statistics and Graph -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">{{ __('words.tasks_statistics') }}</h2>
            <div class="flex flex-col md:flex-row md:items-end gap-4 mb-4">
                <div>
                    <label for="tasks-timeframe" class="block text-sm font-medium text-gray-700 mb-1">{{ __('words.timeframe') }}</label>
                    <select id="tasks-timeframe" class="border rounded p-2">
                        <option value="this_month">{{ __('words.this_month') }}</option>
                        <option value="last_month">{{ __('words.last_month') }}</option>
                        <option value="custom">{{ __('words.custom') }}</option>
                    </select>
                </div>
                <div id="custom-dates" class="hidden flex gap-2 items-end">
                    <div>
                        <label for="date-from" class="block text-xs">{{ __('words.from') }}</label>
                        <input type="date" id="date-from" class="border rounded p-2">
                    </div>
                    <div>
                        <label for="date-to" class="block text-xs">{{ __('words.to') }}</label>
                        <input type="date" id="date-to" class="border rounded p-2">
                    </div>
                    <button id="apply-custom-dates" class="bg-blue-600 text-white px-3 py-1 rounded">{{ __('words.apply') }}</button>
                </div>
            </div>
            <div class="mb-4">
                <span class="font-semibold">{{ __('words.total_tasks') }}:</span>
                <span id="total-tasks" class="text-blue-700 font-bold">...</span>
            </div>
            <div class="bg-white rounded shadow p-4">
                <canvas id="tasks-graph" style="height: 350px;"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const companyId = @json($company->id);
            let tasksChart;
            let currentFrom, currentTo;
            function fetchTasksStats(dateFrom, dateTo) {
                let url = `/admin/companies/${companyId}/tasks-stats?date_from=${dateFrom}&date_to=${dateTo}`;
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('total-tasks').textContent = data.totalTasks;
                        if (tasksChart) tasksChart.destroy();
                        const ctx = document.getElementById('tasks-graph').getContext('2d');
                        tasksChart = new Chart(ctx, {
                            type: 'bar',
                            data: data.chartData,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                                    x: { title: { display: true, text: '{{ __('words.dates') }}' } }
                                },
                                plugins: {
                                    legend: { display: true, position: 'top' },
                                    title: { display: true, text: '{{ __('words.tasks_generated') }}' }
                                }
                            }
                        });
                    });
            }
            function setTimeframe(timeframe) {
                const now = new Date();
                let from, to;
                if (timeframe === 'this_month') {
                    from = new Date(now.getFullYear(), now.getMonth(), 1);
                    to = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                } else if (timeframe === 'last_month') {
                    from = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    to = new Date(now.getFullYear(), now.getMonth(), 0);
                } else {
                    document.getElementById('custom-dates').classList.remove('hidden');
                    return;
                }
                document.getElementById('custom-dates').classList.add('hidden');
                currentFrom = from.toISOString().slice(0,10);
                currentTo = to.toISOString().slice(0,10);
                fetchTasksStats(currentFrom, currentTo);
            }
            document.getElementById('tasks-timeframe').addEventListener('change', function() {
                setTimeframe(this.value);
            });
            document.getElementById('apply-custom-dates').addEventListener('click', function() {
                const from = document.getElementById('date-from').value;
                const to = document.getElementById('date-to').value;
                if (from && to) {
                    currentFrom = from;
                    currentTo = to;
                    fetchTasksStats(from, to);
                }
            });
            // Initial load
            setTimeframe('this_month');
        </script>
        <!-- End Task Statistics and Graph -->

        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">{{ __('words.employees') }} ({{ $company->employees()->count() }})</h2>

            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.companies.employees.create', ['company' => $company->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    {{ __('words.add_employee') }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm bg-white rounded-lg shadow">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-left py-2 px-4 rtl:text-right">{{ __('words.name') }}</th>
                            <th class="text-left py-2 px-4 rtl:text-right">{{ __('words.email') }}</th>
                            <th class="text-left py-2 px-4 rtl:text-right">{{ __('words.phone') }}</th>
                            <th class="text-left py-2 px-4 rtl:text-right">{{ __('words.position') }}</th>
                            <th class="text-left py-2 px-4 rtl:text-right">{{ __('words.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($company->employees as $employee)
                            <tr class="border-b">
                                <td class="py-2 px-4">
                                    <a href="{{ route('admin.companies.employees.show', ['company' => $company, 'employee' => $employee->id]) }}">{{ $employee->name }}</a>
                                    <div class="text-gray-400 text-xs mt-1">{{ $employee->created_at->format('Y-m-d') }}</div>
                                </td>
                                <td class="py-2 px-4">{{ $employee->email }}</td>
                                <td class="py-2 px-4">{{ $employee->phone }}</td>
                                <td class="py-2 px-4">{{ $employee->position }}</td>
                                <td class="py-2 px-4">
                                    <form method="POST" action="{{ route('admin.employees.disable', ['company' => $company->id, 'employee' => $employee->id]) }}">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:underline text-xs">
                                            {{ __('words.disable') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">{{ __('words.no_employees_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.companies.index') }}" class="text-blue-600 hover:underline text-sm">
                &larr; {{ __('words.back') }}
            </a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'إعدادات المحاكاة للشركات')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <div class="col-span-12">
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl font-semibold">إعدادات المحاكاة للشركات</h1>
                    <a href="{{ route('admin.simulation.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        الإعدادات العامة
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Month Filter -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('admin.simulation.companies') }}" class="flex items-center gap-4">
                        <label for="month" class="text-sm font-medium text-gray-700">اختر الشهر:</label>
                        <select name="month" id="month" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($monthOptions as $value => $label)
                                <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                            تطبيق
                        </button>
                    </form>
                </div>

                <!-- Summary Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_companies'] }}</div>
                        <div class="text-sm text-blue-800">إجمالي الشركات</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['enabled_companies'] }}</div>
                        <div class="text-sm text-green-800">الشركات المفعلة</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['disabled_companies'] }}</div>
                        <div class="text-sm text-red-800">الشركات المعطلة</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['companies_without_config'] }}</div>
                        <div class="text-sm text-yellow-800">بدون إعدادات</div>
                    </div>
                </div>

                <!-- Additional Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['total_employees'] }}</div>
                        <div class="text-sm text-purple-800">إجمالي الموظفين</div>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-indigo-600">{{ number_format($stats['avg_tasks_per_day'], 1) }}</div>
                        <div class="text-sm text-indigo-800">متوسط المهام/يوم</div>
                    </div>
                    <div class="bg-teal-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-teal-600">{{ number_format($stats['avg_completion_rate'], 1) }}%</div>
                        <div class="text-sm text-teal-800">متوسط معدل الإكمال</div>
                    </div>
                </div>

                <!-- Companies with Missing Days Summary -->
                @php
                    $companiesWithMissingDays = $companies->filter(function($company) {
                        return isset($company->task_creation_data) && $company->task_creation_data['days_without_tasks'] > 0;
                    });
                @endphp
                @if($companiesWithMissingDays->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4 text-orange-700">الشركات مع أيام بدون مهام</h2>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($companiesWithMissingDays as $company)
                            <div class="bg-white p-4 rounded border border-orange-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $company->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $company->email }}</p>
                                        <p class="text-xs text-orange-600 font-medium">
                                            {{ $company->task_creation_data['days_without_tasks'] }} يوم بدون مهام
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            إجمالي المهام: {{ $company->task_creation_data['total_tasks'] }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.companies.simulation-config.index', $company->id) }}" 
                                           class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                            إعدادات
                                        </a>
                                        <a href="{{ route('admin.companies.show', $company->id) }}" 
                                           class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700 transition">
                                            عرض
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Comprehensive Missing Days Summary -->
                @php
                    $companiesWithComprehensiveMissingDays = $companies->filter(function($company) {
                        $missingData = $company->getMissingDaysSinceFirstEmployee();
                        return $missingData['total_missing_days'] > 0;
                    });
                @endphp
                @if($companiesWithComprehensiveMissingDays->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4 text-red-700">الشركات مع أيام مفقودة منذ إضافة أول موظف</h2>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($companiesWithComprehensiveMissingDays as $company)
                            @php
                                $missingData = $company->getMissingDaysSinceFirstEmployee();
                            @endphp
                            <div class="bg-white p-4 rounded border border-red-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $company->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $company->email }}</p>
                                        <p class="text-xs text-red-600 font-medium">
                                            {{ $missingData['total_missing_days'] }} يوم مفقود إجمالي
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            أول موظف: {{ $missingData['first_employee_date'] ? $missingData['first_employee_date']->format('Y-m-d') : 'غير محدد' }}
                                        </p>
                                        @if($missingData['last_task_date'])
                                        <p class="text-xs text-gray-500">
                                            آخر مهمة: {{ $missingData['last_task_date']->format('Y-m-d') }}
                                        </p>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.companies.simulation-config.index', $company->id) }}" 
                                           class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                            إعدادات
                                        </a>
                                        <a href="{{ route('admin.companies.show', $company->id) }}" 
                                           class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700 transition">
                                            عرض
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Companies with Disabled Simulation -->
                @if($disabledCompanies->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4 text-red-700">الشركات مع المحاكاة المعطلة</h2>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($disabledCompanies as $company)
                            <div class="bg-white p-4 rounded border border-red-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $company->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $company->email }}</p>
                                        <p class="text-xs text-gray-500">{{ $company->employees->count() }} موظف</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.companies.simulation-config.index', $company->id) }}" 
                                           class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                            إعدادات
                                        </a>
                                        <a href="{{ route('admin.companies.show', $company->id) }}" 
                                           class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700 transition">
                                            عرض
                                        </a>
                                    </div>
                                </div>
                                @if($company->config)
                                <div class="mt-3 text-xs text-gray-600">
                                    <div>المهام/يوم: {{ $company->config->tasks_per_day }}</div>
                                    <div>الاستجابة التلقائية: {{ $company->config->auto_complete ? 'مفعلة' : 'معطلة' }}</div>
                                    <div>معدل الإكمال: {{ $company->config->completion_rate }}%</div>
                                </div>
                                @else
                                <div class="mt-3 text-xs text-yellow-600">لا توجد إعدادات محاكاة</div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- All Companies Configuration -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">جميع إعدادات المحاكاة للشركات</h2>
                        <div class="flex gap-2">
                            <form action="{{ route('admin.simulation.companies.bulk-enable') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="company_ids" id="bulk-enable-ids">
                                <button type="submit" id="bulk-enable-btn" disabled class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    تفعيل المحدد
                                </button>
                            </form>
                            <form action="{{ route('admin.simulation.companies.bulk-disable') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="company_ids" id="bulk-disable-ids">
                                <button type="submit" id="bulk-disable-btn" disabled class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    تعطيل المحدد
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الشركة</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">الحالة</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">المهام/يوم</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">الاستجابة التلقائية</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">معدل الإكمال</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">قيد التنفيذ</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">التعليقات فقط</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">الموظفين</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">رسم بياني للمهام</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($companies as $company)
                                <tr class="hover:bg-gray-50 {{ !$company->config || !$company->config->is_enabled ? 'bg-red-50' : '' }}">
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" name="company_ids[]" value="{{ $company->id }}" 
                                               class="company-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $company->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $company->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if(!$company->config)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                بدون إعدادات
                                            </span>
                                        @elseif($company->config->is_enabled)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                مفعلة
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                معطلة
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-900">
                                        {{ $company->config ? $company->config->tasks_per_day : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($company->config)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $company->config->auto_complete ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $company->config->auto_complete ? 'مفعلة' : 'معطلة' }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-900">
                                        {{ $company->config ? $company->config->completion_rate . '%' : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-900">
                                        {{ $company->config ? $company->config->in_progress_rate . '%' : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-900">
                                        {{ $company->config ? $company->config->comment_only_rate . '%' : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-900">
                                        {{ $company->employees->count() }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if(isset($company->task_creation_data) && !empty($company->task_creation_data['dates']))
                                            <div class="w-32 h-16 bg-gray-50 rounded border p-1">
                                                <canvas id="chart-{{ $company->id }}" width="128" height="64"></canvas>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <div class="font-medium">{{ $company->task_creation_data['total_tasks'] }} مهمة</div>
                                                <div class="text-xs">
                                                    {{ $company->task_creation_data['days_with_tasks'] }} يوم مع مهام
                                                    @if($company->task_creation_data['days_without_tasks'] > 0)
                                                        <br><span class="text-red-500">{{ $company->task_creation_data['days_without_tasks'] }} يوم بدون مهام</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-400">لا توجد بيانات</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('admin.companies.simulation-config.index', $company->id) }}" 
                                               class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                                إعدادات
                                            </a>
                                            <a href="{{ route('admin.companies.show', $company->id) }}" 
                                               class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700 transition">
                                                عرض
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const companyCheckboxes = document.querySelectorAll('.company-checkbox');
    const bulkEnableBtn = document.getElementById('bulk-enable-btn');
    const bulkDisableBtn = document.getElementById('bulk-disable-btn');
    const bulkEnableIds = document.getElementById('bulk-enable-ids');
    const bulkDisableIds = document.getElementById('bulk-disable-ids');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        companyCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkButtons();
    });

    // Individual checkbox functionality
    companyCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkButtons();
            updateSelectAll();
        });
    });

    function updateBulkButtons() {
        const checkedBoxes = document.querySelectorAll('.company-checkbox:checked');
        const hasChecked = checkedBoxes.length > 0;
        
        bulkEnableBtn.disabled = !hasChecked;
        bulkDisableBtn.disabled = !hasChecked;

        if (hasChecked) {
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            bulkEnableIds.value = JSON.stringify(ids);
            bulkDisableIds.value = JSON.stringify(ids);
        }
    }

    function updateSelectAll() {
        const checkedBoxes = document.querySelectorAll('.company-checkbox:checked');
        const totalBoxes = companyCheckboxes.length;
        selectAllCheckbox.checked = checkedBoxes.length === totalBoxes;
        selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalBoxes;
    }

    // Initialize charts for companies with task data
    @foreach($companies as $company)
        @if(isset($company->task_creation_data) && !empty($company->task_creation_data['dates']))
            const ctx{{ $company->id }} = document.getElementById('chart-{{ $company->id }}').getContext('2d');
            
            // Determine chart color based on missing days
            const hasMissingDays{{ $company->id }} = {{ $company->task_creation_data['days_without_tasks'] }} > 0;
            const chartColor{{ $company->id }} = hasMissingDays{{ $company->id }} ? 'rgb(239, 68, 68)' : 'rgb(34, 197, 94)';
            const backgroundColor{{ $company->id }} = hasMissingDays{{ $company->id }} ? 'rgba(239, 68, 68, 0.1)' : 'rgba(34, 197, 94, 0.1)';
            
            new Chart(ctx{{ $company->id }}, {
                type: 'line',
                data: {
                    labels: @json($company->task_creation_data['dates']),
                    datasets: [{
                        label: 'المهام',
                        data: @json($company->task_creation_data['counts']),
                        borderColor: chartColor{{ $company->id }},
                        backgroundColor: backgroundColor{{ $company->id }},
                        borderWidth: 2,
                        fill: true,
                        tension: 0.2,
                        pointRadius: 0,
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: chartColor{{ $company->id }},
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: chartColor{{ $company->id }},
                            borderWidth: 1,
                            callbacks: {
                                title: function(context) {
                                    return 'اليوم ' + context[0].label;
                                },
                                label: function(context) {
                                    return 'المهام: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: false,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            display: false,
                            grid: {
                                display: false
                            },
                            beginAtZero: true
                        }
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        @endif
    @endforeach
});
</script>
@endsection 
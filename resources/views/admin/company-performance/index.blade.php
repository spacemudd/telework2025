@extends('layouts.admin')

@section('title', 'تقرير أداء الشركات')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <!-- Page Header -->
        <div class="col-span-12">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">تقرير أداء الشركات</h1>
            <p class="text-gray-600 mb-6">تقرير شامل عن أداء الشركات والموظفين والمهام المنجزة</p>
        </div>

        <!-- Filters -->
        <div class="col-span-12 bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">فلاتر التقرير</h2>
            <form method="GET" action="{{ route('admin.company-performance.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <!-- Date Range -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">من تاريخ</label>
                    <input type="date" name="date_from" id="date_from" value="{{ $dateFrom }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">إلى تاريخ</label>
                    <input type="date" name="date_to" id="date_to" value="{{ $dateTo }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Company Filter -->
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">الشركة</label>
                    <select name="company_id" id="company_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الشركات</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Employee Filter -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">الموظف</label>
                    <select name="employee_id" id="employee_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الموظفين</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $employeeId == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->company->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Job Title Filter -->
                <div>
                    <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">المسمى الوظيفي</label>
                    <select name="job_title" id="job_title" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع المسميات</option>
                        @foreach($jobTitles as $title)
                            <option value="{{ $title }}" {{ $jobTitle == $title ? 'selected' : '' }}>
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="col-span-full lg:col-span-1 flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        تطبيق الفلاتر
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="col-span-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ltr:ml-4 rtl:mr-4">
                        <p class="text-sm text-gray-600">إجمالي المهام</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalTasks) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ltr:ml-4 rtl:mr-4">
                        <p class="text-sm text-gray-600">المهام المكتملة</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($completedTasks) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ltr:ml-4 rtl:mr-4">
                        <p class="text-sm text-gray-600">المهام قيد التنفيذ</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($inProgressTasks) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div class="ltr:ml-4 rtl:mr-4">
                        <p class="text-sm text-gray-600">نسبة الإنجاز</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $completionRate }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Tasks Chart -->
        <div class="col-span-12 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">المهام اليومية - من {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} إلى {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</h2>
                <div class="h-96">
                    <canvas id="dailyTasksChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tasks by Company -->
        <div class="col-span-12 lg:col-span-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">المهام حسب الشركة</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الشركة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجمالي</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">مكتمل</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">قيد التنفيذ</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">معلق</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tasksByCompany as $companyName => $stats)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $companyName }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['total'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $stats['completed'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">{{ $stats['in_progress'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['pending'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        لا توجد بيانات للعرض
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tasks by Job Title -->
        <div class="col-span-12 lg:col-span-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">المهام حسب المسمى الوظيفي</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المسمى الوظيفي</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجمالي</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">مكتمل</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">قيد التنفيذ</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">معلق</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tasksByJobTitle as $jobTitle => $stats)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $jobTitle ?: 'غير محدد' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['total'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $stats['completed'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">{{ $stats['in_progress'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['pending'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        لا توجد بيانات للعرض
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tasks by Employee -->
        <div class="col-span-12">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">المهام حسب الموظف</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الموظف</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الشركة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المسمى الوظيفي</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجمالي</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">مكتمل</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">قيد التنفيذ</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">معلق</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tasksByEmployee as $employeeName => $stats)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $employeeName }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['employee']->company->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['employee']->position ?: 'غير محدد' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['total'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $stats['completed'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">{{ $stats['in_progress'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['pending'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        لا توجد بيانات للعرض
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Update employee dropdown based on selected company
document.getElementById('company_id').addEventListener('change', function() {
    const companyId = this.value;
    const employeeSelect = document.getElementById('employee_id');
    
    // Clear current options
    employeeSelect.innerHTML = '<option value="">جميع الموظفين</option>';
    
    // All employees data
    const allEmployees = [
        @foreach($employees as $employee)
        {
            id: '{{ $employee->id }}',
            company_id: '{{ $employee->company_id }}',
            name: '{{ $employee->name }}',
            company_name: '{{ $employee->company->name }}'
        },
        @endforeach
    ];
    
    // Filter employees based on selected company
    const filteredEmployees = companyId ? 
        allEmployees.filter(emp => emp.company_id === companyId) : 
        allEmployees;
    
    // Add filtered employees to dropdown
    filteredEmployees.forEach(employee => {
        const option = document.createElement('option');
        option.value = employee.id;
        option.textContent = employee.name + ' (' + employee.company_name + ')';
        employeeSelect.appendChild(option);
    });
});

// Daily Tasks Chart
const ctx = document.getElementById('dailyTasksChart').getContext('2d');
const dailyTasksChart = new Chart(ctx, {
    type: 'bar',
    data: {!! json_encode($dailyTaskData) !!},
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'التواريخ'
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'توزيع المهام اليومية حسب الحالة - {{ \Carbon\Carbon::parse($dateFrom)->format("d/m/Y") }} إلى {{ \Carbon\Carbon::parse($dateTo)->format("d/m/Y") }}',
                font: {
                    size: 16
                }
            },
            legend: {
                display: true,
                position: 'top'
            }
        },
        interaction: {
            mode: 'index',
            intersect: false
        }
    }
});
</script>
@endsection 
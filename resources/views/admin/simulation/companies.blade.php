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
});
</script>
@endsection 
@extends('layouts.admin')

@section('title', 'تكاليف المحاكاة')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <div class="col-span-12">
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl font-semibold">تكاليف المحاكاة</h1>
                    <a href="{{ route('admin.simulation.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        العودة للإعدادات
                    </a>
                </div>

                <!-- Date Range Filter -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <form method="GET" action="{{ route('admin.simulation.costs') }}" class="flex gap-4 items-end">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">من تاريخ</label>
                            <input type="date" name="start_date" id="start_date" 
                                   value="{{ $startDate }}" 
                                   class="border-gray-300 rounded shadow-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ</label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="{{ $endDate }}" 
                                   class="border-gray-300 rounded shadow-sm">
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            عرض التكاليف
                        </button>
                    </form>
                </div>

                <!-- Summary Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">${{ number_format($totalCost, 2) }}</div>
                        <div class="text-sm text-blue-800">إجمالي التكاليف</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($totalCalls) }}</div>
                        <div class="text-sm text-green-800">إجمالي المكالمات</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($totalTokens) }}</div>
                        <div class="text-sm text-purple-800">إجمالي الرموز</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">${{ $totalCalls > 0 ? number_format($totalCost / $totalCalls, 4) : '0.0000' }}</div>
                        <div class="text-sm text-orange-800">متوسط التكلفة للمكالمة</div>
                    </div>
                </div>

                <!-- Companies Cost Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الشركة</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">التكلفة</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">المكالمات</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">الرموز</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">الموظفين</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">التكلفة/موظف</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">التكلفة/مكالمة</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">النسبة المئوية</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($costData as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $data['company']->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $data['company']->email }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="font-semibold text-gray-900">${{ number_format($data['cost'], 2) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900">
                                    {{ number_format($data['calls']) }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900">
                                    {{ number_format($data['tokens']) }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900">
                                    {{ $data['employees'] }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900">
                                    ${{ $data['employees'] > 0 ? number_format($data['cost'] / $data['employees'], 2) : '0.00' }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-900">
                                    ${{ $data['calls'] > 0 ? number_format($data['cost'] / $data['calls'], 4) : '0.0000' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $totalCost > 0 ? number_format(($data['cost'] / $totalCost) * 100, 1) : '0' }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(empty($costData))
                <div class="text-center py-8">
                    <div class="text-gray-500 text-lg">لا توجد بيانات تكاليف للفترة المحددة</div>
                    <div class="text-gray-400 text-sm mt-2">جرب تغيير نطاق التاريخ أو تشغيل المحاكاة</div>
                </div>
                @endif

                <!-- Export Options -->
                @if(!empty($costData))
                <div class="mt-6 flex gap-4">
                    <button onclick="exportToCSV()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        تصدير إلى CSV
                    </button>
                    <button onclick="printReport()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        طباعة التقرير
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.querySelector('table');
    const rows = Array.from(table.querySelectorAll('tr'));
    
    let csv = 'Company,Cost,Calls,Tokens,Employees,Cost per Employee,Cost per Call,Percentage\n';
    
    rows.slice(1).forEach(row => {
        const cells = Array.from(row.querySelectorAll('td'));
        const rowData = cells.map(cell => {
            let text = cell.textContent.trim();
            // Remove currency symbols and extra formatting
            text = text.replace(/[$,]/g, '').replace(/%/g, '');
            return `"${text}"`;
        });
        csv += rowData.join(',') + '\n';
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'simulation_costs_{{ $startDate }}_to_{{ $endDate }}.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

function printReport() {
    window.print();
}
</script>
@endsection 
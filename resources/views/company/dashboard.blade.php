@extends('layouts.company')

@section('title', 'لوحة تحكم الشركة')

@section('company-content')
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">مرحبًا بك في لوحة تحكم الشركة</h1>
        <p class="text-gray-700">هنا يمكنك متابعة الموظفين والمهام الموكلة إليهم.</p>
        @if($employees && $employees->count())
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">الموظفون المرتبطون ({{ $employees->count() }})</h2>
                    <div class="flex gap-2 mb-4">
                        <a href="{{ route('company.attendance.export') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                            تحميل تقرير الحضور
                        </a>
                        <button onclick="openTaskDownloadModal()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                            المهام
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-right text-sm">الاسم</th>
                            <th class="py-3 px-4 text-right text-sm">البريد الإلكتروني</th>
                            <th class="py-3 px-4 text-right text-sm">الوظيفة</th>
                            <th class="py-3 px-4 text-right text-sm">قيد الانتظار</th>
                            <th class="py-3 px-4 text-right text-sm">قيد التنفيذ</th>
                            <th class="py-3 px-4 text-right text-sm">مكتملة</th>
                            <th class="py-3 px-4 text-right text-sm">تم التزامن؟</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($employees as $employee)
                            <tr class="border-t">
                                <td class="py-3 px-4"><a href="{{ route('company.employees.show', $employee->id) }}">{{ $employee->name }}</a></td>
                                <td class="py-3 px-4">{{ $employee->email }}</td>
                                <td class="py-3 px-4">{{ $employee->position }}</td>
                                <td class="py-3 px-4">{{ $employee->tasks()->where('status', 'pending')->count() }}</td>
                                <td class="py-3 px-4">{{ $employee->tasks()->where('status', 'in_progress')->count() }}</td>
                                <td class="py-3 px-4">{{ $employee->tasks()->where('status', 'completed')->count() }}</td>
                                <td class="py-3 px-4">
                                    @if ($employee->employee_telework_syncs()->count())
                                        {{ $employee->employee_telework_syncs()->oldest()->first()->created_at->format('d-m-Y') }}
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p class="text-gray-500 mt-6">لا يوجد موظفون مرتبطون حاليًا.</p>
        @endif
    </div>

    <!-- Include Task Download Modal -->
    @include('components.task-download-modal')
@endsection

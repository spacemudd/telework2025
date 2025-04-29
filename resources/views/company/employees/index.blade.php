@extends('layouts.company')

@section('title', 'الموظفون')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <div class="col-span-12">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-xl font-semibold mb-4">قائمة الموظفين</h1>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">البريد الإلكتروني</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الهوية</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employees as $employee)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $employee->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $employee->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $employee->identity_number }}</td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <a href="{{ route('company.employees.show', $employee->id) }}" class="text-blue-600 hover:underline">عرض</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.company')

@section('title', 'لوحة تحكم الشركة')

@section('company-content')
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">مرحبًا بك في لوحة تحكم الشركة</h1>
        <p class="text-gray-700">هنا يمكنك متابعة الموظفين والمهام الموكلة إليهم.</p>
        @if($employees && $employees->count())
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">الموظفون المرتبطون</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-right">الاسم</th>
                            <th class="py-3 px-4 text-right">البريد الإلكتروني</th>
                            <th class="py-3 px-4 text-right">الوظيفة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($employees as $employee)
                            <tr class="border-t">
                                <td class="py-3 px-4">{{ $employee->name }}</td>
                                <td class="py-3 px-4">{{ $employee->email }}</td>
                                <td class="py-3 px-4">{{ $employee->position }}</td>
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
@endsection

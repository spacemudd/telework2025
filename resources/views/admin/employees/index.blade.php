@extends('layouts.admin')

@section('title', __('words.employees'))

@section('admin-content')
    <div class="p-6 max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">{{ __('words.employees') }}</h1>
            <a href="{{ route('admin.employees.export') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">{{ __('words.export') }} CSV</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-right">{{ __('words.name') }}</th>
                    <th class="py-3 px-4 text-right">{{ __('words.email') }}</th>
                    <th class="py-3 px-4 text-right">{{ __('words.company') }}</th>
                    <th class="py-3 px-4 text-right">{{ __('words.position') }}</th>
                    <th class="py-3 px-4 text-right">{{ __('words.added-date') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($employees as $employee)
                    <tr class="border-t">
                        <td class="py-3 px-4"><a href="{{ route('admin.companies.employees.show', ['company' => $employee->company_id, 'employee' => $employee->id]) }}">{{ $employee->name }}</a></td>
                        <td class="py-3 px-4">{{ $employee->email }}</td>
                        <td class="py-3 px-4">{{ $employee->company?->name ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $employee->position ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $employee->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $employees->links() }}
        </div>

    </div>
@endsection

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
            <h1 class="text-2xl font-bold">{{ $company->name }}</h1>
            <div>
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
                        <x-dropdown-link href="{{ route('admin.companies.audit', $company->id) }}">
                            {{ __('words.communication-log') }}
                        </x-dropdown-link>
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
                    <tr>
                        <th class="text-left py-2 px-4 font-semibold">{{ __('words.phone') }}</th>
                        <td class="py-2 px-4">{{ $company->phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">{{ __('words.employees') }} ({{ $company->employees()->count() }})</h2>

            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.employees.create', ['company' => $company->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
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
                                <td class="py-2 px-4"><a href="{{ route('admin.companies.employees.show', ['company' => $company, 'employee' => $employee->id]) }}">{{ $employee->name }}</a></td>
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

@extends('layouts.admin')

@section('title', __('words.companies'))

@section('admin-content')
    <div class="container mx-auto">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">{{ __('words.companies') }}</h1>
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.companies.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    {{ __('words.create_company') }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 rtl:text-right">{{ __('words.code') }}</th>
                        <th class="py-3 px-4 rtl:text-right">{{ __('words.name') }}</th>
                        <th class="py-3 px-4 rtl:text-right">{{ __('words.email') }}</th>
                        <th class="py-3 px-4 rtl:text-right">{{ __('words.address') }}</th>
                        <th class="py-3 px-4 rtl:text-right">{{ __('words.cr_number') }}</th>
                        <th class="py-3 px-4 rtl:text-right">{{ __('words.phone') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($companies as $company)
                        <tr class="border-t">
                            <td class="py-3 px-4"><a href="{{ route('admin.companies.show', $company->id) }}">{{ $company->code }}</a></td>
                            <td class="py-3 px-4"><a href="{{ route('admin.companies.show', $company->id) }}">{{ $company->name }}</a></td>
                            <td class="py-3 px-4">{{ $company->email }}</td>
                            <td class="py-3 px-4">{{ $company->address }}</td>
                            <td class="py-3 px-4">{{ $company->cr_number }}</td>
                            <td class="py-3 px-4">{{ $company->phone }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">{{ __('words.no_companies_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
@endsection

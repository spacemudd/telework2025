@php use App\Models\Company;use App\Models\Employee; @endphp
@extends('layouts.admin')

@section('title', __('dashboard.admin_dashboard'))

@section('admin-content')
    <div class="container mx-auto">
        <x-admin.global-search />
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12 md:col-span-3 flex justify-center">
                <a href="{{ route('admin.companies.index') }}"
                   class="bg-white rounded-lg shadow-lg p-8 text-center w-full max-w-sm cursor-pointer">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ Company::count() }}</h1>
                    <p class="text-gray-500 text-sm">{{ __('words.total_companies') }}</p>
                </a>
            </div>

            <div class="col-span-12 md:col-span-3 flex justify-center">
                <a href="{{ route('admin.employees.index') }}"
                   class="bg-white rounded-lg shadow-lg p-8 text-center w-full max-w-sm cursor-pointer">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ Employee::count() }}</h1>
                    <p class="text-gray-500 text-sm">{{ __('words.employees') }}</p>
                </a>
            </div>
        </div>


        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12 md:col-span-3">
                <h2 class="underline">{{ __('words.actions') }}</h2>
                <ul class="list-disc pr-5">
                    <li><a href="{{ route('admin.companies.create') }}">{{ __('words.create_company') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

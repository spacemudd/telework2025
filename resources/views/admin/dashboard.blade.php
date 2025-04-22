@php use App\Models\Company; @endphp
@extends('layouts.admin')

@section('title', __('dashboard.admin_dashboard'))

@section('admin-content')
    <div class="grid grid-cols-12 p-5">

        <div class="col-span-12 flex justify-center">
            <a href="{{ route('admin.companies.index') }}" class="bg-white rounded-lg shadow-lg p-8 text-center w-full max-w-sm">
                <h1 class="text-5xl font-bold text-gray-800 mb-2">{{ Company::count() }}</h1>
                <p class="text-gray-500 text-lg">{{ __('words.total_companies') }}</p>
            </a>
        </div>
    </div>
@endsection

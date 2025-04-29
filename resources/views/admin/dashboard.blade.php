@php use App\Models\Company;use App\Models\Employee; @endphp
@extends('layouts.admin')

@section('title', __('dashboard.admin_dashboard'))

@section('admin-content')
    <div class="container mx-auto">
        <x-admin.global-search />
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12 md:col-span-7">
                <div class="grid grid-cols-12 p-5 gap-5">
                    <div class="col-span-12 md:col-span-6 flex justify-center">
                        <a href="{{ route('admin.companies.index') }}"
                           class="bg-white rounded-lg shadow-lg p-8 text-center w-full max-w-sm cursor-pointer">
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ Company::count() }}</h1>
                            <p class="text-gray-500 text-sm">{{ __('words.total_companies') }}</p>
                        </a>
                    </div>

                    <div class="col-span-12 md:col-span-6 flex justify-center">
                        <a href="{{ route('admin.employees.index') }}"
                           class="bg-white rounded-lg shadow-lg p-8 text-center w-full max-w-sm cursor-pointer">
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ Employee::count() }}</h1>
                            <p class="text-gray-500 text-sm">{{ __('words.employees') }}</p>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-12 p-5 gap-5">
                    <div class="col-span-12 md:col-span-12 flex">
                        {{-- Box of the tickets. --}}
                        <div class="bg-white rounded-lg shadow-lg p-8 w-full">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">{{ __('words.open-tickets') }}</h2>
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-xl font-bold text-gray-900">{{ $openTickets->count() }}</p>
                                    <p class="text-sm text-gray-500">{{ $openTickets->latest()->first()?->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ __('words.open') }}</span>
                            </div>
                            <a href="{{ route('admin.support-tickets.index') }}"
                               class="block mt-4 text-center border border-gray-300 rounded-md py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                {{ __('words.view-all') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-5">
                {{--Latest activity box--}}
                <div class="bg-white rounded-lg shadow-lg p-8 mt-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">{{ __('words.latest_activity') }}</h2>
                    <ul class="list-disc pl-5">
                        @foreach($latestActivities as $activity)
                            <li class="mb-4 text-sm text-gray-800">
                                <span class="block text-xs text-gray-500 mb-1">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>

                                @php
                                    $subjectType = class_basename($activity->subject_type);
                                    $causerName = $activity->causer?->name ?? ('مستخدم #' . $activity->causer_id);
                                @endphp

                                @if($subjectType === 'Task' && isset($activity->properties['old']['status']) && isset($activity->properties['attributes']['status']))
                                    <p>
                                        تم تغيير حالة المهمة رقم #{{ $activity->subject_id }}
                                        من
                                        <span class="font-semibold">{{ __('words.' . $activity->properties['old']['status']) }}</span>
                                        إلى
                                        <span class="font-semibold">{{ __('words.' . $activity->properties['attributes']['status']) }}</span>
                                        بواسطة {{ $causerName }}
                                    </p>
                                @elseif($activity->description === 'created')
                                    <p>
                                        تم إنشاء {{ __('words.' . strtolower($subjectType)) }}
                                        رقم #{{ $activity->subject_id }}
                                        بواسطة {{ $causerName }}
                                    </p>
                                @elseif($activity->description === 'updated')
                                    <p>
                                        تم تعديل {{ __('words.' . strtolower($subjectType)) }}
                                        رقم #{{ $activity->subject_id }}
                                        بواسطة {{ $causerName }}
                                    </p>
                                @elseif($activity->description === 'deleted')
                                    <p>
                                        تم حذف {{ __('words.' . strtolower($subjectType)) }}
                                        رقم #{{ $activity->subject_id }}
                                        بواسطة {{ $causerName }}
                                    </p>
                                @else
                                    <p>
                                        {{ $activity->description }}
                                        على {{ __('words.' . strtolower($subjectType)) }}
                                        رقم #{{ $activity->subject_id }}
                                        بواسطة {{ $causerName }}
                                    </p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
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

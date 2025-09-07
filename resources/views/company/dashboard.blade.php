@extends('layouts.company')

@section('title', 'لوحة تحكم الشركة')

@section('company-content')
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">مرحبًا بك في لوحة تحكم الشركة</h1>
        <p class="text-gray-700">هنا يمكنك متابعة الموظفين والمهام الموكلة إليهم.</p>
        
        <!-- Job Posting Promo Section -->
        @php
            $company = $company ?? auth()->user()->primaryCompany;
            $jobPostingsCount = $company ? \App\Models\JobPosting::where('company_id', $company->id)->count() : 0;
        @endphp
        
        @if($jobPostingsCount == 0)
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4 rtl:ml-4 rtl:mr-0">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('words.start_hiring_today') }}</h3>
                        <p class="text-gray-600 mb-4">{{ __('words.create_your_first_job_posting_description') }}</p>
                        <div class="flex space-x-3 rtl:space-x-reverse">
                            <a href="{{ route('company.job-postings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                {{ __('words.create_job_posting') }}
                            </a>
                            <a href="{{ route('company.job-postings.index') }}" class="bg-white hover:bg-gray-50 text-blue-600 border border-blue-300 px-4 py-2 rounded-lg text-sm font-medium">
                                {{ __('words.view_all_job_postings') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Quick Stats for Job Postings -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ __('words.job_postings_overview') }}</h2>
                    <a href="{{ route('company.job-postings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        {{ __('words.view_all') }} →
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $jobPostingsCount }}</div>
                        <div class="text-sm text-gray-500">{{ __('words.total_job_postings') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ \App\Models\JobPosting::where('company_id', $company->id)->where('is_active', true)->count() }}
                        </div>
                        <div class="text-sm text-gray-500">{{ __('words.active_job_postings') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ \App\Models\JobPosting::where('company_id', $company->id)->withCount('applications')->get()->sum('applications_count') }}
                        </div>
                        <div class="text-sm text-gray-500">{{ __('words.total_applications') }}</div>
                    </div>
                </div>
            </div>
        @endif
        @if($employees && $employees->count())
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">الموظفون المرتبطون ({{ $employees->count() }})</h2>
                    <div class="flex gap-2 mb-4">
                        <button onclick="openAttendanceExportModal()" class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                            {{ __('words.attendance_export') }}
                        </button>
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
    
    <!-- Include Attendance Export Modal -->
    <x-attendance-export-modal :company="$company ?? auth()->user()->primaryCompany" />
@endsection

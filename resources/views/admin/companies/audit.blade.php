@extends('layouts.admin')

@section('title', __('words.company_audit'))

@section('admin-content')
<div class="p-6 max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ __('words.audit_logs_for') }} <a href="{{ route('admin.companies.show', $company->id) }}">{{ $company->name }}</a></h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 rtl:text-right">{{ __('words.recipient_email') }}</th>
                    <th class="py-2 px-4 rtl:text-right">{{ __('words.subject') }}</th>
                    <th class="py-2 px-4 rtl:text-right">{{ __('words.status') }}</th>
                    <th class="py-2 px-4 rtl:text-right">{{ __('words.sent_at') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($company->company_audit_records as $record)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $record->recipient_email }}</td>
                        <td class="py-2 px-4">{{ $record->subject }}</td>
                        <td class="py-2 px-4 capitalize">{{ $record->status }}</td>
                        <td class="py-2 px-4">{{ $record->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">{{ __('words.no_audit_logs_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

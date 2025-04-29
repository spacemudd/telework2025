@extends('layouts.company')

@section('title', 'تذاكر الدعم')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 gap-5 p-5">
            <div class="col-span-12">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h1 class="text-xl font-semibold mb-4">تذاكر الدعم</h1>

                    <a href="{{ route('company.support-tickets.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                        + إنشاء تذكرة جديدة
                    </a>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الرقم</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الموضوع</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tickets as $ticket)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->code }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->subject }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ __('words.'.$ticket->status) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <a href="{{ route('company.support-tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">عرض</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'تذاكر الدعم')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h1 class="text-xl font-semibold mb-4">تذاكر الدعم</h1>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المعرف</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الموضوع</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تابع لـ</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tickets as $ticket)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->code }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->subject }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->status_translated }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ optional($ticket->supportable)->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">
                                <a href="{{ route('admin.support-tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">عرض</a>
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

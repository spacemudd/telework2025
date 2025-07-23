@extends('layouts.company')

@section('title', __('words.requests'))

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 gap-5 p-5">
            <div class="col-span-12">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h1 class="text-xl font-semibold mb-4">{{ __('words.requests') }}</h1>

                    <a href="{{ route('company.employee-requests.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                        + {{ __('words.create_request') }}
                    </a>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('words.code') }}</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('words.job_title') }}</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('words.quantity') }}</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('words.status') }}</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($requests as $request)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $request->code }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $request->job_title }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $request->quantity }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <span class="{{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($request->status === 'responded' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }} text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $request->status_translated }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <a href="{{ route('company.employee-requests.show', $request->id) }}" class="text-blue-600 hover:underline">عرض</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if($requests->count() === 0)
                        <div class="text-center py-8 text-gray-500">
                            لا توجد طلبات موظفين حتى الآن.
                        </div>
                    @endif

                    <div class="mt-6">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
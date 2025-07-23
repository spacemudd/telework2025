@extends('layouts.company')

@section('title', __('words.request_details'))

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12">
                <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
                    <h1>{{ $request->code }}</h1>
                    <h1 class="text-xl font-semibold mb-4">
                        {{ __('words.request_details') }}
                        <span class="{{ $request->status === 'closed' ? 'bg-red-100 text-red-800' : ($request->status === 'responded' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }} text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $request->status_translated }}
                        </span>
                    </h1>

                    <div class="mb-6 bg-gray-50 p-4 rounded border-right-4 border-blue-500">
                        <h2 class="text-lg font-medium mb-3">تفاصيل الطلب</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">{{ __('words.job_title') }}:</span>
                                <p class="font-medium">{{ $request->job_title }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">{{ __('words.quantity') }}:</span>
                                <p class="font-medium">{{ $request->quantity }}</p>
                            </div>
                        </div>
                        @if($request->note)
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">{{ __('words.note') }}:</span>
                                <p class="mt-1 p-3 bg-white border rounded">{{ $request->note }}</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <span class="text-sm text-gray-600">تاريخ الطلب:</span>
                            <p class="text-sm" dir="ltr" title="{{ $request->created_at->format('Y-m-d H:i') }}">{{ $request->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($request->messages->count() > 1)
                        <h2 class="text-lg font-medium mb-3">الردود</h2>
                        <div class="space-y-4 mb-6">
                            @foreach($request->messages as $message)
                                @if(!$loop->first) {{-- Skip the first message which is the initial request --}}
                                    <div class="p-4 border rounded {{ $message->sender->hasRole('admin') ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
                                        <div class="text-sm text-gray-600 mb-1">
                                            {{ $message->sender->hasRole('admin') ? 'إدارة النظام' : $message->sender->name }} —
                                            <span dir="ltr" title="{{ $message->created_at->format('Y-m-d H:i') }}">
                                                {{ $message->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <div class="text-gray-800">
                                            {{ $message->message }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('company.employee-requests.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                            العودة للقائمة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
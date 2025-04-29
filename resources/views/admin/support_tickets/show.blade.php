@extends('layouts.admin')

@section('title', 'عرض التذكرة')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12">
                <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
                    <h1>{{ $supportTicket->code }}</h1>
                    <h1 class="text-xl font-semibold mb-4">
                        تفاصيل التذكرة
                        <span class="{{ $supportTicket->status === 'closed' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $supportTicket->status_translated }}
                        </span>
                    </h1>

                    <div class="mb-6">
                        <h2 class="text-lg font-medium mb-3">{{ optional($supportTicket->supportable)->name ?? '-' }}</h2>
                        <div class="p-4 border rounded bg-gray-50">
                            <p dir="ltr" class="text-xs">
                                <span title="{{ $supportTicket->created_at->format('Y-m-d H:i') }}">
                                    {{ $supportTicket->created_at->diffForHumans() }}
                                </span>
                            </p>
                            <p>{{ $supportTicket->subject }}</p>
                        </div>
                    </div>

                    <h2 class="text-lg font-medium mb-3">الرسائل</h2>
                    <div class="space-y-4 mb-6">
                        @foreach($supportTicket->messages as $message)
                            <div class="p-4 border rounded bg-gray-50">
                                <div class="text-sm text-gray-600 mb-1">
                                    {{ $message->sender->name ?? 'نظام' }} —
                                    <span title="{{ $message->created_at->format('Y-m-d H:i') }}">
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="text-gray-800">
                                    {{ $message->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('admin.support-tickets.messages.store', $supportTicket->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">رد جديد</label>
                            <textarea name="message" id="message" rows="4" required
                                      class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"></textarea>
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                إرسال الرد
                            </button>
                            <button type="submit" name="close" value="1"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                الرد وإغلاق التذكرة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

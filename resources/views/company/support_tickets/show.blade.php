@extends('layouts.company')

@section('title', 'عرض التذكرة')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12">
                <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
                    <h1>{{ $ticket->code }}</h1>
                    <h1 class="text-xl font-semibold mb-4">
                        تفاصيل التذكرة
                        <span class="{{ $ticket->status === 'closed' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $ticket->status_translated }}
                        </span>
                    </h1>

                    <div class="mb-6">
                    <h2 class="text-lg font-medium mb-3">{{ __('words.subject') }}</h2>
                    <div class="p-4 border rounded bg-gray-50">
                        <p dir="ltr" class="text-xs"><span dir="ltr" title="{{ $ticket->created_at->format('Y-m-d H:i') }}">{{ $ticket->created_at->diffForHumans() }}</span></p>
                        <p>{{ $ticket->subject }}</p>
                    </div>
                    </div>

                    <h2 class="text-lg font-medium mb-3">الرسائل</h2>
                    <div class="space-y-4 mb-6">
                        @foreach($ticket->messages as $message)
                            <div class="p-4 border rounded bg-gray-50">
                                <div class="text-sm text-gray-600 mb-1">
                                    {{ ($message->sender->hasRole('admin')) ? __('words.customer-support') : ($message->sender->name ?? 'النظام') }} —
                                    <span dir="ltr" title="{{ $message->created_at->format('Y-m-d H:i') }}">
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="text-gray-800">
                                    {{ $message->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($ticket->status === 'closed')
                        <div class="text-red-500 mb-4">
                            <strong>التذكرة مغلقة، لا يمكنك إضافة ردود جديدة.</strong>
                        </div>
                    @else
                        <form method="POST" action="{{ route('company.support-tickets.messages.store', $ticket->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">رد جديد</label>
                                <textarea name="message" id="message" rows="4" required
                                          class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"></textarea>
                            </div>
                            <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                إرسال
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
@endsection

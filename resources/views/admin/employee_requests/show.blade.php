@extends('layouts.admin')

@section('title', 'عرض الطلب')

@section('content')
    <div class="container mx-auto">
        <div class="grid grid-cols-12 p-5 gap-5">
            <div class="col-span-12">
                <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-xl font-semibold">
                            طلب موظف رقم: {{ $employeeRequest->code }}
                            <span class="{{ $employeeRequest->status === 'closed' ? 'bg-red-100 text-red-800' : ($employeeRequest->status === 'responded' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }} text-xs font-semibold px-2.5 py-0.5 rounded ml-2">
                                {{ $employeeRequest->status_translated }}
                            </span>
                        </h1>
                        <a href="{{ route('admin.employee-requests.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← العودة للقائمة
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Company Info -->
                    <div class="mb-6 bg-blue-50 p-4 rounded border-right-4 border-blue-500">
                        <h2 class="text-lg font-medium mb-3 text-blue-800">معلومات الشركة</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">{{ __('words.name') }}:</span>
                                <p class="font-medium">{{ $employeeRequest->company->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">{{ __('words.email') }}:</span>
                                <p class="font-medium">{{ $employeeRequest->company->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Request Details -->
                    <div class="mb-6 bg-gray-50 p-4 rounded border-right-4 border-green-500">
                        <h2 class="text-lg font-medium mb-3">تفاصيل الطلب</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">{{ __('words.job_title') }}:</span>
                                <p class="font-medium text-lg">{{ $employeeRequest->job_title }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">{{ __('words.quantity') }}:</span>
                                <p class="font-medium text-lg">{{ $employeeRequest->quantity }} موظف/ـة</p>
                            </div>
                        </div>
                        @if($employeeRequest->note)
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">{{ __('words.note') }}:</span>
                                <p class="mt-1 p-3 bg-white border rounded">{{ $employeeRequest->note }}</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <span class="text-sm text-gray-600">تاريخ الطلب:</span>
                            <p class="text-sm" dir="ltr" title="{{ $employeeRequest->created_at->format('Y-m-d H:i') }}">{{ $employeeRequest->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Messages History -->
                    @if($employeeRequest->messages->count() > 0)
                        <h2 class="text-lg font-medium mb-3">سجل المراسلات</h2>
                        <div class="space-y-4 mb-6">
                            @foreach($employeeRequest->messages as $message)
                                <div class="p-4 border rounded {{ $message->sender->hasRole('admin') ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
                                    <div class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium">
                                            @if($message->sender->hasRole('admin'))
                                                🔧 إدارة النظام
                                            @else
                                                🏢 {{ $message->sender->name ?? $employeeRequest->company->name }}
                                            @endif
                                        </span>
                                        —
                                        <span dir="ltr" title="{{ $message->created_at->format('Y-m-d H:i') }}">
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="text-gray-800 whitespace-pre-line">{{ $message->message }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Admin Response Form -->
                    @if($employeeRequest->status !== 'closed')
                        <div class="border-t pt-6">
                            <h2 class="text-lg font-medium mb-3">الرد على الطلب</h2>
                            <form method="POST" action="{{ route('admin.employee-requests.messages.store', $employeeRequest->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">نص الرد</label>
                                    <textarea name="message" id="message" rows="4" required
                                              class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"
                                              placeholder="اكتب ردك على طلب الموظف هنا..."></textarea>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                        إرسال الرد
                                    </button>
                                    <button type="submit" name="close" value="1" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                        إرسال الرد وإغلاق الطلب
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="text-red-500 font-medium text-center py-4">
                            تم إغلاق هذا الطلب ولا يمكن إضافة ردود جديدة.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 
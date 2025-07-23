@extends('layouts.company')

@section('title', __('words.create_request'))

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 gap-5 p-5">
        <div class="col-span-12">
            <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
                <h1 class="text-xl font-semibold mb-4">{{ __('words.new_employee_request') }}</h1>

                <form method="POST" action="{{ route('company.employee-requests.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">{{ __('words.job_title') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="job_title" id="job_title" value="{{ old('job_title') }}" required
                            class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 @error('job_title') border-red-500 @enderror"
                            placeholder="مثل: مطور برمجيات، محاسب، مسوق رقمي">
                        @error('job_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">{{ __('words.quantity') }} <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required min="1" max="100"
                            class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 @error('quantity') border-red-500 @enderror">
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">{{ __('words.note') }} <span class="text-gray-500">(اختياري)</span></label>
                        <textarea name="note" id="note" rows="5"
                            class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 @error('note') border-red-500 @enderror"
                            placeholder="أي تفاصيل إضافية أو متطلبات خاصة للمسمى الوظيفي...">{{ old('note') }}</textarea>
                        @error('note')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            إرسال الطلب
                        </button>
                        <a href="{{ route('company.employee-requests.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                            {{ __('words.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
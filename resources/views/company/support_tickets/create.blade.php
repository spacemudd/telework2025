@extends('layouts.company')

@section('title', 'إنشاء تذكرة دعم')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-xl font-semibold mb-4">إنشاء تذكرة جديدة</h1>

    <form method="POST" action="{{ route('company.support-tickets.store') }}">
        @csrf

        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">الموضوع</label>
            <input type="text" name="subject" id="subject" required
                class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">الرسالة</label>
            <textarea name="message" id="message" rows="5" required
                class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"></textarea>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            إرسال
        </button>
    </form>
</div>
@endsection

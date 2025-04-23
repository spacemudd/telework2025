

@extends('layouts.admin')

@section('title', 'إرسال بريد إلكتروني')

@section('content')
    <div class="container mx-auto">
        <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
            <h1 class="text-xl font-semibold mb-4">إرسال بريد إلكتروني إلى: {{ $company->name }}</h1>

            <form action="{{ route('admin.companies.sendEmail', $company->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="subject" class="block font-medium mb-1">الموضوع</label>
                    <input type="text" name="subject" id="subject" class="w-full border-gray-300 rounded shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="message" class="block font-medium mb-1">الرسالة</label>
                    <textarea name="message" id="message" rows="6" class="w-full border-gray-300 rounded shadow-sm" required></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">إرسال</button>
            </form>
        </div>
    </div>
@endsection

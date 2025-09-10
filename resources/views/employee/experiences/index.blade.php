@extends('layouts.employee')

@section('title', 'الخبرات المهنية')

@section('employee-content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <nav class="mb-6 text-sm text-gray-500 text-left" dir="rtl">
            <a href="{{ route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()]) }}" class="hover:text-gray-700">لوحة التحكم</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-700">الخبرات المهنية</span>
        </nav>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">الخبرات المهنية</h1>
            <a href="{{ route('employee.experiences.create', ['locale' => app()->getLocale()]) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                إضافة خبرة جديدة
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM9 11v4h2v-4H9zm0-4h2v2H9V7z"/></svg></div>
                    <div>
                        <p class="font-bold">نجاح</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($experiences->count() > 0)
            <div class="space-y-4">
                @foreach($experiences as $experience)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $experience->job_title }}</h3>
                                <p class="text-gray-600">{{ $experience->company_name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $experience->start_date->format('M Y') }} - 
                                    {{ $experience->is_current ? 'حالياً' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                                </p>
                                @if($experience->description)
                                    <p class="text-gray-700 mt-2">{{ $experience->description }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('employee.experiences.edit', ['locale' => app()->getLocale(), 'experience' => $experience->id]) }}" 
                                   class="text-blue-600 hover:text-blue-800">تعديل</a>
                                <form action="{{ route('employee.experiences.destroy', ['locale' => app()->getLocale(), 'experience' => $experience->id]) }}" 
                                      method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500 mb-4">لم تقم بإضافة أي خبرات مهنية بعد</p>
                <a href="{{ route('employee.experiences.create', ['locale' => app()->getLocale()]) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    إضافة أول خبرة
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

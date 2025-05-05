@extends('layouts.admin')

@section('title', 'الإعدادات')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-12 p-5 gap-5">
        <div class="col-span-12">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <a href="#" class="block p-4 bg-white rounded shadow hover:shadow-md transition opacity-50 pointer-events-none">
                    <h2 class="font-bold text-sm mb-1">القيم الافتراضية للشركات</h2>
                    <p class="text-xs text-gray-600">ضبط القيم التي يتم استخدامها بشكل تلقائي عند إنشاء شركة جديدة.</p>
                </a>

                <a href="#" class="block p-4 bg-white rounded shadow hover:shadow-md transition opacity-50 pointer-events-none">
                    <h2 class="font-bold text-sm mb-1">جدول الحضور</h2>
                    <p class="text-xs text-gray-600">خيارات وتنسيق جدول الحضور المستخدم في تقارير النظام.</p>
                </a>

                <a href="#" class="block p-4 bg-white rounded shadow hover:shadow-md transition opacity-50 pointer-events-none">
                    <h2 class="font-bold text-sm mb-1">نظام التذاكر</h2>
                    <p class="text-xs text-gray-600">إعدادات النظام الخاص بتذاكر الدعم الفني والمراسلات.</p>
                </a>

                <a href="#" class="block p-4 bg-white rounded shadow hover:shadow-md transition opacity-50 pointer-events-none">
                    <h2 class="font-bold text-sm mb-1">إعدادات التنبيهات</h2>
                    <p class="text-xs text-gray-600">ضبط التنبيهات التي يتم إرسالها للمديرين أو المستخدمين بناءً على الأحداث.</p>
                </a>

                <a href="#" class="block p-4 bg-white rounded shadow hover:shadow-md transition opacity-50 pointer-events-none">
                    <h2 class="font-bold text-sm mb-1">تكامل العمل عن بعد</h2>
                    <p class="text-xs text-gray-600">إعدادات الربط مع بوابة العمل عن بعد وإرسال البيانات تلقائيًا.</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

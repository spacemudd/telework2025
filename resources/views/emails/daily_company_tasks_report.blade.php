<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.5;
            color: #333333;
            margin: 0;
            padding: 20px;
            direction: rtl;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <p>السادة الكرام /  {{$company->name}}</p>
    <p>مرفق لكم تقرير النشاط ليوم -  {{ \Carbon\Carbon::parse($yesterday)->translatedFormat('l j F Y') }}</p>
    <p>---------------------------------</p>
    <ul class="stats">
        <li>مهام جديدة: {{ $statistics['new'] }}</li>
        <li>مهام محدثة: {{ $statistics['updated'] }}</li>
        <li>مهام مكتملة: {{ $statistics['completed'] }}</li>
    </ul>
    <p>---------------------------------</p>
    <div>
        تم إرفاق ملف يحتوي على تفاصيل جميع المهام بصيغة CSV.
    </div>
    <p>---------------------------------</p>
    <div class="footer" style="margin-top: 20px; font-size: 12px; color: #777;">
        هدف،<br>
        تحياتنا
    </div>
</body>
</html>

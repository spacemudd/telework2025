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
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 16px;
            font-weight: normal;
            margin: 0 0 5px 0;
        }
        .date {
            color: #666666;
            margin: 0 0 20px 0;
        }
        .stats {
            margin: 25px 0;
            padding: 0;
            list-style: none;
        }
        .stats li {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666666;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="company-name">{{ $company->name }}</h1>
            <p class="date">{{ \Carbon\Carbon::parse($yesterday)->translatedFormat('l j F Y') }}</p>
        </div>

        <div>تقرير المهام اليومي</div>

        <ul class="stats">
            <li>مهام جديدة: {{ $statistics['new'] }}</li>
            <li>مهام محدثة: {{ $statistics['updated'] }}</li>
            <li>مهام مكتملة: {{ $statistics['completed'] }}</li>
        </ul>

        <div>
            تم إرفاق ملف يحتوي على تفاصيل جميع المهام بصيغة CSV.
        </div>

        <div class="footer">
            {{ config('app.name') }}<br>
            تم إرسال هذا البريد تلقائياً - يرجى عدم الرد عليه
        </div>
    </div>
</body>
</html>

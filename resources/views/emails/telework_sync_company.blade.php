<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد تزامن بيانات الموظفين</title>
</head>
<body style="font-family: Arial, sans-serif; direction: rtl; text-align: right;">
    <h1>شكراً لتعاقدكم مع شركة هدف للتوظيف</h1>
    <p>نفيدكم بأنه قد تم التزامن مع بيانات وزارة العمل كموظف عمل عن بعد اعتباراً من تاريخ {{ $currentDate }} للموظفين التالية بياناتهم:</p>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">الاسم</th>
                <th style="border: 1px solid #ddd; padding: 8px;">الوظيفة</th>
                <th style="border: 1px solid #ddd; padding: 8px;">رقم الهوية</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($company->employees as $employee)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $employee['name'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $employee['position'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $employee['identity_number'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

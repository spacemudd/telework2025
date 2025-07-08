<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تحديث على تذكرة الدعم</title>
</head>
<body style="font-family: Arial, sans-serif; direction: rtl; text-align: right; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9;">
        <div style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #2563eb; margin: 0;">شركة هدف للتوظيف</h1>
                <p style="color: #666; margin: 5px 0;">منصة العمل عن بعد</p>
            </div>

            <h2 style="color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">
                تحديث على تذكرة الدعم
            </h2>

            <div style="background-color: #f3f4f6; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <p><strong>رقم التذكرة:</strong> {{ $ticket->code }}</p>
                <p><strong>الموضوع:</strong> {{ $ticket->subject }}</p>
                <p><strong>حالة التذكرة:</strong> 
                    <span style="background-color: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                        {{ $ticket->status_translated }}
                    </span>
                </p>
            </div>

            <h3 style="color: #374151; margin-top: 30px;">الرد الجديد:</h3>
            <div style="background-color: #eff6ff; border-right: 4px solid #2563eb; padding: 15px; margin: 15px 0;">
                <p style="margin: 0;">{{ $message->message }}</p>
                <small style="color: #6b7280; margin-top: 10px; display: block;">
                    تاريخ الرد: {{ $message->created_at->format('Y-m-d H:i') }}
                </small>
            </div>

            <div style="margin: 30px 0; text-align: center;">
                <a href="{{ route('company.support-tickets.show', $ticket->id) }}" 
                   style="background-color: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                    عرض التذكرة كاملة
                </a>
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">

            <div style="text-align: center; color: #6b7280; font-size: 14px;">
                <p>مع تحيات فريق الدعم الفني</p>
                <p>شركة هدف للتوظيف</p>
            </div>
        </div>
    </div>
</body>
</html> 
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مهمة جديدة تم تكليفك بها</title>
</head>
<body style="margin: 0; padding: 20px; background-color: #f9fafb;">
<div style="direction: rtl; text-align: right; font-family: Arial, sans-serif;">
    <h2 style="color: #2563eb; margin-bottom: 20px;">مهمة جديدة تم تكليفك بها</h2>
    
    <p>مرحباً {{ $employee->name }}،</p>
    
    <p>نفيدكم بأنه تم تكليفكم بمهمة جديدة من قبل شركة {{ $company->name }}. تفاصيل المهمة كما يلي:</p>
    
    <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0; border-right: 4px solid #2563eb;">
        <h3 style="color: #1e40af; margin-top: 0;">{{ $task->title }}</h3>
        
        <p><strong>الوصف:</strong></p>
        <p style="background-color: white; padding: 15px; border-radius: 4px; margin: 10px 0;">{{ $task->description }}</p>
        
        <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 15px;">
            <div>
                <strong>تاريخ الاستحقاق:</strong>
                <span style="color: #dc2626;">{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</span>
            </div>
            
            <div>
                <strong>الأولوية:</strong>
                <span style="
                    padding: 4px 8px; 
                    border-radius: 4px; 
                    font-size: 12px; 
                    color: white;
                    background-color: {{ $task->priority === 'high' ? '#dc2626' : ($task->priority === 'medium' ? '#f59e0b' : '#10b981') }};
                ">
                    {{ $task->priority === 'high' ? 'عالية' : ($task->priority === 'medium' ? 'متوسطة' : 'منخفضة') }}
                </span>
            </div>
        </div>
    </div>
    
    <p>يرجى تسجيل الدخول إلى النظام لعرض تفاصيل المهمة الكاملة والبدء في العمل عليها.</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/login') }}" 
           style="
               background-color: #2563eb; 
               color: white; 
               padding: 12px 24px; 
               text-decoration: none; 
               border-radius: 6px; 
               display: inline-block;
               font-weight: bold;
           ">
            تسجيل الدخول إلى النظام
        </a>
    </div>
    
    <hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">
    
    <p style="color: #6b7280; font-size: 14px;">
        <strong>ملاحظة:</strong> هذا إشعار تلقائي من نظام إدارة العمل عن بعد. 
        في حالة وجود أي استفسارات، يرجى التواصل مع إدارة الشركة.
    </p>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 12px;">
        <p>مع تحيات فريق شركة هدف للتوظيف</p>
        <p>{{ config('app.name') }}</p>
    </div>
</div>
</body>
</html> 
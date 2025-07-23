<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب موظف جديد</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #f9fafb;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 24px;
        }
        .request-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-right: 4px solid #2563eb;
        }
        .field {
            margin-bottom: 15px;
        }
        .field label {
            font-weight: bold;
            color: #374151;
        }
        .field span {
            color: #1f2937;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>طلب موظف جديد</h1>
        </div>
        
        <p>مرحبًا،</p>
        
        <p>تم تقديم طلب موظف جديد من شركة <strong>{{ $company->name }}</strong>. التفاصيل كما يلي:</p>
        
        <div class="request-info">
            <div class="field">
                <label>رقم الطلب:</label> <span>{{ $request->code }}</span>
            </div>
            
            <div class="field">
                <label>اسم الشركة:</label> <span>{{ $company->name }}</span>
            </div>
            
            <div class="field">
                <label>البريد الإلكتروني:</label> <span>{{ $company->email }}</span>
            </div>
            
            <div class="field">
                <label>المسمى الوظيفي المطلوب:</label> <span>{{ $request->job_title }}</span>
            </div>
            
            <div class="field">
                <label>العدد المطلوب:</label> <span>{{ $request->quantity }}</span>
            </div>
            
            @if($request->note)
            <div class="field">
                <label>ملاحظات إضافية:</label>
                <p style="background-color: white; padding: 10px; border-radius: 4px; margin: 5px 0;">{{ $request->note }}</p>
            </div>
            @endif
            
            <div class="field">
                <label>تاريخ الطلب:</label> <span>{{ $request->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>
        
        <p>يُرجى مراجعة الطلب والرد عليه في أقرب وقت ممكن من خلال لوحة التحكم الإدارية.</p>
        
        <div class="footer">
            <p>تم إرسال هذا البريد الإلكتروني تلقائيًا من نظام العمل عن بُعد - شركة هدف للتوظيف.</p>
        </div>
    </div>
</body>
</html> 
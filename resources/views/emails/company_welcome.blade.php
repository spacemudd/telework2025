@component('mail::message')
# مرحبًا، {{ $company }}!

شكراً على تعاقدكم مع شركة هدف للتوظيف. لقد تم تأسيس حساب لكم على منصة العمل عن بعد الخاصة بشركة هدف للتوظيف.

@if (!empty($company_code))
رمز الشركة: {{ $company_code }}
@endif

**بيانات الدخول:**
@component('mail::panel')
- البريد الإلكتروني: {{ $email }}
@if (!empty($password))
- كلمة المرور: {{ $password }}
@endif
@endcomponent

@component('mail::button', ['url' => url('/login')])
دخول النظام
@endcomponent

في حال وجود أي استفسارات أو مشاكل تقنية، يُرجى التواصل مع فريق الدعم.

مع تحيات،
فريق هدف للتوظيف
@endcomponent

@component('mail::message')
<div style="direction: rtl; text-align: right; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
# مرحبًا بكم في منصة العمل عن بُعد

تمت دعوتكم للانضمام إلى منصة العمل عن بُعد الخاصة بـ {{ $companyName }}.

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
</div>
@endcomponent

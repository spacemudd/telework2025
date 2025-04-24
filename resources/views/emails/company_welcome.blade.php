@component('mail::message')
# مرحبًا، {{ $company }}!

شكراً على تعاقدكم مع شركة هدف للتوظيف. لقد تم تأسيس حساب لكم على منصة العمل عن بعد الخاصة بشركة هدف للتوظيف.

**بيانات الدخول:**
@component('mail::panel')
- البريد الإلكتروني: {{ $email }}
- كلمة المرور: {{ $password }}
@endcomponent

@component('mail::button', ['url' => url('/login')])
دخول النظام
@endcomponent

مع تحيات،
فريق هدف للتوظيف
@endcomponent

@component('mail::message')
# تقرير المهام اليومي - {{ $company->name }}
{{ \Carbon\Carbon::parse($yesterday)->translatedFormat('l j F Y') }}

## ملخص النشاط اليومي

@component('mail::table')
| نوع النشاط     | العدد         |
|:-------------:|:-------------:|
| مهام جديدة    | {{ $statistics['new'] }} |
| مهام محدثة    | {{ $statistics['updated'] }} |
| مهام مكتملة   | {{ $statistics['completed'] }} |
@endcomponent

تم إرفاق تقرير مفصل بصيغة CSV يحتوي على جميع المهام وتفاصيلها.

مع تحيات،<br>
{{ config('app.name') }}
@endcomponent

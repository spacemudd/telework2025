@component('mail::message')
# New Enterprise Contact Form Submission

A new enterprise contact form has been submitted with the following details:

**Contact Information:**
- **Name:** {{ $data['name'] }}
- **Company:** {{ $data['company_name'] }}
- **Email:** {{ $data['email'] }}
- **Phone:** {{ $data['phone'] }}
- **Company Size:** {{ $data['employees_count'] }} employees

**Message:**
{{ $data['message'] }}

@component('mail::button', ['url' => config('app.url')])
View in Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 
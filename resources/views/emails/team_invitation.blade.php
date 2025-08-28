<x-mail::message>
# {{ __('words.team_invitation_greeting') }}

{{ __('words.team_invitation_intro', ['company' => $company->name, 'role' => __('words.' . $role)]) }}

{{ __('words.team_invitation_account_details') }}

**{{ __('words.email') }}:** {{ $email }}  
**{{ __('words.password') }}:** {{ $password }}

{{ __('words.team_invitation_login_prompt') }}

<x-mail::button :url="route('login')">
{{ __('words.task_assigned_login_button') }}
</x-mail::button>

{{ __('words.team_invitation_note') }}

{{ __('words.team_invitation_regards') }}

</x-mail::message>

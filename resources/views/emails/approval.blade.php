@component('mail::message')
# Approval Required

Action: **{{ ucfirst(str_replace('_', ' ', $approval->action)) }}**

Please review and choose an action:

@component('mail::button', ['url' => route('approval.approve', $approval->approval_token)])
Approve
@endcomponent

@component('mail::button', ['url' => route('approval.reject', $approval->approval_token), 'color' => 'error'])
Reject
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent

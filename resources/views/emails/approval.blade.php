@component('mail::message')
# Approval Required

Action: **{{ ucfirst(str_replace('_', ' ', $approval->action)) }}**

Please click below to approve and execute this action.

@component('mail::button', ['url' => route('approval.process', ['token' => $approval->approval_token])])
Approve Action
@endcomponent

If you did not request this, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

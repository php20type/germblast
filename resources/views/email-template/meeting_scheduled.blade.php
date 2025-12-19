@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Meeting Scheduled — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello,
</p>

<p style="font-size: 16px; line-height: 24px;">
    A new meeting has been successfully scheduled. Below are the meeting details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Meeting Name:</strong> {{ $data['meeting_name'] }} <br>
    <strong>Date:</strong> {{ $data['date'] }} <br>
    <strong>Time:</strong> {{ $data['start_time'] }} - {{ $data['end_time'] }} <br>
    <strong>Scheduled By:</strong> {{ $data['created_by'] }} <br>
</p>

@component('mail::button', ['url' => config('app.url') . '/admin/schedule/meeting'])
View Meetings
@endcomponent

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated email. Please do not reply.
@endcomponent

@endcomponent

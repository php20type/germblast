@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">New Time Off Request Submitted — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello {{ $data['admin_name'] }},
</p>

<p style="font-size: 16px; line-height: 24px;">
    A new time off request has been submitted by an employee.
    Below are the details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Employee:</strong> {{ $data['employee_name'] }} <br>
    <strong>Date Range:</strong> {{ $data['start_date'] }} to {{ $data['end_date'] }} <br>
    <strong>Duration:</strong> {{ $data['duration_days'] }} {{ Str::plural('Day', $data['duration_days']) }} <br>
    <strong>Reason:</strong> {{ $data['reason'] }} <br>
</p>

@component('mail::button', ['url' => config('app.url') . "/admin/hr/time-off"])
Review Requests
@endcomponent


<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent

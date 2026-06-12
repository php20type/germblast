@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Time Off Request Update — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello {{ $data['employee_name'] }},
</p>

<p style="font-size: 16px; line-height: 24px;">
    Your time off request has been updated.
    Below are the details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Date Range:</strong> {{ $data['start_date'] }} to {{ $data['end_date'] }} <br>
    <strong>Duration:</strong> {{ $data['duration_days'] }} {{ Str::plural('Day', $data['duration_days']) }} <br>
    <strong>Status:</strong> <span style="text-transform: uppercase; font-weight: bold; color: {{ $data['status'] === 'approved' ? '#10b981' : '#ef4444' }};">{{ $data['status'] }}</span> <br>
    <strong>Admin Notes:</strong> {{ $data['admin_notes'] }} <br>
</p>

@component('mail::button', ['url' => config('app.url') . "/admin/hr/time-off"])
View My Requests
@endcomponent


<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent

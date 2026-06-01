@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Service Scheduled Today — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello {{ $data['rep_name'] }},
</p>

<p style="font-size: 16px; line-height: 24px;">
    This is a friendly reminder that a GermBlast Service Order under your lead is scheduled for today!
    Below are the details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Order No:</strong> {{ $data['order_no'] }} <br>
    <strong>Service:</strong> {{ $data['service_name'] }} <br>
    <strong>Scheduled Start:</strong> {{ $data['start_time'] }} <br>
    <strong>Scheduled End:</strong> {{ $data['end_time'] }} <br>
</p>

@component('mail::button', ['url' => config('app.url') . "/admin/lead/service/fulfill-order/{$data['order_id']}"])
View Order
@endcomponent

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent

@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Service Order Unassignment — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello {{ $data['staff_name'] }},
</p>

<p style="font-size: 16px; line-height: 24px;">
    You have been unassigned from a service order in GermBlast.
    Below are the order details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Order No:</strong> {{ $data['order_no'] }} <br>
    <strong>Service:</strong> {{ $data['service_name'] }} <br>
    <strong>Scheduled Start:</strong> {{ $data['start_time'] }} <br>
    <strong>Scheduled End:</strong> {{ $data['end_time'] }} <br>
</p>

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent

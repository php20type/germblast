@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">New Service Note Added — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello {{ $data['sales_name'] }},
</p>

<p style="font-size: 16px; line-height: 24px;">
    A new service note has been added to Order <strong>#{{ $data['order_no'] }}</strong> ({{ $data['service_name'] }}) by <strong>{{ $data['added_by'] }}</strong>:
</p>

<blockquote style="margin: 20px 0; padding: 10px 20px; border-left: 5px solid #005a9c; background-color: #f9f9f9; font-style: italic;">
    {{ $data['notes'] }}
</blockquote>

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

@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Service Invoice — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Dear Customer,
</p>

<p style="font-size: 16px; line-height: 24px;">
    {{ $data['email_message'] }}
</p>

<hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

<p style="font-size: 16px; line-height: 24px;">
    <strong>Invoice Number:</strong> {{ $data['invoice_no'] }} <br>
    <strong>Order Number:</strong> {{ $data['order_no'] }} <br>
    <strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($data['invoice_date'])->format('jS F Y') }} <br>
    <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($data['due_date'])->format('jS F Y') }} <br>
    <strong>Customer:</strong> {{ $data['company_name'] }} <br>
</p>

<h3 style="margin-top: 20px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Line Items</h3>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;">
    <thead>
        <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 8px; text-align: left;">Item Description</th>
            <th style="padding: 8px; text-align: center; width: 80px;">Qty</th>
            <th style="padding: 8px; text-align: right; width: 100px;">Price</th>
            <th style="padding: 8px; text-align: right; width: 120px;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['items'] as $item)
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 8px; text-align: left;">{{ $item['type'] }}</td>
                <td style="padding: 8px; text-align: center;">{{ $item['qty'] }}</td>
                <td style="padding: 8px; text-align: right;">${{ number_format($item['price'], 2) }}</td>
                <td style="padding: 8px; text-align: right; font-weight: bold;">${{ number_format($item['total'], 2) }}</td>
            </tr>
        @endforeach
        <tr style="background-color: #f8f9fa;">
            <td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Amount Due:</td>
            <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 16px; color: #dc3545;">${{ number_format($data['total_amount'], 2) }}</td>
        </tr>
    </tbody>
</table>

@if(!empty($data['notes']))
<p style="font-size: 14px; line-height: 20px; background-color: #f8f9fa; padding: 12px; border-left: 4px solid #ffb81c; border-radius: 4px; margin-top: 15px;">
    <strong>Notes:</strong><br>
    {{ $data['notes'] }}
</p>
@endif

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thank you for your business!
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
Infection Controls, Inc. — 1414 Avenue J, Lubbock, TX 79401<br>
This is an automated notification.
@endcomponent

@endcomponent

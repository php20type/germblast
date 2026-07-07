@component('mail::message')

{{-- Logo --}}
<div style="text-align: left; margin-bottom: 24px; border-bottom: 3px solid #ffb81c; padding-bottom: 16px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width: 160px; height: auto;">
</div>

<h2 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1e293b; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 16px; line-height: 1.4;">
    Service Invoice — GermBlast
</h2>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 16px;">
    Dear Customer,
</p>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 24px;">
    {{ $data['email_message'] }}
</p>

<hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 24px 0;">

<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 14px; line-height: 1.6; color: #334155;">
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 140px; vertical-align: top;">Invoice Number:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['invoice_no'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 140px; vertical-align: top;">Order Number:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['order_no'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 140px; vertical-align: top;">Invoice Date:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ \Carbon\Carbon::parse($data['invoice_date'])->format('jS F Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 140px; vertical-align: top;">Due Date:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ \Carbon\Carbon::parse($data['due_date'])->format('jS F Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 140px; vertical-align: top;">Customer:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['company_name'] }}</td>
        </tr>
    </table>
</div>

<h3 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1e293b; font-size: 16px; font-weight: 700; margin-top: 24px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Line Items</h3>

<div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px; color: #334155;">
        <thead>
            <tr style="background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #475569;">Item Description</th>
                <th style="padding: 12px 16px; text-align: center; width: 80px; font-weight: 600; color: #475569;">Qty</th>
                <th style="padding: 12px 16px; text-align: right; width: 100px; font-weight: 600; color: #475569;">Price</th>
                <th style="padding: 12px 16px; text-align: right; width: 120px; font-weight: 600; color: #475569;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['items'] as $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 16px; text-align: left;">{{ $item['type'] }}</td>
                    <td style="padding: 12px 16px; text-align: center;">{{ $item['qty'] }}</td>
                    <td style="padding: 12px 16px; text-align: right;">${{ number_format($item['price'], 2) }}</td>
                    <td style="padding: 12px 16px; text-align: right; font-weight: 600; color: #0f172a;">${{ number_format($item['total'], 2) }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #f8fafc; font-weight: 700; border-top: 2px solid #e2e8f0;">
                <td colspan="3" style="padding: 12px 16px; text-align: right; color: #475569;">Amount Due:</td>
                <td style="padding: 12px 16px; text-align: right; font-size: 16px; color: #ef4444;">${{ number_format($data['total_amount'], 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>

@if(!empty($data['notes']))
<div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; line-height: 20px; background-color: #fef9c3; padding: 16px; border-left: 4px solid #eab308; border-radius: 6px; color: #713f12; margin-top: 20px; margin-bottom: 24px;">
    <strong style="color: #854d0e;">Notes:</strong><br>
    {{ $data['notes'] }}
</div>
@endif

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-top: 24px; margin-bottom: 24px;">
    Thank you for your business!
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
Infection Controls, Inc. — 1414 Avenue J, Lubbock, TX 79401<br>
This is an automated notification.
@endcomponent

@endcomponent

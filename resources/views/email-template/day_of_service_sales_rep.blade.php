@component('mail::message')

{{-- Logo --}}
<div style="text-align: left; margin-bottom: 24px; border-bottom: 3px solid #ffb81c; padding-bottom: 16px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width: 160px; height: auto;">
</div>

<h2 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1e293b; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 16px; line-height: 1.4;">
    Service Scheduled Today — GermBlast
</h2>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 16px;">
    Hello {{ $data['rep_name'] }},
</p>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 20px;">
    This is a friendly reminder that a GermBlast Service Order under your lead is scheduled for today! Below are the details:
</p>

<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 14px; line-height: 1.6; color: #334155;">
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Order No:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['order_no'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Service:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['service_name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Scheduled Start:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['start_time'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Scheduled End:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['end_time'] }}</td>
        </tr>
    </table>
</div>

<table border="0" cellpadding="0" cellspacing="0" style="margin-top: 24px; margin-bottom: 24px;">
    <tr>
        <td align="center" style="border-radius: 6px; background-color: #ffb81c;">
            <a href="{{ config('app.url') }}/admin/lead/service/service-dashboard/{{ $data['order_id'] }}" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 700; color: #1e293b; text-decoration: none; padding: 12px 24px; border-radius: 6px; border: 1px solid #ffb81c; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(255, 184, 28, 0.25);">
                View Order
            </a>
        </td>
    </tr>
</table>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-top: 24px; margin-bottom: 24px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent

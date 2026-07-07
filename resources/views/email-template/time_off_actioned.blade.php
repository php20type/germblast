@component('mail::message')

{{-- Logo --}}
<div style="text-align: left; margin-bottom: 24px; border-bottom: 3px solid #ffb81c; padding-bottom: 16px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width: 160px; height: auto;">
</div>

<h2 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1e293b; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 16px; line-height: 1.4;">
    Time Off Request Update — GermBlast
</h2>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 16px;">
    Hello {{ $data['employee_name'] }},
</p>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 20px;">
    Your time off request has been updated. Below are the details:
</p>

<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 14px; line-height: 1.6; color: #334155;">
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Date Range:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['start_date'] }} to {{ $data['end_date'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Duration:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['duration_days'] }} {{ Str::plural('Day', $data['duration_days']) }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Status:</td>
            <td style="padding: 4px 0; font-weight: 500;">
                <span style="text-transform: uppercase; font-weight: 700; font-size: 13px; color: {{ $data['status'] === 'approved' ? '#10b981' : '#ef4444' }}; padding: 2px 8px; border-radius: 4px; background-color: {{ $data['status'] === 'approved' ? '#dcfce7' : '#fee2e2' }}; border: 1px solid {{ $data['status'] === 'approved' ? '#bbf7d0' : '#fecaca' }};">
                    {{ $data['status'] }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Admin Notes:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['admin_notes'] }}</td>
        </tr>
    </table>
</div>

<table border="0" cellpadding="0" cellspacing="0" style="margin-top: 24px; margin-bottom: 24px;">
    <tr>
        <td align="center" style="border-radius: 6px; background-color: #ffb81c;">
            <a href="{{ config('app.url') }}/admin/hr/time-off" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 700; color: #1e293b; text-decoration: none; padding: 12px 24px; border-radius: 6px; border: 1px solid #ffb81c; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(255, 184, 28, 0.25);">
                View My Requests
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

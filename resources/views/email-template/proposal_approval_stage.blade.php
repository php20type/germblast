@component('mail::message')

{{-- Logo --}}
<div style="text-align: left; margin-bottom: 24px; border-bottom: 3px solid #ffb81c; padding-bottom: 16px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width: 160px; height: auto;">
</div>

<h2 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1e293b; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 16px; line-height: 1.4;">
    Survey Proposal Ready for Review — GermBlast
</h2>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 16px;">
    Hello,
</p>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 20px;">
    The lead <strong>{{ $data['lead_name'] }}</strong> has reached the <strong>Proposal Approval</strong> stage. The survey proposal is now ready for your review. Below are the details:
</p>

<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 14px; line-height: 1.6; color: #334155;">
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Lead:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['lead_name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Company:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['company_name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Status:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ ucfirst(str_replace('_', ' ', $data['status'])) }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #64748b; width: 130px; vertical-align: top;">Updated By:</td>
            <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $data['updated_by'] }}</td>
        </tr>
    </table>
</div>

<p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #4b5563; line-height: 1.6; margin-bottom: 16px;">
    Please review the survey proposal using the link below:
</p>

<table border="0" cellpadding="0" cellspacing="0" style="margin-top: 16px; margin-bottom: 24px; display: inline-block; margin-right: 12px;">
    <tr>
        <td align="center" style="border-radius: 6px; background-color: #ffb81c;">
            <a href="{{ $data['survey_proposal_link'] }}" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 700; color: #1e293b; text-decoration: none; padding: 12px 24px; border-radius: 6px; border: 1px solid #ffb81c; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(255, 184, 28, 0.25);">
                View Survey Proposal
            </a>
        </td>
    </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" style="margin-top: 16px; margin-bottom: 24px; display: inline-block;">
    <tr>
        <td align="center" style="border-radius: 6px; background-color: #e2e8f0; border: 1px solid #cbd5e1;">
            <a href="{{ config('app.url') }}/admin/lead/{{ $data['lead_id'] }}" target="_blank" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 700; color: #475569; text-decoration: none; padding: 12px 24px; border-radius: 6px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px;">
                View Lead Details
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
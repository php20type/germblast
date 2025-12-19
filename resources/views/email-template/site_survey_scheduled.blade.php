@component('mail::message')

<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Site Survey Scheduled — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello,
</p>

<p style="font-size: 16px; line-height: 24px;">
    A site survey has been scheduled for this lead.
    Below are the details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Lead:</strong> {{ $data['lead_name'] }} <br>
    <strong>Company:</strong> {{ $data['company_name'] }} <br>
    <strong>Date:</strong> {{ \Carbon\Carbon::parse($data['scheduled_date'])->format('jS F Y') }} <br>
    <strong>Time:</strong> {{ \Carbon\Carbon::parse($data['scheduled_time'])->format('g:i A') }} <br>
</p>

@component('mail::button', ['url' => config('app.url') . "/admin/leads/{$data['lead_id']}"])
View Lead
@endcomponent

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent

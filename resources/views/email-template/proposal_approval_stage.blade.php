@component('mail::message')

<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">Survey Proposal Ready for Review — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello,
</p>

<p style="font-size: 16px; line-height: 24px;">
    The lead <strong>{{ $data['lead_name'] }}</strong> has reached the <strong>Proposal Approval</strong> stage.
    The survey proposal is now ready for your review.
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Lead:</strong> {{ $data['lead_name'] }} <br>
    <strong>Company:</strong> {{ $data['company_name'] }} <br>
    <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $data['status'])) }} <br>
    <strong>Updated By:</strong> {{ $data['updated_by'] }} <br>
</p>

<p style="font-size: 16px; line-height: 24px;">
    Please review the survey proposal using the link below:
</p>

@component('mail::button', ['url' => $data['survey_proposal_link']])
View Survey Proposal
@endcomponent

@component('mail::button', ['url' => config('app.url') . "/admin/lead/{$data['lead_id']}", 'color' => 'secondary'])
View Lead Details
@endcomponent

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast
This is an automated notification. Please do not reply.
@endcomponent

@endcomponent
@component('mail::message')

{{-- Logo --}}
<p style="text-align:left; margin-bottom: 20px;">
    <img src="{{ config('app.url') }}/public/img/logo/logo.png" alt="GermBlast" style="width:180px;">
</p>

<h2 style="margin-top: 0;">New Company Created — GermBlast</h2>

<p style="font-size: 16px; line-height: 24px;">
    Hello,
</p>

<p style="font-size: 16px; line-height: 24px;">
    A new company has been successfully created in the GermBlast.
    Below are the company details:
</p>

<p style="font-size: 16px; line-height: 24px;">
    <strong>Name:</strong> {{ $data['name'] }} <br>
    <strong>Description:</strong> {{ $data['description'] }} <br>
    <strong>Company Type:</strong> {{ $data['company_type'] }} <br>
    <strong>Industry:</strong> {{ $data['industry'] }} <br>
    <strong>Territory:</strong> {{ $data['territory'] }} <br>
</p>

{{-- @component('mail::button', ['url' => config('app.url') . "/admin/companies/{$data['company_id']}"])
View Company
@endcomponent --}}
@component('mail::button', ['url' => "http://germblast.test/admin/companies/{$data['company_id']}"])
View Company
@endcomponent

<p style="font-size: 16px; line-height: 24px; margin-top: 20px;">
    Thanks
</p>

@component('mail::subcopy')
&copy; {{ date('Y') }} GermBlast<br>
This is an automated email. Please do not reply.
@endcomponent

@endcomponent

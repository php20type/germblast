<?php

namespace App\Services;

use App\Mail\ApprovalMail;
use App\Models\Approval;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApprovalService
{
    /**
     * Create approval request
     */
    public static function request($email, $action, array $data, $redirectUrl = '/')
    {
        $approval = Approval::create([
            'email' => $email,
            'action' => $action,
            'data' => $data,
            'redirect_url' => $redirectUrl,
            'approval_token' => Str::uuid(),
        ]);

        Mail::to($email)->send(new ApprovalMail($approval));

        return $approval;
    }

    public static function approve($token)
    {
        $approval = Approval::where('approval_token', $token)->first();

        if (! $approval) {
            return ['status' => false, 'message' => 'Invalid or expired approval link'];
        }

        if ($approval->is_approved || $approval->is_rejected) {
            return ['status' => false, 'message' => 'This approval request has already been processed'];
        }

        $approval->update(['is_approved' => true]);

        // Execute action
        self::handleAction($approval);

        return ['status' => true, 'message' => 'Request approved. Company created successfully!'];
    }

    private static function handleAction($approval)
    {
        switch ($approval->action) {

            case 'company_create':
                self::createCompany($approval->data);
                break;

            default:
                \Log::warning("Unhandled approval action: {$approval->action}");
        }
    }

    private static function createCompany($data)
    {
        $req = $data['request_data'];

        // CREATE COMPANY
        $company = \App\Models\Company::create([
            'user_id' => $req['user_id'],
            'name' => $req['name'],
            'description' => $req['description'],
            'company_type_id' => $req['company_type_id'],
            'industry_id' => $req['industry_id'],
            'territory_id' => $req['territory_id'],
        ]);

        // EMAIL
        if (! empty($req['email'])) {
            \App\Models\CompanyEmail::create([
                'company_id' => $company->id,
                'email' => $req['email'],
            ]);
        }

        // PHONE
        if (! empty($req['phone'])) {
            \App\Models\CompanyPhone::create([
                'company_id' => $company->id,
                'phone' => $req['phone'],
            ]);
        }

        // ADDRESS
        if (! empty($req['address'])) {
            \App\Models\CompanyAddress::create([
                'company_id' => $company->id,
                'address' => $req['address'],
            ]);
        }

        // URL
        if (! empty($req['url'])) {
            \App\Models\CompanyUrl::create([
                'company_id' => $company->id,
                'url' => $req['url'],
            ]);
        }

        // PEOPLE
        if (! empty($req['people_id'])) {
            \App\Models\CompanyPeople::create([
                'company_id' => $company->id,
                'people_id' => $req['people_id'],
            ]);
        }

        // TAG
        if (! empty($req['tag_id'])) {
            \App\Models\CompanyTag::create([
                'company_id' => $company->id,
                'tag_id' => $req['tag_id'],
            ]);
        }
    }

    public static function reject($token)
    {
        $approval = Approval::where('approval_token', $token)->first();

        if (! $approval) {
            return ['status' => false, 'message' => 'Invalid or expired approval link'];
        }

        if ($approval->is_approved || $approval->is_rejected) {
            return ['status' => false, 'message' => 'This approval request has already been processed'];
        }

        $approval->update(['is_rejected' => true]);

        return ['status' => true, 'message' => 'Request rejected'];
    }
}

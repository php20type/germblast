<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Jobs\SendSMSJob;

class NotificationService
{
    private $testEmail = 'febev88675@bablace.com';

    private $testPhone;

    public function __construct()
    {
        $this->testPhone = env('TWILIO_FROM');   // Fetch from .env
    }

    public function companyCreated($company)
    {
        // Email Notification
        SendEmailJob::dispatch(
            $this->testEmail,
            'company_created',
            [
                'name' => $company->name,
                'description' => $company->description,
                'company_type' => $company->companyType->type ?? 'N/A',
                'industry' => $company->industry->name ?? 'N/A',
                'territory' => $company->territory->name ?? 'N/A',
            ]
        );
        // SMS Notification
        //  SendSMSJob::dispatch(
        //     $this->testPhone,
        //     "New company created: {$company->name}"
        // );
    }

    // =======================
    // THIS IS FOR SENDING TO USER ROLE (e.g., all Sales Managers)
    // =======================
    // public function companyCreated($company)
    // {
    //     // Fetch all Sales Managers
    //     $salesManagers = \App\Models\User::role('Sales Manager')->get();

    //     foreach ($salesManagers as $manager) {

    //         // EMAIL
    //         SendEmailJob::dispatch(
    //             $manager->email,
    //             'company_created',
    //             [
    //                 'name' => $company->name,
    //                 'description' => $company->description,
    //                 'company_type' => $company->companyType->type ?? 'N/A',
    //                 'industry' => $company->industry->name ?? 'N/A',
    //                 'territory' => $company->territory->name ?? 'N/A',
    //             ]
    //         );

    //         // SMS
    //         SendSMSJob::dispatch(
    //             env('TWILIO_FROM'), // or $manager->phone if available
    //             "New company created: {$company->name}"
    //         );
    //     }
    // }

    public function leadCreated($lead)
    {
        // Email Notification
        SendEmailJob::dispatch(
            $this->testEmail,
            'lead_created',
            [
                'lead_name' => $lead->name,
                'assignee' => $lead->assignee->name ?? 'Unassigned',
                'close_date' => $lead->close_date,
                'confidence' => $lead->confidence,
            ]
        );

        // SMS Notification
        // SendSMSJob::dispatch(
        //     $this->testPhone,
        //     "A new lead has been created: {$lead->name}"
        // );
    }

    public function leadAssigned($lead)
    {
        // Email Notification
        SendEmailJob::dispatch(
            $this->testEmail,
            'lead_assigned',
            [
                'lead_name' => $lead->name,
                'assignee' => $lead->assignee->name ?? 'Unassigned',
            ]
        )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit

        // SMS Notification
        //  SendSMSJob::dispatch(
        //     $this->testPhone,
        //     "Lead assigned: {$lead->name}"
        // )->delay(now()->addSeconds(12)); // same delay as email
    }
}

<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Jobs\SendSMSJob;
use Carbon\Carbon;

class NotificationService
{
    private $testEmail = 'febev88675@bablace.com';

    private $testPhone;

    private bool $sendEmail;

    private bool $sendSMS;

    public function __construct()
    {
        $this->testPhone = env('TWILIO_FROM');
        $this->sendEmail = true;
        $this->sendSMS = false;
    }

    public function companyCreated($company)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'company_created',
                [
                    'company_id' => $company->id,
                    'name' => $company->name,
                    'description' => $company->description,
                    'company_type' => $company->companyType->type ?? 'N/A',
                    'industry' => $company->industry->name ?? 'N/A',
                    'territory' => $company->territory->name ?? 'N/A',
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "New company created: {$company->name}"
            );
        }
    }

    // This should be sent to sales rep and manager
    public function leadCreated($lead)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'lead_created',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'company_name' => $lead->companies->pluck('name')->join(', '),
                    'assignee' => $lead->assignee->name ?? 'Unassigned',
                    'close_date' => $lead->close_date,
                    'confidence' => $lead->confidence,
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "A new lead has been created: {$lead->name}"
            );
        }
    }

    // This should be sent to assingee only
    public function leadAssigned($lead)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'lead_assigned',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'assignee' => $lead->assignee->name ?? 'Unassigned',
                    'company_name' => $lead->companies->pluck('name')->join(', '),
                ]
            )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Lead assigned: {$lead->name}"
            )->delay(now()->addSeconds(12)); // same delay as email
        }
    }

    public function initialMeetingScheduled($lead, $date)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'initial_meeting_scheduled',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'company_name' => $lead->companies->pluck('name')->join(', '),
                    'scheduled_at' => $date,
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Initial Meeting Scheduled for Lead: {$lead->name} at {$date}"
            );
        }
    }

    public function initialMeetingCompleted($lead)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'initial_meeting_completed',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'company_name' => $lead->companies->pluck('name')->join(', '),
                    'completed_by' => auth()->user()->name,
                    'completed_at' => now()->format('Y-m-d H:i:s'),
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Initial Meeting Completed for Lead: {$lead->name}"
            );
        }
    }

    public function siteSurveyScheduled($lead, $stage)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'site_survey_scheduled',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'company_name' => $lead->companies->pluck('name')->join(', '),

                    // Formatted like Initial Meeting
                    'scheduled_date' => Carbon::parse($stage->site_survey_scheduled_at)->format('Y-m-d'),
                    'scheduled_time' => Carbon::parse($stage->site_survey_scheduled_at)->format('H:i:s'),
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Site Survey Scheduled for Lead: {$lead->name}"
            );
        }
    }

    public function siteSurveyCompleted($lead, $stage)
    {
        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'site_survey_completed',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'company_name' => $lead->companies->pluck('name')->join(', '),

                    // Formatted fields same as Initial Meeting Completed
                    'completed_date' => Carbon::parse($stage->site_survey_completed_at)->format('Y-m-d'),
                    'completed_time' => Carbon::parse($stage->site_survey_completed_at)->format('H:i:s'),

                    'completed_by' => $stage->siteSurveyCompletedBy->name ?? 'N/A',
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Site Survey Completed for Lead: {$lead->name}"
            );
        }
    }

    public function meetingScheduled($meeting)
    {
        $startTime = Carbon::parse($meeting->start_time)->format('h:i A');
        $endTime = Carbon::parse($meeting->end_time)->format('h:i A');

        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'meeting_scheduled',
                [
                    'meeting_name' => $meeting->name,
                    'date' => $meeting->date,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'created_by' => $meeting->user->name,
                ]
            )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "New meeting scheduled: {$meeting->name} on {$meeting->date} ({$startTime} - {$endTime}) by {$meeting->user->name}"
            )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
        }
    }

    public function meetingUpdated($meeting)
    {
        $startTime = Carbon::parse($meeting->start_time)->format('h:i A');
        $endTime = Carbon::parse($meeting->end_time)->format('h:i A');

        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'meeting_updated',
                [
                    'meeting_name' => $meeting->name,
                    'date' => $meeting->date,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'updated_by' => $meeting->user->name,
                ]
            )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Meeting Updated: {$meeting->name} on {$meeting->date} ({$startTime} - {$endTime}) by {$meeting->user->name}"
            )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
        }
    }

    public function staffAssignedToOrder($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $user->email,
                'staff_assigned_to_order',
                [
                    'staff_name' => $user->name,
                    'order_no' => $order->order_no ?? 'N/A',
                    'service_name' => $service->service_name ?? 'N/A',
                    'start_time' => $slot->scheduled_start_time,
                    'end_time' => $slot->scheduled_end_time,
                    'order_id' => $order->id,
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "You have been assigned to Order #{$order->order_no} — {$service->service_name}"
            );
        }
    }

    public function proposalApprovalStage($lead, $surveyProposal)
    {
        // Generate the survey proposal link
        $surveyProposalLink = route('admin.lead.survey.proposal', $lead->id);

        // Get company name - handle both direct and many-to-many relationships
        $companyName = $lead->company->name;

        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $this->testEmail,
                'proposal_approval_stage',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'company_name' => $companyName,
                    'survey_proposal_link' => $surveyProposalLink,
                    'status' => 'pending_review',
                    'updated_by' => auth()->user()->name,
                ]
            );
        }

        if ($this->sendSMS) {
            SendSMSJob::dispatch(
                $this->testPhone,
                "Proposal Approval Stage reached for Lead: {$lead->name}. Survey Proposal Link: {$surveyProposalLink}"
            );
        }
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

}

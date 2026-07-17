<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Jobs\SendSMSJob;
use Carbon\Carbon;
use App\Models\SystemNotification;

class NotificationService
{
    private bool $sendEmail;

    private bool $sendSMS;

    public function __construct()
    {
        $this->sendEmail = false;
        $this->sendSMS = false;
    }

    /**
     * Send an in-app notification to a specific user.
     */
    public function sendInApp(
        $user,
        $title,
        $message,
        $module = null,
        $referenceId = null,
        $type = null,
        $referenceType = null,
        $createdBy = null
    ) {
        $userId = is_object($user) ? $user->id : $user;

        return SystemNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'module' => $module,
            'type' => $type,
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'is_read' => false,
            'created_by' => $createdBy ?? (auth()->check() ? auth()->id() : null),
        ]);
    }

    public function companyCreated($company)
    {
        $salesManagers = \App\Models\User::all()->filter(fn($u) => $u->isSalesManager());

        foreach ($salesManagers as $manager) {
            if ($this->sendEmail && $manager->email) {
                SendEmailJob::dispatch(
                    $manager->email,
                    'company_created',
                    [
                        'company_id' => $company->id,
                        'name' => $company->name,
                        'description' => $company->description,
                        'company_type' => $company->companyType?->type ?? 'N/A',
                        'industry' => $company->industry?->name ?? 'N/A',
                        'territory' => $company->territory?->name ?? 'N/A',
                    ]
                );
            }

            if ($this->sendSMS && $manager->cell_phone) {
                SendSMSJob::dispatch(
                    $manager->cell_phone,
                    "New company created: {$company->name}"
                );
            }

            $this->sendInApp(
                $manager,
                'New Company Created',
                "A new company '{$company->name}' has been created.",
                'companies',
                $company->id,
                'created',
                get_class($company)
            );
        }
    }

    // This should be sent to sales rep and manager
    public function leadCreated($lead)
    {
        $recipients = collect();

        if ($lead->assignee) {
            $recipients->push($lead->assignee);
        }

        $salesManagers = \App\Models\User::all()->filter(fn($u) => $u->isSalesManager());
        foreach ($salesManagers as $manager) {
            $recipients->push($manager);
        }

        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
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

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "A new lead has been created: {$lead->name}"
                );
            }

            $this->sendInApp(
                $recipient,
                'New Lead Created',
                "A new lead '{$lead->name}' has been created.",
                'leads',
                $lead->id,
                'created',
                get_class($lead)
            );
        }
    }

    // This should be sent to assingee only
    public function leadAssigned($lead)
    {
        $assignee = $lead->assignee;
        if (!$assignee) return;

        if ($this->sendEmail && $assignee->email) {
            SendEmailJob::dispatch(
                $assignee->email,
                'lead_assigned',
                [
                    'lead_id' => $lead->id,
                    'lead_name' => $lead->name,
                    'assignee' => $assignee->name,
                    'company_name' => $lead->companies->pluck('name')->join(', '),
                ]
            )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
        }

        if ($this->sendSMS && $assignee->cell_phone) {
            SendSMSJob::dispatch(
                $assignee->cell_phone,
                "Lead assigned: {$lead->name}"
            )->delay(now()->addSeconds(12)); // same delay as email
        }

        $companyName = $lead->companies->pluck('name')->join(', ') ?: 'Unknown Company';
        $this->sendInApp(
            $assignee,
            'Lead Assigned',
            "You have been assigned a new lead: {$lead->name} ({$companyName})",
            'leads',
            $lead->id,
            'assigned',
            get_class($lead)
        );
    }

    public function initialMeetingScheduled($lead, $date)
    {
        $recipients = collect();
        if ($lead->assignee) {
            $recipients->push($lead->assignee);
        }
        if ($lead->creator) {
            $recipients->push($lead->creator);
        }
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'initial_meeting_scheduled',
                    [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'company_name' => $lead->companies->pluck('name')->join(', '),
                        'scheduled_at' => $date,
                    ]
                );
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "Initial Meeting Scheduled for Lead: {$lead->name} at {$date}"
                );
            }

            $companyName = $lead->companies->pluck('name')->join(', ') ?: 'Unknown Company';
            $this->sendInApp(
                $recipient,
                'Meeting Scheduled',
                "An initial meeting has been scheduled for lead {$lead->name} ({$companyName}) at {$date}.",
                'leads',
                $lead->id,
                'meeting_scheduled',
                get_class($lead)
            );
        }
    }

    public function initialMeetingCompleted($lead)
    {
        $recipients = collect();
        if ($lead->assignee) {
            $recipients->push($lead->assignee);
        }
        if ($lead->creator) {
            $recipients->push($lead->creator);
        }
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'initial_meeting_completed',
                    [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'company_name' => $lead->companies->pluck('name')->join(', '),
                        'completed_by' => auth()->user()->name ?? 'System',
                        'completed_at' => now()->format('Y-m-d H:i:s'),
                    ]
                );
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "Initial Meeting Completed for Lead: {$lead->name}"
                );
            }

            $companyName = $lead->companies->pluck('name')->join(', ') ?: 'Unknown Company';
            $this->sendInApp(
                $recipient,
                'Meeting Completed',
                "The initial meeting for lead {$lead->name} ({$companyName}) has been completed.",
                'leads',
                $lead->id,
                'meeting_completed',
                get_class($lead)
            );
        }
    }

    public function siteSurveyScheduled($lead, $stage)
    {
        $recipients = collect();
        if ($lead->assignee) {
            $recipients->push($lead->assignee);
        }
        if ($lead->creator) {
            $recipients->push($lead->creator);
        }
        if ($stage->siteSurveyCompletedBy) {
            $recipients->push($stage->siteSurveyCompletedBy);
        }
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'site_survey_scheduled',
                    [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'company_name' => $lead->companies->pluck('name')->join(', '),
                        'scheduled_date' => Carbon::parse($stage->site_survey_scheduled_at)->format('Y-m-d'),
                        'scheduled_time' => Carbon::parse($stage->site_survey_scheduled_at)->format('H:i:s'),
                    ]
                );
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "Site Survey Scheduled for Lead: {$lead->name}"
                );
            }

            $companyName = $lead->companies->pluck('name')->join(', ') ?: 'Unknown Company';
            $this->sendInApp(
                $recipient,
                'Site Survey Scheduled',
                "A site survey has been scheduled for lead {$lead->name} ({$companyName}).",
                'leads',
                $lead->id,
                'survey_scheduled',
                get_class($lead)
            );
        }
    }

    public function siteSurveyCompleted($lead, $stage)
    {
        $recipients = collect();
        if ($lead->assignee) {
            $recipients->push($lead->assignee);
        }
        if ($lead->creator) {
            $recipients->push($lead->creator);
        }
        if ($stage->siteSurveyCompletedBy) {
            $recipients->push($stage->siteSurveyCompletedBy);
        }
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'site_survey_completed',
                    [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'company_name' => $lead->companies->pluck('name')->join(', '),
                        'completed_date' => Carbon::parse($stage->site_survey_completed_at)->format('Y-m-d'),
                        'completed_time' => Carbon::parse($stage->site_survey_completed_at)->format('H:i:s'),
                        'completed_by' => $stage->siteSurveyCompletedBy->name ?? 'N/A',
                    ]
                );
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "Site Survey Completed for Lead: {$lead->name}"
                );
            }

            $companyName = $lead->companies->pluck('name')->join(', ') ?: 'Unknown Company';
            $this->sendInApp(
                $recipient,
                'Site Survey Completed',
                "The site survey for lead {$lead->name} ({$companyName}) has been completed.",
                'leads',
                $lead->id,
                'survey_completed',
                get_class($lead)
            );
        }
    }

    public function meetingScheduled($meeting)
    {
        $startTime = Carbon::parse($meeting->start_time)->format('h:i A');
        $endTime = Carbon::parse($meeting->end_time)->format('h:i A');

        $recipients = collect();
        if ($meeting->user) {
            $recipients->push($meeting->user);
        }
        if ($meeting->mentionedUsers) {
            foreach ($meeting->mentionedUsers as $u) {
                $recipients->push($u);
            }
        }
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'meeting_scheduled',
                    [
                        'meeting_name' => $meeting->name,
                        'date' => $meeting->date,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'created_by' => $meeting->user->name ?? 'System',
                    ]
                )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "New meeting scheduled: {$meeting->name} on {$meeting->date} ({$startTime} - {$endTime}) by " . ($meeting->user->name ?? 'System')
                )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
            }

            $this->sendInApp(
                $recipient,
                'Calendar Meeting Scheduled',
                "New meeting scheduled: {$meeting->name} on {$meeting->date}.",
                'calendar',
                $meeting->id,
                'meeting_scheduled',
                get_class($meeting)
            );
        }
    }

    public function meetingUpdated($meeting)
    {
        $startTime = Carbon::parse($meeting->start_time)->format('h:i A');
        $endTime = Carbon::parse($meeting->end_time)->format('h:i A');

        $recipients = collect();
        if ($meeting->user) {
            $recipients->push($meeting->user);
        }
        if ($meeting->mentionedUsers) {
            foreach ($meeting->mentionedUsers as $u) {
                $recipients->push($u);
            }
        }
        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'meeting_updated',
                    [
                        'meeting_name' => $meeting->name,
                        'date' => $meeting->date,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'updated_by' => $meeting->user->name ?? 'System',
                    ]
                )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "Meeting Updated: {$meeting->name} on {$meeting->date} ({$startTime} - {$endTime}) by " . ($meeting->user->name ?? 'System')
                )->delay(now()->addSeconds(12)); // MAILTRAP rate-limit
            }

            $this->sendInApp(
                $recipient,
                'Calendar Meeting Updated',
                "The meeting {$meeting->name} has been updated.",
                'calendar',
                $meeting->id,
                'meeting_updated',
                get_class($meeting)
            );
        }
    }

    public function staffAssignedToOrder($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        if ($this->sendEmail && $user->email) {
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

        if ($this->sendSMS && $user->cell_phone) {
            SendSMSJob::dispatch(
                $user->cell_phone,
                "You have been assigned to Order #{$order->order_no} — {$service->service_name}"
            );
        }

        $companyName = $order->service->lead->company->name ?? 'Unknown Company';
        $this->sendInApp(
            $user,
            'Job Assigned',
            "You have been assigned to Order #{$order->order_no} for {$companyName} — {$service->service_name}.",
            'operations',
            $order->id,
            'job_assigned',
            get_class($order)
        );
    }

    public function proposalApprovalStage($lead, $surveyProposal)
    {
        // Generate the survey proposal link
        $surveyProposalLink = route('admin.lead.survey.proposal', $lead->id);

        // Get company name - handle both direct and many-to-many relationships
        $companyName = $lead->company->name ?? '';

        $recipients = collect();
        if ($lead->assignee) {
            $recipients->push($lead->assignee);
        }

        $salesManagers = \App\Models\User::all()->filter(fn($u) => $u->isSalesManager());
        foreach ($salesManagers as $manager) {
            $recipients->push($manager);
        }

        $recipients = $recipients->unique('id');

        foreach ($recipients as $recipient) {
            if ($this->sendEmail && $recipient->email) {
                SendEmailJob::dispatch(
                    $recipient->email,
                    'proposal_approval_stage',
                    [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'company_name' => $companyName,
                        'survey_proposal_link' => $surveyProposalLink,
                        'status' => 'pending_review',
                        'updated_by' => auth()->user()->name ?? 'System',
                    ]
                );
            }

            if ($this->sendSMS && $recipient->cell_phone) {
                SendSMSJob::dispatch(
                    $recipient->cell_phone,
                    "Proposal Approval Stage reached for Lead: {$lead->name}. Survey Proposal Link: {$surveyProposalLink}"
                );
            }

            $this->sendInApp(
                $recipient,
                'Proposal Approval Stage',
                "Proposal Approval Stage reached for Lead: {$lead->name}.",
                'leads',
                $lead->id,
                'proposal_approval',
                get_class($lead)
            );
        }
    }

    public function staffUnassignedFromOrder($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        if ($this->sendEmail && $user->email) {
            SendEmailJob::dispatch(
                $user->email,
                'staff_unassigned_from_order',
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

        if ($this->sendSMS && $user->cell_phone) {
            SendSMSJob::dispatch(
                $user->cell_phone,
                "You have been unassigned from Order #{$order->order_no} — {$service->service_name}"
            );
        }

        $companyName = $order->service->lead->company->name ?? 'Unknown Company';
        $this->sendInApp(
            $user,
            'Job Unassigned',
            "You have been unassigned from Order #{$order->order_no} for {$companyName}.",
            'operations',
            $order->id,
            'job_unassigned',
            get_class($order)
        );
    }

    public function staffMarkedAsLeader($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        if ($this->sendEmail && $user->email) {
            SendEmailJob::dispatch(
                $user->email,
                'staff_marked_as_leader',
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

        if ($this->sendSMS && $user->cell_phone) {
            SendSMSJob::dispatch(
                $user->cell_phone,
                "You have been marked as Leader for Order #{$order->order_no} — {$service->service_name}"
            );
        }

        $companyName = $order->service->lead->company->name ?? 'Unknown Company';
        $this->sendInApp(
            $user,
            'Marked as Leader',
            "You have been marked as Leader for Order #{$order->order_no} ({$companyName}).",
            'operations',
            $order->id,
            'marked_leader',
            get_class($order)
        );
    }

    public function staffUnmarkedAsLeader($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        if ($this->sendEmail && $user->email) {
            SendEmailJob::dispatch(
                $user->email,
                'staff_unmarked_as_leader',
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

        if ($this->sendSMS && $user->cell_phone) {
            SendSMSJob::dispatch(
                $user->cell_phone,
                "You have been unmarked as Leader for Order #{$order->order_no} — {$service->service_name}"
            );
        }

        $companyName = $order->service->lead->company->name ?? 'Unknown Company';
        $this->sendInApp(
            $user,
            'Unmarked as Leader',
            "You have been unmarked as Leader for Order #{$order->order_no} ({$companyName}).",
            'operations',
            $order->id,
            'unmarked_leader',
            get_class($order)
        );
    }

    public function serviceNoteAdded($note)
    {
        $order = $note->serviceOrder;
        if (!$order) return;
        $service = $order->service ?? null;

        // Fetch sales managers and sales reps
        $salesTeam = \App\Models\User::all()->filter(fn($u) => $u->isSalesManager() || $u->isSalesRepresentative());

        foreach ($salesTeam as $member) {
            if ($this->sendEmail && $member->email) {
                SendEmailJob::dispatch(
                    $member->email,
                    'service_note_added',
                    [
                        'sales_name' => $member->name,
                        'order_no' => $order->order_no ?? 'N/A',
                        'service_name' => $service->service_name ?? 'N/A',
                        'added_by' => $note->user->name ?? 'System',
                        'notes' => $note->notes,
                        'order_id' => $order->id,
                    ]
                );
            }

            if ($this->sendSMS && $member->cell_phone) {
                SendSMSJob::dispatch(
                    $member->cell_phone,
                    "New service note added to Order #{$order->order_no} by " . ($note->user->name ?? 'System') . ": {$note->notes}"
                );
            }

            $companyName = $order->service->lead->company->name ?? 'Unknown Company';
            $this->sendInApp(
                $member,
                'Service Note Added',
                "New service note added to Order #{$order->order_no} ({$companyName}) by " . ($note->user->name ?? 'System'),
                'operations',
                $order->id,
                'service_note',
                get_class($order)
            );
        }
    }

    public function dayOfService($slot)
    {
        $order = $slot->serviceOrder;
        if (!$order) return;
        $service = $order->service;
        $lead = $service ? $service->lead : null;

        // 1. Notify Assigned Staff
        if ($slot->staff) {
            foreach ($slot->staff as $staffPivot) {
                $staff = $staffPivot->user;
                if ($staff) {
                    $this->dayOfServiceStaffNotification($staff, $slot);
                }
            }
        }

        // 2. Notify Sales Reps
        $salesReps = collect();
        if ($lead && $lead->assignee) {
            $salesReps->push($lead->assignee);
        }
        if ($lead && $lead->company && $lead->company->salesRep) {
            $salesReps->push($lead->company->salesRep);
        }
        $salesReps = $salesReps->unique('id');

        foreach ($salesReps as $rep) {
            $this->dayOfServiceSalesRepNotification($rep, $slot);
        }
    }

    public function dayOfServiceStaffNotification($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        // Forced Email
        if ($user->email) {
            SendEmailJob::dispatch(
                $user->email,
                'day_of_service_staff',
                [
                    'staff_name' => $user->name,
                    'order_no' => $order->order_no ?? 'N/A',
                    'service_name' => $service->service_name ?? 'N/A',
                    'start_time' => $slot->scheduled_start_time->format('h:i A'),
                    'end_time' => $slot->scheduled_end_time->format('h:i A'),
                    'order_id' => $order->id,
                ]
            );
        }

        // Forced SMS
        if ($user->cell_phone) {
            SendSMSJob::dispatch(
                $user->cell_phone,
                "Reminder: You have a GermBlast Service Order scheduled today! Order #{$order->order_no} ({$service->service_name}) from " . $slot->scheduled_start_time->format('h:i A') . " to " . $slot->scheduled_end_time->format('h:i A') . "."
            );
        }

        $companyName = $order->service->lead->company->name ?? 'Unknown Company';
        $this->sendInApp(
            $user,
            'Service Order Today',
            "Reminder: You have a Service Order scheduled today! Order #{$order->order_no} ({$companyName}).",
            'operations',
            $order->id,
            'service_order_today',
            get_class($order)
        );
    }

    public function dayOfServiceSalesRepNotification($user, $slot)
    {
        $order = $slot->serviceOrder;
        $service = $order->service ?? null;

        // Forced Email
        if ($user->email) {
            SendEmailJob::dispatch(
                $user->email,
                'day_of_service_sales_rep',
                [
                    'rep_name' => $user->name,
                    'order_no' => $order->order_no ?? 'N/A',
                    'service_name' => $service->service_name ?? 'N/A',
                    'start_time' => $slot->scheduled_start_time->format('h:i A'),
                    'end_time' => $slot->scheduled_end_time->format('h:i A'),
                    'order_id' => $order->id,
                ]
            );
        }

        // Forced SMS
        if ($user->cell_phone) {
            SendSMSJob::dispatch(
                $user->cell_phone,
                "Reminder: GermBlast Service Order #{$order->order_no} ({$service->service_name}) is scheduled today from " . $slot->scheduled_start_time->format('h:i A') . " to " . $slot->scheduled_end_time->format('h:i A') . "."
            );
        }

        $companyName = clone($order)->service->lead->company->name ?? 'Unknown Company';
        $this->sendInApp(
            $user,
            'Service Order Today (Sales)',
            "Reminder: Service Order #{$order->order_no} ({$companyName}) is scheduled today.",
            'operations',
            $order->id,
            'service_order_today_sales',
            get_class($order)
        );
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

    public function shareInvoice($email, $order, $invoiceDetails, $attachment = null)
    {
        if ($this->sendEmail) {
            $data = [
                'order_no' => $order->order_no ?? 'N/A',
                'invoice_no' => $invoiceDetails['invoice_no'],
                'invoice_date' => $invoiceDetails['invoice_date'],
                'due_date' => $invoiceDetails['due_date'],
                'items' => $invoiceDetails['items'],
                'total_amount' => $invoiceDetails['total_amount'],
                'notes' => $invoiceDetails['notes'] ?? '',
                'email_message' => $invoiceDetails['email_message'],
                'company_name' => $invoiceDetails['company_name'],
            ];

            if ($attachment) {
                $data['attachment'] = $attachment;
            }

            SendEmailJob::dispatch($email, 'share_invoice', $data);
        }
    }

    public function timeOffSubmitted($timeOffRequest)
    {
        $employee = $timeOffRequest->user;
        $superAdmins = \App\Models\User::all()->filter(fn($u) => $u->isSuperAdmin());

        foreach ($superAdmins as $admin) {
            if ($this->sendEmail) {
                SendEmailJob::dispatch(
                    $admin->email,
                    'time_off_submitted',
                    [
                        'admin_name' => $admin->name,
                        'employee_name' => $employee->name ?? 'Unknown Employee',
                        'start_date' => $timeOffRequest->start_date->format('M d, Y'),
                        'end_date' => $timeOffRequest->end_date->format('M d, Y'),
                        'duration_days' => $timeOffRequest->duration_days,
                        'reason' => $timeOffRequest->reason ?? 'No reason provided',
                        'request_id' => $timeOffRequest->id,
                    ]
                );
            }

            if ($this->sendSMS && $admin->cell_phone) {
                SendSMSJob::dispatch(
                    $admin->cell_phone,
                    "New Time Off Request submitted by {$employee->name} from " . $timeOffRequest->start_date->format('M d, Y') . " to " . $timeOffRequest->end_date->format('M d, Y') . "."
                );
            }

            $this->sendInApp(
                $admin,
                'Time Off Request Submitted',
                "New Time Off Request submitted by {$employee->name}.",
                'hr',
                $timeOffRequest->id,
                'time_off_submitted',
                get_class($timeOffRequest)
            );
        }
    }

    public function timeOffActioned($timeOffRequest)
    {
        $employee = $timeOffRequest->user;
        if (!$employee) return;

        if ($this->sendEmail) {
            SendEmailJob::dispatch(
                $employee->email,
                'time_off_actioned',
                [
                    'employee_name' => $employee->name,
                    'status' => $timeOffRequest->status,
                    'start_date' => $timeOffRequest->start_date->format('M d, Y'),
                    'end_date' => $timeOffRequest->end_date->format('M d, Y'),
                    'duration_days' => $timeOffRequest->duration_days,
                    'admin_notes' => $timeOffRequest->admin_notes ?? 'No comments.',
                ]
            );
        }

        if ($this->sendSMS && $employee->cell_phone) {
            SendSMSJob::dispatch(
                $employee->cell_phone,
                "Your Time Off Request for " . $timeOffRequest->start_date->format('M d, Y') . " to " . $timeOffRequest->end_date->format('M d, Y') . " has been {$timeOffRequest->status}."
            );
        }

        $this->sendInApp(
            $employee,
            'Time Off Request Actioned',
            "Your Time Off Request has been {$timeOffRequest->status}.",
            'hr',
            $timeOffRequest->id,
            'time_off_actioned',
            get_class($timeOffRequest)
        );
    }

}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;

    public $data;

    public function __construct($type, $data)
    {
        $this->type = $type;   // "company" or "lead"
        $this->data = $data;   // dynamic details
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: match ($this->type) {
                'company_created' => 'New Company Added',
                'lead_created' => 'New Lead Created',
                'lead_assigned' => 'New Lead Assigned to You',
                'initial_meeting_scheduled' => 'Initial Meeting Scheduled',
                'initial_meeting_completed' => 'Initial Meeting Completed',
                'site_survey_scheduled' => 'Site Survey Scheduled',
                'site_survey_completed' => 'Site Survey Completed',
                'meeting_scheduled' => 'New Meeting Scheduled',
                'meeting_updated' => 'Meeting Updated',
                'proposal_approval_stage' => 'Survey Proposal Ready for Review',
                'staff_assigned_to_order' => 'You Have Been Assigned to a Service Order',
                'staff_unassigned_from_order' => 'You Have Been Unassigned from a Service Order',
                'staff_marked_as_leader' => 'You Have Been Marked as Leader',
                'staff_unmarked_as_leader' => 'You Have Been Unmarked as Leader',
                'service_note_added' => 'New Service Note Added',
                'day_of_service_staff' => 'Service Order Scheduled Today',
                'day_of_service_sales_rep' => 'Service Scheduled Today',
                default => 'Lead Notification'
            }
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: "email-template.{$this->type}",
            with: ['data' => $this->data]
        );
    }


    public function attachments(): array
    {
        return [];
    }
}

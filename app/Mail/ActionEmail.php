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

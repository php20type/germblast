<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Approval;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $approval;

    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

    public function build()
    {
        $approvalUrl = route('approval.process', ['token' => $this->approval->approval_token]);

        return $this->subject('Action Approval Required')
                    ->markdown('emails.approval', [
                        'approval' => $this->approval,
                        'approvalUrl' => $approvalUrl,
                    ]);
    }
}

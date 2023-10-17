<?php

namespace App\Mail;

use App\Models\DealerSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DealershipRequestSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public DealerSubmission $dealerSubmission;

    /**
     * Create a new message instance.
     */
    public function __construct(DealerSubmission $dealerSubmission)
    {
        $this->dealerSubmission = $dealerSubmission;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dealership Request Submitted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.dealership-request-submitted',
            with: [
                'dealerSubmission' => $this->dealerSubmission,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

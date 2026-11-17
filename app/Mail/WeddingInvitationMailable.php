<?php

namespace App\Mail;

use App\Domains\Wedding\Models\WeddingInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeddingInvitationMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public WeddingInvitation $invitation)
    {
    }

    public function envelope(): Envelope
    {
        $wedding = $this->invitation->wedding;
        $title = $wedding?->title ?? 'a Wedding';

        return new Envelope(
            subject: "✨ You've been invited to co-plan {$title} on Wedora",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.wedding-invitation',
            with: [
                'invitation' => $this->invitation,
                'wedding' => $this->invitation->wedding,
                'inviter' => $this->invitation->invitedBy,
                'inviteUrl' => route('invitations.show', ['token' => $this->invitation->token]),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

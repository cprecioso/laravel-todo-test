<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitedToProject extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $inviterName;
    public string $projectName;
    public string $url;

    /**
     * Create a new message instance.
     */
    public function __construct(User $inviter, Project $project, string $url)
    {
        $this->inviterName = $inviter->name;
        $this->projectName = $project->name;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "$this->inviterName has invited you to collaborate on \"$this->projectName\"",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.project.invite',
            with: [
                'inviterName' => $this->inviterName,
                'projectName' => $this->projectName,
                'url' => $this->url,
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

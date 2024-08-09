<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyResultStudyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $student;
    protected $argvScore;

    /**
     * Create a new message instance.
     */
    public function __construct($student, $argvScore)
    {
        $this->student = $student;
        $this->argvScore = $argvScore;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notify Result Study Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.mails.result-study-student-mail',
            with: [
                'name' => $this->student->user->name,
                'email' => $this->student->user->email,
                'avgScore' => $this->argvScore,
            ]
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

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyCustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $title;
    public $content;
    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $title
     * @param string $content
     */
    public function __construct(string $subject, string $title, string $content)
    {
        $this->subject = $subject;
        $this->title = $title;
        $this->content = $content;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email')
            ->subject($this->subject)
            ->with([
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'My Custom Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'theme.page.email',
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

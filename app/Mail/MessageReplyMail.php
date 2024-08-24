<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class MessageReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new message instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
        Log::info('MessageReplyMail created');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        Log::info('message Mail Envelope');
        return new Envelope(
            subject: 'Message Reply',
            from: env('MAIL_FROM_ADDRESS'),
            to: $this->message->email,
            replyTo: env('MAIL_REPLY_TO_ADDRESS'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        Log::info('message Mail Content');
        return new Content(
            view: 'email.message_reply',
            with: ['data' => $this->message],
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

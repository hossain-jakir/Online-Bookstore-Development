<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $type; //1. Order Confirmation 2. Order due payment 3. Order payment failed

    /**
     * Create a new message instance.
     */
    public function __construct($order, $type)
    {
        $this->order = $order;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = '';
        if ($this->type == 1) {
            $subject = 'Order Confirmation';
        } elseif ($this->type == 2) {
            $subject = 'Order due payment';
        } elseif ($this->type == 3) {
            $subject = 'Order payment failed';
        }

        Log::info('OrderMail envelope');
        return new Envelope(
            subject: $subject,
            from: env('MAIL_FROM_ADDRESS'),
            to: $this->order->user->email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        Log::info('OrderMail content');
        return new Content(
            view: 'email.order_mail_view',
            with: ['data' => $this->order, 'type' => $this->type]
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

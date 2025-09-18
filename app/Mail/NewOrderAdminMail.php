<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewOrderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $bodyText;
    public string $subjectText;

    /**
     * Create a new message instance.
     */
    public function __construct($order)
{
        $this->subjectText = 'Нове замовлення #' . $order->id;
        $this->bodyText    = 'Клієнт: ' . $order->name . ', сума: ' . $order->total_price ;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lead_message',
            with: [
                'bodyText' => $this->bodyText,
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

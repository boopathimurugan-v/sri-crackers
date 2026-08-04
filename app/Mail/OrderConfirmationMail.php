<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $pdfData;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $pdfData)
    {
        $this->order = $order;
        $this->pdfData = $pdfData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address', 'support@sricrackers.com'), config('mail.from.name', 'SRI CRACKERS')),
            subject: 'Order Confirmed! Sri Crackers #' . $this->order->order_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_confirmation',
            with: [
                'order' => $this->order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $filename = 'SRI-CRACKERS-INVOICE-' . ($this->order->invoice_number ?? $this->order->order_number) . '.pdf';

        return [
            Attachment::fromData(fn () => $this->pdfData, $filename)
                ->withMime('application/pdf'),
        ];
    }
}

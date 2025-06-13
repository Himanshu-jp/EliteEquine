<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSuccessOwnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('You Sold a Product!')
                    ->view('front.emails.order_success_owner');
    }
}

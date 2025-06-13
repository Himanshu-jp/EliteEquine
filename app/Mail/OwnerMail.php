<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OwnerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $owner, public $product, public $winner)
    {
        $this->owner = $owner;
        $this->product = $product;
        $this->winner = $winner;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->view('front.emails.owner_notification')
            ->subject('Your product has a winning bidder')
            ->with([
                'owner' => $this->owner,
                'product' => $this->product,
                'winner' => $this->winner,
            ]);
    }

    
}

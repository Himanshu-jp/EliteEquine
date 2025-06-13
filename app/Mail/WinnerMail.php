<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WinnerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $product, $owner)
    {
        $this->user = $user;
        $this->product = $product;
        $this->owner = $owner;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        $subject = 'You won the bid for ' . $this->product->title;

        if ($this->product->transaction_method === 'platform') {
            return $this->view('front.emails.winner_platform')
                ->subject($subject)
                ->with([
                    'user' => $this->user,
                    'product' => $this->product,
                    'link' => route('horseDetails', $this->product->id),
                ]);
        } else {
            return $this->view('emails.winner_buyertoseller')
                ->subject($subject)
                ->with([
                    'user' => $this->user,
                    'product' => $this->product,
                    'owner' => $this->owner,
                ]);
        }
    }

    
}

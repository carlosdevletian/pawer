<?php

namespace Pawer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $items, $emailAddress;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailAddress, $items)
    {
        $this->emailAddress = $emailAddress;
        $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('orders@paw3r.com')
                    ->replyTo($this->emailAddress)
                    ->subject("New Order by {$this->emailAddress}")
                    ->view('emails.send-order');
    }
}

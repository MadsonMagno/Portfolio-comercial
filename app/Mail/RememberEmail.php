<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RememberEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $remember;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($remember)
    {
        $this->remember = $remember;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $remember = $this->remember;

        return $this->markdown('emails.remember', compact('remember'));
    }
}

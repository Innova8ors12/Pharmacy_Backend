<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountRequest extends Mailable
{
    use Queueable, SerializesModels;
    protected $accrequest;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($accrequest)
    {
        $this->accrequest = $accrequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $accrequest = $this->accrequest;
        return $this->subject('The Pharmassist New Account Request ')
            ->view('CustomerEmails.accountrequest',compact('accrequest'));
    }
}

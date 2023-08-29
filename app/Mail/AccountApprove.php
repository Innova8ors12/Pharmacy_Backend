<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountApprove extends Mailable
{
    use Queueable, SerializesModels;
    protected $approve;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approve)
    {
        $this->approve = $approve;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $approve = $this->approve;
        return $this->subject('The Pharmassist Account Approval')
        ->view('CustomerEmails.approve',compact('approve'));
    }
}

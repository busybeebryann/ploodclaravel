<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOTPMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $user_otp;
     public $user_info;

    public function __construct($otp,$user)
    {
        
        $this->user_otp = $otp;
        $this->user_info = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hello '.$this->user_info->username.', This is your One Time Password!')
                    ->markdown('emails.sendotp');
    }
}

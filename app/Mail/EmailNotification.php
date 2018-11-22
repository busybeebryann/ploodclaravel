<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mailer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname, $message, $mail_prop, $project_id)
    {

        $this->mailer = (object) array(
            'mail_prop' => $mail_prop,
            'project_id' => $project_id,
            'full_name' => $fullname,
            'message' => $message
        );

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notification')->with([
            'mail_prop'=>$this->mailer->mail_prop,
            'project_id'=>$this->mailer->project_id,
            'full_name'=>$this->mailer->full_name,
            'message'=>$this->mailer->message
        ]);
    }
}

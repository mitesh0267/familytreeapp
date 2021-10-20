<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetPwdSuccessMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $userDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userDetails)
    {
        $this->userDetails = $userDetails;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config('mail.from.address');
        $mailData = [
            "name" => $this->userDetails['name']
        ];
        return $this->view('emails.reset-password-success')
        ->from($address, $this->userDetails['name'])
        ->subject("You Recently Reset Your Password")
        ->with(['data' =>  $mailData]);
    }
}

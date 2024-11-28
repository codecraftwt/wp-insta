<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // You can pass any dynamic data to the email here if needed
    }

    public function build()
    {
        return $this->subject('Thank You for Registering!')
            ->view('emails.registration_thank_you');
    }
}

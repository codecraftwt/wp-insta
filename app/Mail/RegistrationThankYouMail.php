<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;

    public function __construct($email, $password)
    {
        // Pass the email and password to the email view
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Thank You for Registering!')
            ->view('emails.registration_thank_you');
    }
}

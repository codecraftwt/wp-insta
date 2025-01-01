<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteResumeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userEmail;
    public $userName;
    public $siteName;

    public function __construct($userEmail, $userName, $siteName)
    {
        // Pass the email and password to the email view
        $this->userEmail = $userEmail;
        $this->userName = $userName;
        $this->siteName = $siteName;
    }

    public function build()
    {
        $baseUrl = config('site.base_url');

        $imageUrl = $baseUrl . '/public/assets/img/WalstarWplogo.png';



        return $this->subject('Site Has Been Running Again')
            ->view('emails.site_resume')
            ->with([


                'userEmail' => $this->userEmail,
                'userName' => $this->userName,
                'siteName' => $this->siteName,
                'imageUrl' => $imageUrl,

            ]);
    }
}

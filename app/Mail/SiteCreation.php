<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteCreation extends Mailable
{
    use Queueable, SerializesModels;
    use Queueable, SerializesModels;

    public $siteName;



    public function __construct($siteName)
    {

        $this->siteName = $siteName;
    }

    public function build()
    {

        $baseUrl = config('site.base_url');

        $imageUrl = $baseUrl . '/public/assets/img/WalstarWplogo.png';

        return $this->view('emails.site_creation')
            ->subject('Storage Usage Alert')
            ->with([
                'siteName' => $this->siteName,
                'imageUrl' => $imageUrl,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HundredPerStorageUsageAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $usagePercentage;


    public function __construct($user, $usagePercentage)
    {
        $this->user = $user;
        $this->usagePercentage = $usagePercentage;
    }

    public function build()
    {

        $baseUrl = config('site.base_url');

        $imageUrl = $baseUrl . '/public/assets/img/WalstarWplogo.png';

        return $this->view('emails.hundredstorage_usage_alert')
            ->subject('Storage Usage Alert')
            ->with([
                'name' => $this->user->name,
                'usagePercentage' => $this->usagePercentage,
                'imageUrl' => $imageUrl,
            ]);
    }
}

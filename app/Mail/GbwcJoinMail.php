<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GbwcJoinMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mrd;
    public $jrd;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mrd, $jrd)
    {
        $this->mrd = $mrd;
        $this->jrd = $jrd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "2017 GBWC 報名資訊";
        return $this->view('emails.gbwc_join')->subject($subject);
    }
}

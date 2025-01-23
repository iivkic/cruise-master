<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $lmd_images;

    /**
     * Create a new message instance.
     *
     * @param $lmd_images
     */
    public function __construct($lmd_images)
    {
        $this->lmd_images = $lmd_images;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('UP TO 20% EARLY BOOKING DISCOUNT ON CERTAIN CRUISES UNTIL MAY 1')->view('cruises.last-minute-template');
    }
}

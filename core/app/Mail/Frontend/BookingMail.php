<?php

namespace App\Mail\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Booking;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The booking instance.
     *
     * @var Booking
     */
    public $booking;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $basicSetting = \App\BasicSetting::first();
        $basicExtendedSetting = \App\BasicExtended::first();

        if (isset($basicExtendedSetting) && $basicExtendedSetting->is_smtp == 1) {

            $subject = $basicSetting->website_title.' Booking';
            
            return $this->view('front.emails.booking')
                        ->subject($subject);
        }

    }
}

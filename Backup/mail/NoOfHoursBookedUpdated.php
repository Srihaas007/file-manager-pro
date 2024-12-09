<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoOfHoursBookedUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $ClientID;
    public $BookingID;

    /**
     * Create a new message instance.
     *
     * @param $booking
     * @param $ClientID
     * @param $BookingID
     */
    public function __construct($booking, $ClientID, $BookingID)
    {
        $this->booking = $booking;
        $this->ClientID = $ClientID;
        $this->BookingID = $BookingID;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.no_of_hours_booked_updated')
                    ->subject('No Of Hours Booked Updated')
                    ->with([
                        'booking' => $this->booking,
                        'ClientID' => $this->ClientID,
                        'BookingID' => $this->BookingID,
                    ]);
    }
}

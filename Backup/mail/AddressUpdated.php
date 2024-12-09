<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddressUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $ClientID;
    public $Booking_id;

    /**
     * Create a new message instance.
     *
     * @param $booking
     * @param $ClientID
     * @param $Booking_id
     */
    public function __construct($booking, $ClientID, $Booking_id)
    {
        $this->booking = $booking;
        $this->ClientID = $ClientID;
        $this->Booking_id = $Booking_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.address_updated')
                    ->subject('Your Address Has Been Updated')
                    ->with([
                        'booking' => $this->booking,
                        'ClientID' => $this->ClientID,
                        'Booking_id' => $this->Booking_id,
                    ]);
    }
}

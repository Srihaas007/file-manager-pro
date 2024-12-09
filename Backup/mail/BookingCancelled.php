<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Booking;

class BookingCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Booking $booking
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
        return $this->view('mail.booking_cancelled')
                    ->subject('Booking Cancelled')
                    ->with([
                        'booking' => $this->booking,
                        'ClientID' => $this->booking->ClientID,
                        'Booking_id' => $this->booking->Booking_id,
                        'DateTimeCancelled' => $this->booking->DateTimeCancelled,
                        'CancelationReason' => $this->booking->CancelationReason,
                        'CancelationFullname' => $this->booking->CancelationFullname,
                        'CancelationContact' => $this->booking->CancelationContact,
                        'ContactCancelled' => $this->booking->ContactCancelled,
                        'CancelationPersonEmail' => $this->booking->CancelationPersonEmail,
                    ]);
    }
}

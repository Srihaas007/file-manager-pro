<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Booking;

class BookingDateTimeUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $dateOfJob;
    public $timeOfJob;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Booking $booking
     * @param string|null $dateOfJob
     * @param string|null $timeOfJob
     * @return void
     */
    public function __construct(Booking $booking, $dateOfJob = null, $timeOfJob = null)
    {
        $this->booking = $booking;
        $this->dateOfJob = $dateOfJob;
        $this->timeOfJob = $timeOfJob;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.booking_datetime_updated')
                    ->subject('Booking Date and Time Updated')
                    ->with([
                        'booking' => $this->booking,
                        'dateOfJob' => $this->dateOfJob,
                        'timeOfJob' => $this->timeOfJob,
                        'ClientID' => $this->booking->ClientID,
                        'Booking_id' => $this->booking->Booking_id,
                    ]);
    }
}

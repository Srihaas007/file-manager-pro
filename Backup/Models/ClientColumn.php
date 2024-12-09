<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientColumn extends Model
{
    use HasFactory;

    protected $table = 'clientsdatabase';

    protected $fillable = [
        'BookingID', 'ClientID', 'IsConfirmedBooking', 'IsConfirmedBookingdatatype', 'IsConfirmedBookinglength',
        'IsConfirmedBookingifbool', 'IsConfirmedBookingdefault', 'CancelledByClient', 'CancelledByClientdatatype',
        'CancelledByClientdefault', 'CancelledByClientlength', 'CancelledByClientifbool', 'CancelledByUsdatatype',
        'CancelledByUsdefault', 'CancelledByUslength', 'CancelledByUsifbool', 'CancelationReason', 
        'CancelationFullname', 'CancelationContact', 'ContactCancelled', 'CancelationPersonEmail', 
        'DateTimeCancelled', 'DNA', 'DNAdatatype', 'DNAdefault', 'DNAlength', 'DNAifbool', 'ClientDNA', 
        'ClientDNAdatatype', 'ClientDNAdefault', 'ClientDNAlength', 'ClientDNAifbool','CancelByInterpreter'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

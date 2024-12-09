<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'table_id', 'table_name',
        'InterpreterID', 'ClientID', 'DateOfJOb', 'TimeOfJob', 'BookingID',
        'StartTime', 'FinishTime', 'Language1ID', 'IsConfirmedBooking',
        'BookingAddressID', 'NoOfHoursBooked', 'HouseNo', 'BookingAddress1',
        'BookingAddress2', 'BookingAddress3', 'BookingAddressPostCode',
        'CancelledByClient', 'CancelledByUs', 'CancelledBy', 'DateTimeCancelled',
        'DNA', 'ClientDNA', 'EndUserEmail', 'EndUserMobile', 'ClientCaller',
        'ContactNumber', 'BookingPersonEmail', 'Officer', 'contactPersonEmail',
        'ServiceID', 'GenderOfInterpreter', 'ClientClientName', 'BudgetHolderName',
        'BudgetHolderContact', 'BudgetHolderEmail', 'DeptOrTypeofCase',
        'HealthSafetyHazzards', 'AnySpecialInstructions', 'TrustServices',
        'OtherTrusts', 'OtherNature', 'DoubleBookingDetected',
        'ReasonF2FInterpreterNeeded', 'DateTimeOfBookingConfirmation',
        'DateTimeOfBookingConfirmationFirstTime', 'CancelationReason',
        'CancelationFullname', 'CancelationContact', 'ContactCancelled',
        'CancelationPersonEmail', 'appointment', 'appointment_type', 'attendees'
    ];

    public function clientTable()
    {
        return $this->belongsTo(ClientTable::class, 'table_id');
    }
}

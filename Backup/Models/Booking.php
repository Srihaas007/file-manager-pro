<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'SrNo', 'InterpreterID', 'ClientID', 'DateOfJOb', 'TimeOfJob', 'create_copy', 'BookingID',
        'TimeOfArrival', 'StartTime', 'FinishTime', 'JourneyMilesTotal', 'JourneyHours',
        'JournyMilesClient', 'TrvlTim4Inter', 'ParkingFee', 'Mileage', 'uploadTimesheet',
        'uploadReceipt', 'Language1ID', 'IsConfirmedBooking', 'BookingAddressID', 'JSReturned',
        'NoOfHoursBooked', 'WorkCrsClient', 'HouseNo', 'BookingAddress1', 'BookingAddress2',
        'BookingAddress3', 'BookingAddressPostCode', 'CancelledByClient', 'CancelledByUs',
        'CancelledBy', 'DateTimeCancelled', 'ComplaintClosed', 'ArrivedLated', 'InterpreterPaid',
        'PayInterpreter', 'DNA', 'ClientDNA', 'CostCentreCode', 'TimeSheetUploadedOn',
        'Excellent', 'VeryGood', 'Good', 'Fair', 'Poor', 'EndUserEmail', 'EndUserMobile',
        'ClientCaller', 'ContactNumber', 'BookingPersonEmail', 'Officer', 'contactPersonEmail',
        'ServiceID', 'GenderOfInterpreter', 'ClientClientName', 'BudgetHolderName',
        'BudgetHolderContact', 'BudgetHolderEmail', 'ClientJobReferenceNumber', 'DeptOrTypeofCase',
        'HealthSafetyHazzards', 'AnySpecialInstructions', 'TrustServices', 'OtherTrusts',
        'OtherNature', 'QualityOfWork', 'Attitude', 'Attendance', 'DressCode', 'NoCommentsWasGiven',
        'DoubleBookingDetected', 'test', 'status', 'TimesheetPath', 'ReasonF2FInterpreterNeeded',
        'new_available_status', 'confirm_status', 'reject_status', 'DateTimeOfEnquiry',
        'DateTimeOfBookingConfirmation', 'DateTimeOfBookingConfirmationFirstTime',
        'CancelationReason', 'CancelationFullname', 'CancelationContact', 'ContactCancelled',
        'CancelationPersonEmail', 'NameofFeedbacker', 'ContactOfFeedbacker', 'EmailofFeedbacker',
        'FeedbackerReason', 'DetailsOfFeedbacker', 'DateTimeFeedbackReceived', 'ComplaintReceived',
        'Specialty', 'RVIRate', 'BSLVideoRate', 'ClientRatePerMile', 'BChargeClientByMinuteAfter1stHr',
        'BChargeClientNormalRate4OutOfhours', 'BChargeClientFixedHrlyRate4OutOfhrs', 'ClientRate',
        'Client2ndHrRate', 'BSLRate2Client', 'image_compress', 'appointment', 'appointment_type',
        'attendees', 'is_aleady_worked', 'papers_being_referred', 'NeedsClientAdminApproval',
        'RejectedByClientAdmin', 'SubOffice', 'TrustServices2', 'BookingNotes', 'ClientAmountLessVAT',
        'ClientExpenses', 'ClientTotal', 'IsPatientNotificationSent', 'PatientNotificationResponse'
    ];

    protected $dates = [
        'DateOfJOb', 'DateTimeOfEnquiry', 'DateTimeOfBookingConfirmation',
        'DateTimeOfBookingConfirmationFirstTime', 'DateTimeCancelled', 'DateTimeFeedbackReceived'
    ];

    protected $casts = [
        'NoOfHoursBooked' => 'float',
        'EndUserMobile' => 'integer',
        'BudgetHolderContact' => 'integer',
        'IsConfirmedBooking' => 'integer',
        'CancelledByUs' => 'integer',
        'JSReturned' => 'integer',
        'Excellent' => 'integer',
        'VeryGood' => 'integer',
        'Good' => 'integer',
        'Fair' => 'integer',
        'Poor' => 'integer',
        'ArrivedLated' => 'integer',
        'InterpreterPaid' => 'integer',
        'PayInterpreter' => 'integer',
        'DNA' => 'integer',
        'ClientDNA' => 'integer',
        'ComplaintClosed' => 'integer',
        'CancelledByClient' => 'integer',
        'CancelledByInterpreter' => 'integer',
        'BChargeClientByMinuteAfter1stHr' => 'integer',
        'BChargeClientNormalRate4OutOfhours' => 'integer',
        'appointment' => 'integer',
        'appointment_type' => 'integer',
        'attendees' => 'integer',
        'is_aleady_worked' => 'integer',
        'papers_being_referred' => 'integer',
        'NeedsClientAdminApproval' => 'boolean',
        'RejectedByClientAdmin' => 'boolean',
        'image_compress' => 'boolean',
        'ComplaintReceived' => 'boolean',
        'Specialty' => 'boolean',
    ];

    // Define your relationships and other methods as needed
}

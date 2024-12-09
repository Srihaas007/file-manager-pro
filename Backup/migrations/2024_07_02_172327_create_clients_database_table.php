`<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateclientsdatabaseTable extends Migration
{
    public function up()
    {
        Schema::create('clientsdatabase', function (Blueprint $table) {
            // Primary Key AutoIncrement
            $table->id();

            // existing columns from MySQL table bookings

            //$table->string('ClientCaller');
            //$table->string('DateOfJOb');
            //$table->string('StartTime');
            //$table->string('FinishTime');
            //$table->string('TimeOfJob');
            //$table->string('ContactNumber');
            //$table->string('BookingPersonEmail');
            //$table->string('contactPersonEmail');
            //$table->string('Officer');
            //$table->string('GenderOfInterpreter');
            //$table->string('ServiceID');
            //$table->string('Specialty');
            //$table->string('ClientClientName');
            //$table->string('Language1ID');
            //$table->string('EndUserEmail');
            //$table->string('EndUserMobile');    
            //$table->string('NoOfHoursBooked');  
            //$table->string('HouseNo');
            //$table->string('BookingAddress1');
            //$table->string('BookingAddress2');
            //$table->string('BookingAddress3');
            //$table->string('BookingAddressPostCode');   
            //$table->string('BookingAddressID'); 
            //$table->string('appointment_type'); 
            //$table->string('ReasonF2FInterpreterNeeded');
            //$table->string('BookingNotes');
            //$table->string('appointment');
            //$table->string('ComplaintClosed');
            //$table->string('attendees'); 
            $table->string('BookingID');
            $table->string('ClientID');
            $table->string('IsConfirmedBooking');
            $table->string('IsConfirmedBookingdatatype');
            $table->string('IsConfirmedBookinglength');
            $table->string('IsConfirmedBookingifbool');
            $table->string('IsConfirmedBookingdefault');
            $table->string('CancelledByClient');
            $table->string('CancelledByClientdatatype');
            $table->string('CancelledByClientdefault');
            $table->string('CancelledByClientlength');
            $table->string('CancelledByClientifbool');
            $table->string('CancelledByUs');
            $table->string('CancelledByUsdatatype');
            $table->string('CancelledByUsdefault');
            $table->string('CancelledByUslength');
            $table->string('CancelledByUsifbool');
            $table->string('CancelationReason');
            $table->string('CancelationFullname');
            $table->string('CancelationContact');
            $table->string('ContactCancelled');
            $table->string('CancelationPersonEmail');
            $table->string('DateTimeCancelled');
            $table->string('DNA');
            $table->string('DNAdatatype');
            $table->string('DNAdefault');
            $table->string('DNAlength');
            $table->string('DNAifbool');
            $table->string('ClientDNA');
            $table->string('ClientDNAdatatype');
            $table->string('ClientDNAdefault');
            $table->string('ClientDNAlength');
            $table->string('ClientDNAifbool');
            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientsdatabase');
    }
}

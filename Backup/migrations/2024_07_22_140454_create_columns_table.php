<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsTable extends Migration
{
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('table_id');
            $table->string('table_name'); // New column for table name
            $table->string('InterpreterID')->nullable();
            $table->string('ClientID')->nullable();
            $table->string('DateOfJOb')->nullable();
            $table->string('TimeOfJob')->nullable();
            $table->string('BookingID')->nullable();
            $table->string('StartTime')->nullable();
            $table->string('FinishTime')->nullable();
            $table->string('Language1ID')->nullable();
            $table->string('IsConfirmedBooking')->nullable();
            $table->string('BookingAddressID')->nullable();
            $table->string('NoOfHoursBooked')->nullable();
            $table->string('HouseNo')->nullable();
            $table->string('BookingAddress1')->nullable();
            $table->string('BookingAddress2')->nullable();
            $table->string('BookingAddress3')->nullable();
            $table->string('BookingAddressPostCode')->nullable();
            $table->string('CancelledByClient')->nullable();
            $table->string('CancelByInterpreter')->nullable();
            $table->string('CancelledByUs')->nullable();
            $table->string('CancelledBy')->nullable();
            $table->string('DateTimeCancelled')->nullable();
            $table->string('DNA')->nullable();
            $table->string('ClientDNA')->nullable();
            $table->string('EndUserEmail')->nullable();
            $table->string('EndUserMobile')->nullable();
            $table->string('ClientCaller')->nullable();
            $table->string('ContactNumber')->nullable();
            $table->string('BookingPersonEmail')->nullable();
            $table->string('Officer')->nullable();
            $table->string('contactPersonEmail')->nullable();
            $table->string('ServiceID')->nullable();
            $table->string('GenderOfInterpreter')->nullable();
            $table->string('ClientClientName')->nullable();
            $table->string('BudgetHolderName')->nullable();
            $table->string('BudgetHolderContact')->nullable();
            $table->string('BudgetHolderEmail')->nullable();
            $table->string('DeptOrTypeofCase')->nullable();
            $table->string('HealthSafetyHazzards')->nullable();
            $table->string('AnySpecialInstructions')->nullable();
            $table->string('TrustServices')->nullable();
            $table->string('OtherTrusts')->nullable();
            $table->string('OtherNature')->nullable();
            $table->string('DoubleBookingDetected')->nullable();
            $table->string('ReasonF2FInterpreterNeeded')->nullable();
            $table->string('DateTimeOfBookingConfirmation')->nullable();
            $table->string('DateTimeOfBookingConfirmationFirstTime')->nullable();
            $table->string('CancelationReason')->nullable();
            $table->string('CancelationFullname')->nullable();
            $table->string('CancelationContact')->nullable();
            $table->string('ContactCancelled')->nullable();
            $table->string('CancelationPersonEmail')->nullable();
            $table->string('appointment')->nullable();
            $table->string('appointment_type')->nullable();
            $table->string('attendees')->nullable();
            $table->timestamps();

  
            $table->foreign('table_id')->references('id')->on('clients_tables')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('columns');
    }
}

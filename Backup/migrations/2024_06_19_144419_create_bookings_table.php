<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            // Primary Key AutoIncrement
            $table->id();

            // existing columns from MySQL table bookings
            $table->integer('InterpreterID');
            $table->integer('ClientID');
            $table->date('DateOfJOb');
            $table->string('TimeOfJob', 30);
            $table->string('create_copy', 255);
            $table->bigInteger('BookingID');
            $table->string('TimeOfArrival', 30);
            $table->string('StartTime', 30);
            $table->string('FinishTime', 30);
            $table->string('JourneyMilesTotal', 30)->nullable();
            $table->string('JourneyHours', 100)->nullable();
            $table->string('JournyMilesClient', 30)->nullable();
            $table->string('TrvlTim4Inter', 100)->nullable();
            $table->string('ParkingFee', 30);
            $table->string('Mileage', 30);
            $table->string('uploadTimesheet', 50);
            $table->string('uploadReceipt', 50);
            $table->string('Language1ID', 110);
            $table->integer('IsConfirmedBooking');
            $table->string('BookingAddressID', 110);
            $table->tinyInteger('JSReturned');
            $table->float('NoOfHoursBooked');
            $table->float('WorkCrsClient');
            $table->string('HouseNo', 50);
            $table->string('BookingAddress1', 500);
            $table->string('BookingAddress2', 500);
            $table->string('BookingAddress3', 500);
            $table->string('BookingAddressPostCode', 10);
            $table->string('CancelledByClient', 255);
            $table->integer('CancelledByUs')->nullable();
            $table->string('CancelledBy', 200)->nullable();
            $table->string('DateTimeCancelled', 100)->nullable();
            $table->integer('ComplaintClosed');
            $table->integer('ArrivedLated');
            $table->integer('InterpreterPaid');
            $table->integer('PayInterpreter');
            $table->integer('DNA');
            $table->integer('ClientDNA');
            $table->string('CostCentreCode', 100);
            $table->date('TimeSheetUploadedOn')->nullable();
            $table->integer('Excellent');
            $table->integer('VeryGood');
            $table->integer('Good');
            $table->integer('Fair');
            $table->integer('Poor');
            $table->string('EndUserEmail', 100);
            $table->bigInteger('EndUserMobile');
            $table->string('ClientCaller', 50);
            $table->string('ContactNumber', 50);
            $table->string('BookingPersonEmail', 100);
            $table->string('Officer', 60);
            $table->text('contactPersonEmail')->nullable();
            $table->string('ServiceID', 100);
            $table->string('GenderOfInterpreter', 10);
            $table->string('ClientClientName', 200);
            $table->string('BudgetHolderName', 200);
            $table->string('BudgetHolderContact', 200);
            $table->string('BudgetHolderEmail', 200);
            $table->text('ClientJobReferenceNumber');
            $table->string('DeptOrTypeofCase', 200);
            $table->string('HealthSafetyHazzards', 200);
            $table->string('AnySpecialInstructions', 500);
            $table->string('TrustServices', 200);
            $table->string('OtherTrusts', 200);
            $table->string('OtherNature', 200);
            $table->string('QualityOfWork', 20);
            $table->string('Attitude', 20);
            $table->string('Attendance', 20);
            $table->string('DressCode', 20);
            $table->string('NoCommentsWasGiven', 20);
            $table->string('DoubleBookingDetected', 255);
            $table->string('test', 2);
            $table->string('status', 255);
            $table->string('TimesheetPath', 250);
            $table->string('ReasonF2FInterpreterNeeded', 1000);
            $table->integer('new_available_status');
            $table->integer('confirm_status');
            $table->integer('reject_status');
            $table->timestamp('DateTimeOfEnquiry')->useCurrent();
            $table->dateTime('DateTimeOfBookingConfirmation')->nullable();
            $table->dateTime('DateTimeOfBookingConfirmationFirstTime')->nullable();
            $table->integer('CancelationReason')->default(0);
            $table->string('CancelationFullname', 255)->nullable();
            $table->string('CancelationContact', 50)->nullable();
            $table->string('ContactCancelled', 50)->nullable();
            $table->string('CancelationPersonEmail', 255)->nullable();
            $table->string('NameofFeedbacker', 100)->nullable();
            $table->bigInteger('ContactOfFeedbacker')->nullable();
            $table->string('EmailofFeedbacker', 255)->nullable();
            $table->integer('FeedbackerReason')->nullable();
            $table->text('DetailsOfFeedbacker')->nullable();
            $table->dateTime('DateTimeFeedbackReceived')->nullable();
            $table->integer('ComplaintReceived')->default(0);
            $table->integer('Specialty')->default(0);
            $table->double('RVIRate');
            $table->double('BSLVideoRate');
            $table->double('ClientRatePerMile');
            $table->integer('BChargeClientByMinuteAfter1stHr');
            $table->integer('BChargeClientNormalRate4OutOfhours');
            $table->double('BChargeClientFixedHrlyRate4OutOfhrs');
            $table->double('ClientRate');
            $table->double('Client2ndHrRate');
            $table->double('BSLRate2Client');
            $table->enum('image_compress', ['0', '1'])->default('0');
            $table->tinyInteger('appointment');
            $table->tinyInteger('appointment_type');
            $table->tinyInteger('attendees');
            $table->tinyInteger('is_aleady_worked');
            $table->tinyInteger('papers_being_referred');
            $table->smallInteger('NeedsClientAdminApproval')->default(1);
            $table->integer('RejectedByClientAdmin')->default(0);
            $table->string('SubOffice', 255);
            $table->string('TrustServices2', 200);
            $table->text('BookingNotes');
            $table->string('ClientAmountLessVAT', 11);
            $table->string('ClientExpenses', 11);
            $table->string('ClientTotal', 11);
            $table->string('IsPatientNotificationSent', 5)->default('0');
            $table->string('PatientNotificationResponse', 5)->default('0');

            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}

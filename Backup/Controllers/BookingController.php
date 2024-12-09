<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
use App\Models\ClientData;
use App\Models\Client;
use App\Models\Reasons;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ReasonsController;
use App\Mail\BookingCancelled;
use App\Mail\BookingDateTimeUpdated;
use App\Mail\BookingCreated;
use App\Mail\AddressUpdated;
use App\Mail\NoOfHoursBookedUpdated;



class BookingController extends Controller
{

   
    public function store(Request $request)
    {
        $authenticatedClient = $request->input('authenticated_client');

        try {
            // Static validation rules these fileds are required for every Client
            $staticRules = [
                'ClientID' => 'required|integer',
                'DateOfJOb' => 'required|date',
                'TimeOfJob' => 'required|date_format:H:i',
                'StartTime' => 'required|date_format:H:i',
                'FinishTime' => 'required|date_format:H:i|after:StartTime',
                'TimeOfArrival' => 'required|date_format:H:i',
                'InterpreterID' => 'required|integer',
                'Language1ID' => 'required|integer',
                'ServiceID' => 'required|string|max:100',
                'CostCentreCode' => 'required|integer',
                'BookingPersonEmail' => 'email',
                'contactPersonEmail' => 'email',
                'BudgetHolderEmail' => 'email',
                'EmailofFeedbacker' => 'email',
                'ContactNumber' => 'integer|regex:/^\d{10,10}$/',
                'BudgetHolderContact' => 'integer|regex:/^\d{10,10}$/',
                'GenderOfInterpreter' => 'integer',
                'ClientJobReferenceNumber' => 'string',
                'Specialty' => 'integer',
                'appointment' => 'integer|between:0,255',
                'appointment_type' => 'integer|between:0,255',
                'attendees' => 'integer|between:0,255',
                'EndUserEmail' => 'email',
                'EndUserMobile' => 'integer|regex:/^\d{10,10}$/',
                'BookingAddressPostCode' => 'regex:/^[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}$/',
                'ClientClientName' => 'required|string|max:100',
            ];

            // Validating the static fields first
            $validatedStaticData = $request->validate($staticRules);

            // Checking whether the ClientID matches with the API-Token that they entered
            if ($validatedStaticData['ClientID'] != $authenticatedClient->client_id) {
                return response()->json(['error' => 'ClientID does not match authenticated client'], 403);
            }

            // Checking if ClientID exists in the clients table or not 
            $clientExists = Client::where('client_id', $validatedStaticData['ClientID'])->exists();

            if (!$clientExists) {
                // if the ClientID does not exist in the clients table
                return response()->json(['error' => 'Invalid ClientID'], 404);
            }

            // Fetching client data (the whole row of that client) based on ClientID from client table
            $client = ClientData::findOrFail($validatedStaticData['ClientID']);

            // Fetching all the columns of that row dynamically from the client table
            $clientColumns = Schema::getColumnListing($client->getTable());

            // Initializing the rules array for dynamic fields
            $dynamicRules = [];

            // Dynamically maping client fields to booking fields and applying the rules
            foreach ($clientColumns as $clientField) {
                $bookingField = $this->mapField($clientField); // Maping client field to booking field
                $clientFieldValue = $client->$clientField ?? null;
                // After mapping the client table cloumns with the booking table columns we then take the values of the client table fileds dynamically and validate the below rules 
                if ($clientFieldValue == 0) {
                    // when the value of the column is 0 in client table, we do not push the data into the database, we just continue.
                    continue;
                } elseif ($clientFieldValue == 2) {
                    // when the value of the column is 2 in client table, that field is required.
                    $dynamicRules[$bookingField] = 'required';
                } elseif ($clientFieldValue == 1) {
                    // when the value of the column is 1 in client table,, the field is optional but should be validated if provided.
                    $dynamicRules[$bookingField] = 'nullable';
                }
            }

            // Validating the dynamic fields here
            $validatedDynamicData = $request->validate($dynamicRules);

            // Merge both static and dynamic validated data
            $bookingData = array_merge($validatedStaticData, $validatedDynamicData);

            // Additional static fields
            $bookingData['BookingID'] = mt_rand(100000, 999999); // creating a random 6 digit unique number for BookingID
            $bookingData['DateTimeOfBookingConfirmation'] = now()->format('Y-m-d H:i:s');
            $bookingData['DateTimeOfBookingConfirmationFirstTime'] = now()->format('Y-m-d H:i:s');

            // Checking for double booking
            $existingBooking = Booking::where('ClientID', $validatedStaticData['ClientID'])
                ->where('Language1ID', $validatedStaticData['Language1ID'])
                ->where('DateOfJOb', $validatedStaticData['DateOfJOb'])
                ->where('TimeOfJob', $validatedStaticData['TimeOfJob'])
                ->where('ClientClientName', $validatedStaticData['ClientClientName'])
                ->exists();


            //Warning message if the Double booking is detected and if the Client wants to proceed with the Booking then they can enter 1 we will proceed with the booking.
            if ($existingBooking) {
                if ($request->input('doublebooking') == null) {
                    return response()->json(['message' => 'Double booking detected. Do you want to proceed with the booking? if "Yes" enter doublebooking values as 1, if "No" input 0.'], 409);
                //if left empty we will not create the booking
                }
                if ($request->input('doublebooking') == 0) {
                    return response()->json(['message' => 'Double booking cancelled.'], 409);
                    //if value is 0 then we will cancel the booking
                }
                if ($request->input('doublebooking') != 1) {
                    return response()->json(['message' => 'Invalid Input for Double Boooking.'], 409);
                    //we check if the value is 1 or not , if the value is not 1 then we give them a message saying invalid input and will not create a booking
                }

                // Else, we will proceed to create the booking
            }
            // After all the cases validated above then we create a new booking in the table
            $booking = Booking::create($bookingData);
            
            Mail::to('franklinsrihaas@gmail.com')->send(new BookingCreated($booking));
         
            return response()->json(['message' => 'Booking created successfully', 'booking' => $booking], 201);

        } catch (ValidationException $e) {
            // If validation fails, capture the errors and respond accordingly
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            // Handle any other exceptions that may occur
            Log::error('An error occurred while creating booking: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    // Helper function to map client field to booking field, we are using this because we dont have the exact columns names in both tables.
    private function mapField($clientField)
    {
        $fieldMappings = [
            'ExpectedFinishTimeofAppointment' => 'FinishTime',
            'startTimeofAppointment' => 'StartTime',
            'targetLanguage' => 'Language1ID',
            'AnyHealthSafetyHazzards' => 'HealthSafetyHazzards',
            'BookingAdress1' => 'BookingAddress1',
            'ServiceType' => 'ServiceID',
            'yourEmailID' => 'BookingPersonEmail',
            'yourContactNumber' => 'ContactNumber',
            'GenderofInterpreter' => 'GenderOfInterpreter',
            'ReasonF2FInterprterNeeded' => 'ReasonF2FInterpreterNeeded',
            'endUserMobile' => 'EndUserMobile',
            'endUserEmail' => 'EndUserEmail',
        ];

        return $fieldMappings[$clientField] ?? $clientField;
    }

    public function updateCancelledByClient(Request $request)
    {
        Log::info('Entering updateCancelledByClient method');

        // Initial validation
        $validatedData = $request->validate([
            'ClientID' => 'required|exists:bookings,ClientID',
            'BookingID' => 'required|exists:bookings,BookingID',
            'DateTimeCancelled' => 'required|date_format:Y-m-d\TH:i',
            'CancelationReason' => 'nullable|integer',
            'CancelationFullname' => 'required|string',
            'CancelationContact' => 'required|string',
            'ContactCancelled' => 'required|string',
            'CancelationPersonEmail' => 'required|email',
        ]);

        // Handle the case where CancelationReason is 0 or null
        if (empty($validatedData['CancelationReason'])) {
            try {
                // Create an instance of ReasonsController
                $reasonsController = new ReasonsController();

                // Call the getReasons method directly
                $reasons = $reasonsController->getReasons(new Request());

                // Check if the request was successful
                return response()->json([
                    'message' => 'CancelationReason is required. Please choose a valid reason.',
                    'cancellation_reasons' => $reasons
                ], 400);
            } catch (\Exception $e) {
                Log::error('An error occurred while fetching cancellation reasons', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'An error occurred while fetching cancellation reasons.', 'error' => $e->getMessage()], 500);
            }
        }

        // Validate the CancelationReason field if provided
        $request->validate([
            'CancelationReason' => 'required|integer',
        ]);

        // Fetch the booking record using ClientID and BookingID
        $booking = Booking::where('ClientID', $validatedData['ClientID'])
            ->where('BookingID', $validatedData['BookingID'])
            ->firstOrFail();

        // Fetch the cancellation reason and check if the usertype is Client
        $reason = Reasons::where('id', $validatedData['CancelationReason'])
            ->where('usertype', 1)
            ->first();

        if (!$reason) {
            return response()->json(['message' => 'Invalid cancellation reason or usertype.'], 422);
        }

        // Check if the booking is confirmed in the table
        if ($booking->IsConfirmedBooking !== -1) {
            return response()->json(['message' => 'Booking is not confirmed, cannot cancel the Booking.'], 422);
        }

        // Ensure the booking is not cancelled by client, agency, or interpreter
        if ($booking->CancelledByClient !== 0) {
            return response()->json(['message' => 'Booking is already cancelled by client.'], 422);
        }
        if ($booking->CancelledByUs == -1) {
            return response()->json(['message' => 'Booking is already cancelled by Agency.'], 422);
        }
        if ($booking->CancelledByInterpreter == -1) {
            return response()->json(['message' => 'Booking is already cancelled by Interpreter.'], 422);
        }

        // Update the booking record in the database
        $booking->update([
            'DateTimeCancelled' => $validatedData['DateTimeCancelled'],
            'CancelationReason' => $validatedData['CancelationReason'],
            'CancelationFullname' => $validatedData['CancelationFullname'],
            'CancelationContact' => $validatedData['CancelationContact'],
            'ContactCancelled' => $validatedData['ContactCancelled'],
            'CancelationPersonEmail' => $validatedData['CancelationPersonEmail'],
            
        ]);

        // Optional: Send an email to the bookings team
        // Mail::to('bookings_team@example.com')->send(new BookingCancelled($booking));
       // Mail::to('bookings@absolute-interpreting.co.uk')->send(new BookingCancelled($booking));
       Mail::to('franklinsrihaas@gmail.com')->send(new BookingCancelled($booking));
        // Return response including the updated booking
        return response()->json([
            'message' => 'Booking successfully updated as Cancelled by Client',
            'booking' => $booking
        ], 200);
    }
        

    public function updateCancelledByAgency(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ClientID' => 'required|exists:bookings,ClientID',
                'BookingID' => 'required|exists:bookings,BookingID',
                'CancelationReason' => 'required|integer',
                'CancelationNote' => 'required|string',
            ]);

          
            // Fetch the booking record using client_id and BookingID
            $booking = Booking::where('ClientID', $validatedData['ClientID'])
                ->where('BookingID', $validatedData['BookingID'])
                ->firstOrFail();

            // Fetch the cancellation reason and check if the usertype is Agency
            $reason = Reasons::where('id', $validatedData['CancelationReason'])
                ->first();

            if (!$reason) {
                return response()->json(['message' => 'Invalid cancellation reason or usertype.'], 422);
            }

            // Check if the booking is confirmed
            if ($booking->IsConfirmedBooking !== -1) {
                return response()->json(['message' => 'Booking is not confirmed, Cannot cancel the Booking.'], 422);
            }

            // Ensure the booking is not cancelled by client, agency, or interpreter
            if ($booking->CancelledByClient !== 0) {
                return response()->json(['message' => 'Booking is already cancelled by client.'], 422);
            }
            if ($booking->CancelledByUs == -1) {
                return response()->json(['message' => 'Booking is already cancelled by Agency.'], 422);
            }
            if ($booking->CancelledByInterpreter == -1) {
                return response()->json(['message' => 'Booking is already cancelled by Interpreter.'], 422);
            }
            
            $booking->update([
                'CancelationReason' => $validatedData['CancelationReason'],
                'CancelationNote' =>  $validatedData['CancelationNote'],
            ]);

           // Mail::to('testtest@gmail.com')->send(new BookingMailUpdate($booking));

            return response()->json(['message' => 'Updated as Cancelled by Agency', 'booking' => $booking], 200);

// After updating the cancelaltion reason and cancelation note we also need to send an EMAIL to the bookings team.(EMAIL through SMTP)

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateCancelledByInterpreter(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ClientID' => 'required|exists:bookings,ClientID',
                'BookingID' => 'required|exists:bookings,BookingID',
                'CancelationReason' => 'required|integer',
                
            ]);
            
            // Fetch the booking record using client_id and BookingID
            $booking = Booking::where('ClientID', $validatedData['ClientID'])
                ->where('BookingID', $validatedData['BookingID'])
                ->firstOrFail();

            // Fetch the cancellation reason and check if the usertype is Interpreter
            $reason = Reasons::where('id', $validatedData['CancelationReason'])
                ->where('usertype', 2)
                ->first();

            if (!$reason) {
                return response()->json(['message' => 'Invalid cancellation reason or usertype.'], 422);
            }

            // Check if the booking is confirmed
            if ($booking->IsConfirmedBooking !== -1) {
                return response()->json(['message' => 'Booking is not confirmed, Cannot cancel the Booking.'], 422);
            }

            // Ensure the booking is not cancelled by client, agency, or interpreter
            if ($booking->CancelledByClient !== 0) {
                return response()->json(['message' => 'Booking is already cancelled by client.'], 422);
            }
            if ($booking->CancelledByUs == -1) {
                return response()->json(['message' => 'Booking is already cancelled by Agency.'], 422);
            }
            if ($booking->CancelledByInterpreter == -1) {
                return response()->json(['message' => 'Booking is already cancelled by Interpreter.'], 422);
            }
            $booking->update([
                 
             
                'CancelationReason' => $validatedData['CancelationReason'],
                
            ]);

           // Mail::to('testtest@gmail.com')->send(new BookingMailUpdate($booking));
            
            return response()->json(['message' => 'Updated as cancelled by Interpreter ', 'booking' => $booking], 200);#

// After updating that the booking is cancelledd by interpreter we also need to send an EMAIL to the bookings team.(EMAIL through SMTP)

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
    public function updateDateTime(Request $request)
    {
        try {
            // Validate both DateOfJOb and TimeOfJob
            $validatedData = $request->validate([
                'ClientID' => 'required|exists:bookings,ClientID',
                'BookingID' => 'required|exists:bookings,BookingID',
                'DateOfJOb' => 'required|date', // Make these nullable if not always required
                'TimeOfJob' => 'required|date_format:H:i',
            ]);

            // Fetch the booking record
            $booking = Booking::where('ClientID', $validatedData['ClientID'])
                ->where('BookingID', $validatedData['BookingID'])
                ->firstOrFail();

            // Update the booking record with provided data
            $updateData = [];
            if (isset($validatedData['DateOfJOb'])) {
                $updateData['DateOfJOb'] = $validatedData['DateOfJOb'];
            }
            if (isset($validatedData['TimeOfJob'])) {
                $updateData['TimeOfJob'] = $validatedData['TimeOfJob'];
            }

            // Update booking if there is any data to update
            if (!empty($updateData)) {
                $booking->update($updateData);
            }

            // Send the email notification
            Mail::to('franklinsrihaas@gmail.com')->send(new BookingDateTimeUpdated(
                $booking,
                $validatedData['DateOfJOb'] ?? null,
                $validatedData['TimeOfJob'] ?? null
            ));
           

            return response()->json(['message' => 'Date and Time updated successfully', 'booking' => $booking], 200);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            Log::error('An error occurred while updating Date and/or Time: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    // Method to update NoOfHoursBooked
    public function updateNoOfHoursBooked(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ClientID' => 'required|exists:bookings,ClientID',
                'BookingID' => 'required|exists:bookings,BookingID',
                'NoOfHoursBooked' => 'required|integer|min:0',
            ]);

            $booking = Booking::where('ClientID', $validatedData['ClientID'])
                ->where('BookingID', $validatedData['BookingID'])
                ->firstOrFail();

            $booking->update(['NoOfHoursBooked' => $validatedData['NoOfHoursBooked']]);

            Mail::to('franklinsrihaas@gmail.com')->send(new NoOfHoursBookedUpdated($booking, $validatedData['ClientID'], $validatedData['BookingID']));

            return response()->json(['message' => 'NoOfHoursBooked updated successfully', 'booking' => $booking], 200);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            Log::error('An error occurred while updating NoOfHoursBooked: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to update address fields
    public function updateAddress(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ClientID' => 'required|exists:bookings,ClientID',
                'BookingID' => 'required|exists:bookings,BookingID',
                'HouseNo' => 'required|string|max:50',
                'BookingAddress1' => 'required|string|max:100',
                'BookingAddress2' => 'required|string|max:100',
                'BookingAddress3' => 'required|string|max:100',
                'BookingAddressPostCode' => 'required|regex:/^[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}$/',
            ]);

            $booking = Booking::where('ClientID', $validatedData['ClientID'])
                ->where('BookingID', $validatedData['BookingID'])
                ->firstOrFail();

            $booking->update([
                'HouseNo' => $validatedData['HouseNo'],
                'BookingAddress1' => $validatedData['BookingAddress1'],
                'BookingAddress2' => $validatedData['BookingAddress2'],
                'BookingAddress3' => $validatedData['BookingAddress3'],
                'BookingAddressPostCode' => $validatedData['BookingAddressPostCode'],
            ]);

            Mail::to('franklinsrihaas@gmail.com')->send(new AddressUpdated($booking, $validatedData['ClientID'], $validatedData['BookingID']));

            return response()->json(['message' => 'Address updated successfully', 'booking' => $booking], 200);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            Log::error('An error occurred while updating address: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    
    
    public function interpreterDidNotAttend(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'ClientID' => 'required|exists:bookings,ClientID',
                'BookingID' => 'required|exists:bookings,BookingID',
            ]);

            // Fetch the booking record using client_id
            $booking = Booking::where('ClientID', $validatedData['ClientID'])->firstOrFail();
            $booking = Booking::where('BookingID', $validatedData['BookingID'])->firstOrFail();

            // Check if the booking is confirmed
            if ($booking->IsConfirmedBooking !== -1) {
                return response()->json(['message' => 'Booking is not confirmed, cannot mark interpreter as did not attend.'], 422);
            }

            // Ensure the booking is not cancelled by client, agency, or interpreter
            if ($booking->CancelledByClient !== 0) {
                return response()->json(['message' => 'Booking is already cancelled by client.'], 422);
            }
            if ($booking->CancelledByUs == -1) {
                return response()->json(['message' => 'Booking is already cancelled by Agency.'], 422);
            }
            if ($booking->CancelledByInterpreter == -1) {
                return response()->json(['message' => 'Booking is already cancelled by Interpreter.'], 422);
            }

            // Validate if the current time is after the scheduled time of the job
            $currentTime = now();
            $scheduledDateTime = $booking->DateOfJOb->setTimeFromTimeString($booking->TimeOfJob);
            
            if ($currentTime < $scheduledDateTime) {
                return response()->json(['message' => 'Cannot mark as DNA before the scheduled time of the job.'], 422);
            }

            // Update the booking record in the database
            $booking->update([
                'DNA' => -1, // Mark interpreter as did not attend
            ]);

            return response()->json(['message' => 'Interpreter marked as did not attend successfully', 'booking' => $booking], 200);

        } catch (ValidationException $e) {
            // If validation fails, capture the errors and respond accordingly
            $errors = $e->errors();
            return response()->json(['message' => 'Validation Error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            // Handle any other exceptions that may occur
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}

?>



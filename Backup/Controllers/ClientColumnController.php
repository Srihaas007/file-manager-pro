<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ClientColumn;

class ClientColumnController extends Controller
{
    public function showForm()
    {
        return view('client_columns');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'BookingID' => 'required|string',
            'ClientID' => 'required|string',
            'IsConfirmedBooking' => 'required|string',
            'IsConfirmedBookingdatatype' => 'required|string',
            'IsConfirmedBookinglength' => 'required|string',
            'IsConfirmedBookingifbool' => 'required|string',
            'IsConfirmedBookingdefault' => 'required|string',
            'CancelledByClient' => 'required|string',
            'CancelledByClientdatatype' => 'required|string',
            'CancelledByClientdefault' => 'required|string',
            'CancelledByClientlength' => 'required|string',
            'CancelledByClientifbool' => 'required|string',
            'CancelledByUs' => 'required|string',
            'CancelledByUsdatatype' => 'required|string',
            'CancelledByUsdefault' => 'required|string',
            'CancelledByUslength' => 'required|string',
            'CancelledByUsifbool' => 'required|string',
            'CancelationReason' => 'required|string',
            'CancelationFullname' => 'required|string',
            'CancelationContact' => 'required|string',
            'ContactCancelled' => 'required|string',
            'CancelationPersonEmail' => 'required|string',
            'DateTimeCancelled' => 'required|string',
            'DNA' => 'required|string',
            'DNAdatatype' => 'required|string',
            'DNAdefault' => 'required|string',
            'DNAlength' => 'required|string',
            'DNAifbool' => 'required|string',
            'ClientDNA' => 'required|string',
            'ClientDNAdatatype' => 'required|string',
            'ClientDNAdefault' => 'required|string',
            'ClientDNAlength' => 'required|string',
            'ClientDNAifbool' => 'required|string',
            'CancelByInterpreter'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $newRecord = ClientColumn::create($request->all());

        return response()->json(['message' => 'Record created successfully', 'data' => $newRecord], 201);
    }
}

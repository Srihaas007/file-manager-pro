<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reasons;
use Illuminate\Validation\ValidationException;

class ReasonsController extends Controller
{
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'id' => 'required|integer',
            'Reasons' => 'required|string',
            'Type' => 'required|string',
            'TypeDefintion' => 'nullable|string',
            'UserType' => 'required|integer',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Create a new Reasons instance and save it to the database
        $reason = new Reasons();
        $reason->id = $validatedData['id'];
        $reason->Reasons = $validatedData['Reasons'];
        $reason->Type = $validatedData['Type'];
        $reason->TypeDefintion = $validatedData['TypeDefintion'];
        $reason->UserType = $validatedData['UserType'];
        $reason->save();

        // Return a success response
        return response()->json(['message' => 'Reason created successfully', 'reason' => $reason], 201);
    }

    public function getReasons(Request $request)
    {
        return Reasons::select('id', 'Reasons', 'Type', 'UserType')
            ->where('UserType', '!=', 4)
            ->get();
    }
}

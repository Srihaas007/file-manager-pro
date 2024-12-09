<?php

namespace App\Http\Controllers;

use App\Models\ClientTable;
use Illuminate\Http\Request;

class ClientTableController extends Controller
{
    public function store(Request $request)
    {
        $clientId = $request->input('client_id');
        $tableName = $request->input('table_name');

        $clientTable = ClientTable::create([
            'client_id' => $clientId,
            'table_name' => $tableName,
        ]);

        return response()->json(['table_id' => $clientTable->id]);
    }
}

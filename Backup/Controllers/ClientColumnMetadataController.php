<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ClientColumnMetadata;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ClientColumnMetadataController extends Controller
{
    public function showForm()
    {
        return view('client_columns_details.create_details');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'columns.*.column_name' => 'required|string',
            'columns.*.data_type' => 'required|string',
            'columns.*.length' => 'nullable|integer',
            'columns.*.is_boolean' => 'boolean',
            'columns.*.nullable' => 'boolean',
            'columns.*.default' => 'nullable|string',
            'columns.*.default_int' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $columns = $request->input('columns', []);

        // Log the received column data for debugging
        Log::info('Received column data:', $columns);

        foreach ($columns as $column) {
            // Prepare the data for storage
            $data = [
                'data_type' => $column['data_type'],
                'length' => $column['length'] ?? null,
                'is_boolean' => isset($column['is_boolean']) ? (bool) $column['is_boolean'] : false,
                'nullable' => isset($column['nullable']) ? 1 : 0, // Convert nullable to 1 or 0
                'default' => $column['data_type'] === 'integer' ? null : ($column['default'] ?? null),
                'default_int' => $column['data_type'] === 'integer' ? ($column['default_int'] ?? null) : null,
            ];

            // Log the data being saved
            Log::info('Saving column data:', $data);

            // Save or update the column metadata
            ClientColumnMetadata::updateOrCreate(
                ['column_name' => $column['column_name']],
                $data
            );
        }

        // Run the schema update command
        Artisan::call('schema:update-client-table');

        return redirect()->route('columns.create')->with('success', 'Columns saved and database updated successfully!');
    }
}

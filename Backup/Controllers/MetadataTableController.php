<?php

namespace App\Http\Controllers;

use App\Models\ClientTable;
use App\Models\MetadataTable;
use App\Models\Column; // Import the Column model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class MetadataTableController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'client_id' => 'required|integer',
            'tables.*.table_name' => 'required|string',
            'tables.*.columns.*.column_name' => 'required|string',
            'tables.*.columns.*.column_value' => 'required|string',
            'tables.*.columns.*.data_type' => 'required|string',
            'tables.*.columns.*.length' => 'nullable|integer',
            'tables.*.columns.*.default' => 'nullable|string',
            'tables.*.columns.*.is_boolean' => 'nullable|boolean',
            'tables.*.columns.*.true_value' => 'nullable|string',
            'tables.*.columns.*.false_value' => 'nullable|string',
            'tables.*.columns.*.nullable' => 'nullable|boolean',
        ]);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Process each table
            foreach ($validated['tables'] as $tableKey => $table) {
                $tableId = ClientTable::create([
                    'client_id' => $validated['client_id'],
                    'table_name' => $table['table_name'],
                ])->id;

                // Process each column in the table
                foreach ($table['columns'] as $column) {
                    // Save metadata details
                    MetadataTable::create([
                        'client_id' => $validated['client_id'],
                        'table_id' => $tableId,
                        'table_name' => $table['table_name'],
                        'column_name' => $column['column_name'],
                        'client_column_name' => $column['column_value'],
                        'data_type' => $column['data_type'],
                        'length' => $column['length'] ?? null,
                        'default' => $column['default'] ?? null,
                        'is_boolean' => $column['is_boolean'] ?? false,
                        'true_value' => $column['true_value'] ?? null,
                        'false_value' => $column['false_value'] ?? null,
                        'nullable' => $column['nullable'] ?? false,
                    ]);

                    // Check if the column name exists in the columns table
                    $columnName = $column['column_name'];
                    if (Schema::hasColumn('columns', $columnName)) {
                        // Update or create the column value
                        Column::updateOrCreate(
                            [
                                'client_id' => $validated['client_id'],
                                'table_id' => $tableId,
                                'table_name' => $table['table_name'],
                            ],
                            [
                                $columnName => $column['column_value']
                            ]
                        );
                    } else {
                        // Handle the case where the column name does not exist
                        // For example, log this information or handle gracefully
                        Log::warning("Column '$columnName' does not exist in 'columns' table.");
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('metadata.index')->with('success', 'Metadata saved successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            return redirect()->route('metadata.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function index()
{
    // Fetch metadata or any other required data
    $metadata = MetadataTable::all(); // Adjust as needed

    // Return the view
    return view('metadata.index', compact('metadata'));
}

}


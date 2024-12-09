<?php
namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\MetadataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ColumnController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'client_id' => 'required|integer',
            'tables.*.table_name' => 'required|string',
            'tables.*.columns.*.column_name' => 'required|string',
            'tables.*.columns.*.column_value' => 'required|string',
            'tables.*.columns.*.data_type' => 'required|string|in:string,integer,boolean',
            'tables.*.columns.*.length' => 'nullable|integer|min:1',
            'tables.*.columns.*.default' => 'nullable|string',
            'tables.*.columns.*.is_boolean' => 'nullable|boolean',
            'tables.*.columns.*.true_value' => 'nullable|string',
            'tables.*.columns.*.false_value' => 'nullable|string',
            'tables.*.columns.*.nullable' => 'nullable|boolean',
        ]);

        // Extract client ID
        $clientId = $validated['client_id'];
        
        // Loop through each table and its columns
        foreach ($validated['tables'] as $tableId => $table) {
            $tableName = $table['table_name'];
            
            foreach ($table['columns'] as $index => $column) {
                $columnName = $column['column_name'];
                $columnValue = $column['column_value'];

                // Validate column name against the database columns
                if (!Schema::hasColumn('columns', $columnName)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Column '$columnName' does not exist in the 'columns' table."
                    ], 400);
                }

                // Save or update column data in the columns table
                Column::updateOrCreate(
                    [
                        'client_id' => $clientId,
                        'table_id' => $tableId,
                        'table_name' => $tableName,
                    ],
                    [
                        'column_name' => $columnName,
                        $columnName => $columnValue,
                    ]
                );

                // Save or update metadata details in the metadata_tables table
                MetadataTable::updateOrCreate(
                    [
                        'client_id' => $clientId,
                        'table_id' => $tableId,
                        'table_name' => $tableName,
                        'column_name' => $columnName,
                    ],
                    [
                        'client_column_name' => $columnValue, // Ensure client_column_name is filled
                        'data_type' => $column['data_type'],
                        'length' => $column['length'] ?? null,
                        'default' => $column['default'] ?? null,
                        'is_boolean' => $column['is_boolean'] ?? false,
                        'true_value' => $column['true_value'] ?? null,
                        'false_value' => $column['false_value'] ?? null,
                        'nullable' => $column['nullable'] ?? false,
                    ]
                );
            }
        }

        return response()->json(['status' => 'success']);
    }
}


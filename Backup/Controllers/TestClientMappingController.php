<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class TestClientMappingController extends Controller
{
    /**
     * Fetch table names, their non-null column values, and metadata for a given client ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function testColumnMapping(Request $request)
    {
        try {
            // Retrieve client ID from the request
            $clientId = $request->input('client_id');
            $remoteHost = '77.68.11.254';
            $remotePort = '3306'; // Use the appropriate port if different
            $remoteDatabase = 'dbportal';
            $remoteUsername = 'admin_john';
            $remotePassword = '0R!9b9db';

            if (!$clientId) {
                return response()->json(['error' => 'Client ID is required.'], 400);
            }

            // Ensure the database connection is set to 'hospital1'
            Config::set('database.connections.mysql.database', 'hospital1');
            DB::reconnect('mysql');

            // Retrieve table names for the given client ID
            $tables = DB::table('clients_tables')
                ->where('client_id', $clientId)
                ->pluck('table_name');

            if ($tables->isEmpty()) {
                Log::error("No tables found for client ID: $clientId");
                return response()->json(['error' => 'No tables found for the given client ID.'], 404);
            }

            // Fetch columns from the 'bookings' table
            $bookingsColumns = DB::getSchemaBuilder()->getColumnListing('bookings');

            // Prepare response data
            $responseData = [];
            $mappings = [];
            $bookingsMapping = [];

            // Fetch all rows from the bookings table for the provided client_id
            $bookingsRows = DB::table('bookings')->where('ClientID', $clientId)->get();

            // Print the rows for debugging
            $bookingsRowsArray = $bookingsRows->toArray();

            foreach ($tables as $tableName) {
                // Retrieve columns information for the current table and client ID
                $columns = DB::table('columns')
                    ->where('client_id', $clientId)
                    ->where('table_name', $tableName)
                    ->first();

                if (!$columns) {
                    Log::error("No columns found for client ID: $clientId and table name: $tableName");
                    $responseData[] = [
                        'table_name' => $tableName,
                        'client_columns' => [],
                    ];
                    continue;
                }

                // Collect non-null column data
                $columnData = [];
                foreach ($columns as $column => $value) {
                    // Skip the following columns
                    if (in_array($column, ['id', 'client_id', 'table_id', 'table_name', 'created_at', 'updated_at'])) {
                        continue;
                    }

                    // Add column if its value is not null
                    if (!is_null($value)) {
                        $columnData[$column] = $value;
                    }
                }

                // Fetch metadata for each column
                $columnMetadata = [];
                $columnMappings = [];
                foreach ($columnData as $columnName => $clientColumnName) {
                    $metadata = DB::table('metadata_tables')
                        ->where('client_id', $clientId)
                        ->where('table_name', $tableName)
                        ->where('column_name', $columnName)
                        ->first();

                    if ($metadata) {
                        $columnMetadata[$columnName] = [
                            'client_column_name' => $clientColumnName,
                            'data_type' => $metadata->data_type,
                            'length' => $metadata->length,
                            'is_boolean' => $metadata->is_boolean,
                            'nullable' => $metadata->nullable,
                            'default' => $metadata->default,
                            'default_int' => $metadata->default_int,
                            'true_value' => $metadata->true_value,
                            'false_value' => $metadata->false_value,
                        ];

                        // Add to column mappings
                        $columnMappings[$columnName] = $clientColumnName;
                    }
                }

                $responseData[] = [
                    'table_name' => $tableName,
                    'client_columns' => $columnMetadata,
                ];

                $mappings[] = [
                    'table_name' => $tableName,
                    'mappings' => $columnMappings
                ];

                // Build dynamic bookings mapping
                $bookingsMapping[$tableName] = [];
                foreach ($bookingsColumns as $bookingColumn) {
                    if (isset($columnData[$bookingColumn])) {
                        $bookingsMapping[$tableName][$bookingColumn] = $columnData[$bookingColumn];
                    }
                }
            }

            // Map all bookings rows
            $mappedBookingsRows = [];
            foreach ($bookingsRowsArray as $row) {
                $mappedRow = [];
                foreach ((array)$row as $column => $value) {
                    foreach ($bookingsMapping as $table => $mapping) {
                        if (isset($mapping[$column])) {
                            $mappedRow[$table][$mapping[$column]] = $value;
                            break; // Stop once we find a mapping
                        }
                    }
                }
                $mappedBookingsRows[] = $mappedRow;
            }

            // Prepare the data for insertion
            $insertData = [];
            foreach ($mappedBookingsRows as $row) {
                foreach ($row as $tableName => $tableData) {
                    if (!isset($insertData[$tableName])) {
                        $insertData[$tableName] = [];
                    }
                    $insertData[$tableName][] = $tableData;
                }
            }

            // Dynamically set the remote connection
            Config::set('database.connections.remote', [
                'driver' => 'mysql',
                'host' => $remoteHost,
                'port' => $remotePort,
                'database' => $remoteDatabase,
                'username' => $remoteUsername,
                'password' => $remotePassword,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);

            // Reconnect to use the remote connection
            DB::purge('remote');
            DB::reconnect('remote');

            // Insert data into the remote database
            foreach ($insertData as $tableName => $rows) {
                DB::connection('remote')->table($tableName)->insert($rows);
            }

            return response()->json([
                'metadata' => $responseData,
                'mappings' => $mappings,
                'bookings_mapping' => $bookingsMapping,
                'bookings_rows' => $mappedBookingsRows // Include all rows
            ]);

        } catch (\Exception $e) {
            // Log the error with a detailed message
            Log::error('Error retrieving client mapping data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while retrieving client mapping data.'], 500);
        }
    }
}

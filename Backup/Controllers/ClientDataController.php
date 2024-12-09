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

            if (!$clientId) {
                return response()->json(['error' => 'Client ID is required.'], 400);
            }

            // Retrieve database connection details for the client
            $clientDbConfig = DB::table('client_databases')->where('client_id', $clientId)->first();

            if (!$clientDbConfig) {
                return response()->json(['error' => 'Client database configuration not found.'], 404);
            }

            // Configure the remote database connection dynamically
            Config::set('database.connections.remote', [
                'driver' => 'mysql',
                'host' => $clientDbConfig->host,
                'port' => $clientDbConfig->port,
                'database' => $clientDbConfig->database,
                'username' => $clientDbConfig->username,
                'password' => $clientDbConfig->password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);
            DB::reconnect('remote');

            // Retrieve table names for the given client ID
            $tables = DB::table('clients_tables')
                ->where('client_id', $clientId)
                ->pluck('table_name');

            if ($tables->isEmpty()) {
                Log::error("No tables found for client ID: $clientId");
                return response()->json(['error' => 'No tables found for the given client ID.'], 404);
            }
            $bookingsColumns = DB::getSchemaBuilder()->getColumnListing('bookings');

            // Fetch all rows from the bookings table for the provided client_id
            $bookingsRows = DB::connection('remote')->table('bookings')->where('ClientID', $clientId)->get();

            // Print the rows for debugging
            $bookingsRowsArray = $bookingsRows->toArray();

            $responseData = [];
            $mappings = [];
            $bookingsMapping = [];

            foreach ($tables as $tableName) {
                // Retrieve column mappings for the current table and client ID
                $columnMappings = DB::table('table_mappings')
                    ->where('client_id', $clientId)
                    ->where('table_name', $tableName)
                    ->pluck('client_column_name', 'column_name');

                if ($columnMappings->isEmpty()) {
                    Log::error("No column mappings found for client ID: $clientId and table name: $tableName");
                    $responseData[] = [
                        'table_name' => $tableName,
                        'client_columns' => [],
                    ];
                    continue;
                }

                // Fetch column metadata for the current table and client ID
                $columnMetadata = DB::table('metadata_tables')
                    ->where('client_id', $clientId)
                    ->where('table_name', $tableName)
                    ->pluck('data_type', 'column_name')
                    ->toArray();

                $metadata = [];
                foreach ($columnMetadata as $columnName => $dataType) {
                    $metadata[$columnName] = [
                        'client_column_name' => $columnMappings[$columnName] ?? '',
                        'data_type' => $dataType,
                        'length' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('length'),
                        'is_boolean' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('is_boolean'),
                        'nullable' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('nullable'),
                        'default' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('default_value'),
                        'default_int' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('default_int'),
                        'true_value' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('true_value'),
                        'false_value' => DB::table('metadata_tables')->where('client_id', $clientId)->where('table_name', $tableName)->where('column_name', $columnName)->value('false_value'),
                    ];
                }

                $responseData[] = [
                    'table_name' => $tableName,
                    'client_columns' => $metadata,
                ];

                $mappings[] = [
                    'table_name' => $tableName,
                    'mappings' => $columnMappings->toArray()
                ];

                // Build dynamic bookings mapping
                $bookingsMapping[$tableName] = [];
                foreach ($bookingsColumns as $bookingColumn) {
                    if (isset($columnMappings[$bookingColumn])) {
                        $bookingsMapping[$tableName][$bookingColumn] = $columnMappings[$bookingColumn];
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
                            $mappedRow[$mapping[$column]] = $value;
                            break; // Stop once we find a mapping
                        }
                    }
                }
                $mappedBookingsRows[] = $mappedRow;
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

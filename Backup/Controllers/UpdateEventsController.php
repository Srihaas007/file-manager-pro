<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class UpdateEventsController extends Controller
{
    
    /**
     * Fetch table names, their non-null column values, and metadata for a given client ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateColumnMapping(Request $request)
    {
        try {
            $clientId = $request->input('client_id');
            $remoteHost = '77.68.11.254';
            $remotePort = '3306';
            $remoteDatabase = 'dbportal';
            $remoteUsername = 'admin_john';
            $remotePassword = '0R!9b9db';

            if (!$clientId) {
                return response()->json(['error' => 'Client ID is required.'], 400);
            }

            Config::set('database.connections.mysql.database', 'hospital1');
            DB::reconnect('mysql');

            $tables = DB::table('clients_tables')
                ->where('client_id', $clientId)
                ->pluck('table_name');

            if ($tables->isEmpty()) {
                Log::error("No tables found for client ID: $clientId");
                return response()->json(['error' => 'No tables found for the given client ID.'], 404);
            }

            $bookingsColumns = DB::getSchemaBuilder()->getColumnListing('bookings');
            $responseData = [];
            $mappings = [];
            $bookingsMapping = [];
            $bookingsRows = DB::table('bookings')->where('ClientID', $clientId)->get();

            foreach ($tables as $tableName) {
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

                $columnData = [];
                foreach ($columns as $column => $value) {
                    if (in_array($column, ['id', 'client_id', 'table_id', 'table_name', 'created_at', 'updated_at'])) {
                        continue;
                    }

                    if (!is_null($value)) {
                        $columnData[$column] = $value;
                    }
                }

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

                $bookingsMapping[$tableName] = [];
                foreach ($bookingsColumns as $bookingColumn) {
                    if (isset($columnData[$bookingColumn])) {
                        $bookingsMapping[$tableName][$bookingColumn] = $columnData[$bookingColumn];
                    }
                }
            }

            $mappedBookingsRows = [];
            foreach ($bookingsRows->toArray() as $row) {
                $mappedRow = [];
                foreach ((array)$row as $column => $value) {
                    foreach ($bookingsMapping as $table => $mapping) {
                        if (isset($mapping[$column])) {
                            $mappedRow[$table][$mapping[$column]] = $value;
                            break;
                        }
                    }
                }
                $mappedBookingsRows[] = $mappedRow;
            }

            $updateData = [];
            foreach ($mappedBookingsRows as $row) {
                foreach ($row as $tableName => $tableData) {
                    if (!isset($updateData[$tableName])) {
                        $updateData[$tableName] = [];
                    }
                    $uniqueIdentifier = $tableData['id'] ?? null;
                    if ($uniqueIdentifier) {
                        $updateData[$tableName][] = [
                            'id' => $uniqueIdentifier,
                            'data' => $tableData
                        ];
                    }
                }
            }

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

            DB::purge('remote');
            DB::reconnect('remote');

            foreach ($updateData as $tableName => $rows) {
                foreach ($rows as $row) {
                    $id = $row['id'];
                    unset($row['id']);
                    DB::connection('remote')->table($tableName)
                        ->where('id', $id)
                        ->update($row['data']);
                }
            }

            return response()->json([
                'metadata' => $responseData,
                'mappings' => $mappings,
                'bookings_mapping' => $bookingsMapping,
                'bookings_rows' => $mappedBookingsRows
            ]);

        } catch (\Exception $e) {
            Log::error('Error retrieving client mapping data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while retrieving client mapping data.'], 500);
        }
    }

    /**
     * Update specific columns in the table based on client ID.
     *
     * @param Request $request
     * @param string $clientId
     * @param array $updateColumns
     * @return \Illuminate\Http\Response
     */
    protected function updateTable(Request $request, $clientId, $updateColumns)
    {
        try {
            // Validate BookingID
            $bookingId = $request->input('BookingID');
            if (!$bookingId) {
                return response()->json(['error' => 'Booking ID is required.'], 400);
            }

            // Fetch the column name for BookingID dynamically
            $bookingIdColumn = DB::table('columns')
                ->where('client_id', $clientId)
                ->where('table_name', 'bookings')
                ->where('column_name', 'BookingID')
                ->value('column_name');

            if (!$bookingIdColumn) {
                return response()->json(['error' => 'BookingID column not found for client ID: ' . $clientId], 404);
            }

            Config::set('database.connections.mysql.database', 'hospital1');
            DB::reconnect('mysql');

            $bookingsRows = DB::table('bookings')->where($bookingIdColumn, $bookingId)->where('ClientID', $clientId)->first();

            if (!$bookingsRows) {
                Log::error("No bookings found with BookingID: $bookingId for client ID: $clientId");
                return response()->json(['error' => 'No bookings found with the given Booking ID.'], 404);
            }

            $updateData = [];
            foreach ($updateColumns as $column) {
                if ($request->has($column)) {
                    $updateData[$column] = $request->input($column);
                }
            }

            if (empty($updateData)) {
                return response()->json(['error' => 'No columns to update.'], 400);
            }

            $remoteHost = '77.68.11.254';
            $remotePort = '3306';
            $remoteDatabase = 'dbportal';
            $remoteUsername = 'admin_john';
            $remotePassword = '0R!9b9db';

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

            DB::purge('remote');
            DB::reconnect('remote');

            DB::connection('remote')->table('bookings')
                ->where($bookingIdColumn, $bookingId)
                ->update($updateData);

            return response()->json(['message' => 'Update successful.']);

        } catch (\Exception $e) {
            Log::error('Error updating bookings data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating bookings data.'], 500);
        }
    }

    public function updateCancelledByClient(Request $request)
    {
        $clientId = $request->input('client_id');
        $updateColumns = [
            'CancelledByClient',
            'CancelationReason',
            'CancelationFullname',
            'CancelationContact',
            'ContactCancelled',
            'CancelationPersonEmail',
        ];

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required.'], 400);
        }

        return $this->updateTable($request, $clientId, $updateColumns);
    }

    public function updateCancelledByUs(Request $request)
    {
        $clientId = $request->input('client_id');
        $updateColumns = [
            'CancelledByUs',
            'CancelationReason',
        ];

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required.'], 400);
        }

        return $this->updateTable($request, $clientId, $updateColumns);
    }

    public function updateCancelByInterpreter(Request $request)
    {
        $clientId = $request->input('client_id');
        $updateColumns = [
            'CancelByInterpreter',
            'CancelationReason',
        ];

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required.'], 400);
        }

        return $this->updateTable($request, $clientId, $updateColumns);
    }

    public function updateDNA(Request $request)
    {
        $clientId = $request->input('client_id');
        $updateColumns = [
            'DNA',
        ];

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required.'], 400);
        }

        return $this->updateTable($request, $clientId, $updateColumns);
    }

    public function updateClientDNA(Request $request)
    {
        $clientId = $request->input('client_id');
        $updateColumns = [
            'ClientDNA',
        ];

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required.'], 400);
        }

        return $this->updateTable($request, $clientId, $updateColumns);
    }

    public function updateIsConfirmedBooking(Request $request)
    {
        $clientId = $request->input('client_id');
        $updateColumns = [
            'IsConfirmedBooking',
        ];

        if (!$clientId) {
            return response()->json(['error' => 'Client ID is required.'], 400);
        }

        return $this->updateTable($request, $clientId, $updateColumns);
    }
}

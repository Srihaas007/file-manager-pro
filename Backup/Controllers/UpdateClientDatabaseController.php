<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ClientDatabaseConfiguration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Capsule\Manager as Capsule;

class UpdateClientDatabaseController extends Controller
{
    /**
     * Update the client database with booking data.
     *
     * @param Booking $booking
     * @return void
     */
    public function updateClientDatabase(Booking $booking)
    {
        // 1. Fetch client metadata
        $clientId = $booking->client_id;

        // Retrieve column names for the client
        $clientColumns = DB::table('columns')
            ->where('client_id', $clientId)
            ->pluck('column_name');

        // Retrieve the client-specific table name
        $tableName = DB::table('clients_tables')
            ->where('client_id', $clientId)
            ->value('table_name');

        // 2. Fetch client database configuration
        $dbConfig = ClientDatabaseConfiguration::where('client_id', $clientId)->first();

        if (!$dbConfig) {
            Log::error("Database configuration for client ID {$clientId} not found.");
            return;
        }

        // 3. Map booking columns to metadata columns
        $mappedData = [];
        foreach ($clientColumns as $columnName) {
            if ($booking->has($columnName)) {
                $mappedData[$columnName] = $booking->$columnName;
            }
        }

        // 4. Push data to the client-specific table
        // Configure database connection dynamically
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => $dbConfig->db_connection,
            'host'      => $dbConfig->db_host,
            'port'      => $dbConfig->db_port,
            'database'  => $dbConfig->db_database,
            'username'  => $dbConfig->db_username,
            'password'  => $dbConfig->db_password,
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Check if the client-specific table exists
        if ($tableName && Schema::connection('client')->hasTable($tableName)) {
            // Insert or update the data in the client-specific table
            Capsule::connection('client')->table($tableName)->updateOrInsert(
                ['id' => $booking->id], // Assumes ID is the primary key
                $mappedData
            );
        } else {
            Log::warning("Client table '{$tableName}' does not exist or is not defined.");
        }
    }
}

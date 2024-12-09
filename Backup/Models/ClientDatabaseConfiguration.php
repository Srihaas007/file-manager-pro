<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDatabaseConfiguration extends Model
{
    protected $fillable = [
        'client_id',
        'db_connection',
        'db_host',
        'db_port',
        'db_database',
        'db_username',
        'db_password',
    ];

    // Define the table name if it's different from the default
    protected $table = 'client_database_configurations';
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $table = 'clients'; // Specify the table name

    protected $primaryKey = 'client_id'; // Specify the primary key

    protected $fillable = [
        'client_id', 'salt', 'api_secret_key', 'api_token', 'is_api_allowed','name'
    ];
    

    protected $hidden = [
        'salt', 'api_token', // these fields are hidden
    ];

    //This function Refreshes the API-Token (deletes the old one and generate the new one)
    public function refreshApiToken()
    {
        $newToken = bin2hex(random_bytes(256)); // Generate a new 256-character token
        $this->api_token = $newToken;
        $this->save(); // Save the new token

        return $this->api_token;
    }

    //here API-Token is converted into an array by default it is hidden 
    public function toArray()
    {
        $attributes = parent::toArray();

        // Hide api_token by default
        unset($attributes['api_token']);

        return $attributes;
    }
}

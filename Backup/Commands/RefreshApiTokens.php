<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;

class RefreshApiTokens extends Command
{
    protected $signature = 'tokens:refresh';

    protected $description = 'Refresh API tokens for all clients';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Client::all()->each(function ($client) {
            $client->refreshApiToken();
        });

        $this->info('API tokens refreshed successfully.');
    }
}

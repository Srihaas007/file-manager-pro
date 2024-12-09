<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiToken = $request->header('Authorization');

        if (!$apiToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Remove "Bearer " from the token
        $apiToken = str_replace('Bearer ', '', $apiToken);

        $client = Client::where('api_token', $apiToken)->first();

        if (!$client) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Check if API access is allowed for the client
        if (!$client->is_api_allowed) {
            return response()->json(['message' => 'API access is Denied'], 401);
        }

        // Set the authenticated client in the request
        $request->merge(['authenticated_client' => $client]);

        return $next($request);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    // app/Http/Controllers/ClientController.php
    public function showClientDetails(Request $request)
    {
        $clientId = $request->input('client_id');
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json([
            'client_id' => $client->client_id,
            'name' => $client->name,
        ]);
    }


    public function register(Request $request)
    {
        try {
            $request->validate([
                'client_id' => 'required|integer|unique:clients|digits_between:1,10',
            ]);

            $salt = bin2hex(random_bytes(8));
            $api_secret_key = Hash::make($request->client_id . $salt);
            $api_token = bin2hex(random_bytes(256));

            $client = Client::create([
                'client_id' => $request->client_id,
                'salt' => $salt,
                'api_secret_key' => $api_secret_key,
                'api_token' => $api_token,
            ]);

            $message = 'Client registered successfully';

            return View::make('register')->with(compact('message', 'client'));

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register client. Please try again.'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'client_id' => 'required|integer|digits_between:1,10',
                'api_secret_key' => 'required',
            ]);

            $client = Client::where('client_id', $request->client_id)->first();

            if (!$client) {
                throw ValidationException::withMessages([
                    'client_id' => ['The provided credentials are incorrect.'],
                ]);
            }

            if ($client->is_api_allowed !== -1) {
                throw ValidationException::withMessages([
                    'api_secret_key' => ['API access is currently disabled.'],
                ]);
            }

            if ($request->api_secret_key !== $client->api_secret_key) {
                throw ValidationException::withMessages([
                    'api_secret_key' => ['The provided credentials are incorrect.'],
                ]);
            }

            $response = [
                'message' => 'Login successful',
                'client' => $client,
                'token' => $client->api_token,
                'client_id' => $client->client_id,
            ];

            return view('login', $response);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to login. Please try again.'], 500);
        }
    }

    public function stopApiAccess(Request $request)
    {
        $clientId = $request->input('client_id');

        $client = Client::where('client_id', $clientId)->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->is_api_allowed = 0;
        $client->save();

        return response()->json(['message' => 'API access stopped successfully']);
    }

    public function startApiAccess(Request $request)
    {
        $clientId = $request->input('client_id');

        $client = Client::where('client_id', $clientId)->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->is_api_allowed = -1;
        $client->save();

        return response()->json(['message' => 'API access started successfully']);
    }

    public function logout(Request $request)
    {
        $client = $request->input('authenticated_client');
        $client->api_token = null;
        $client->api_secret_key = null;
        $client->salt = null;
        $client->save();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json($request->input('authenticated_client'));
    }
}

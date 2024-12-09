
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\ClientColumnController;
use App\Http\Controllers\ClientColumnMetadataController;
use App\Http\Controllers\MetadataTableController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\TestClientMappingController;
use App\Http\Controllers\UpdateEventsController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route for 'index' method of MetadataTableController



Route::get('/two-communication-api-doc', function () {
    return view('TwoCommunicationAPIDoc');
});


//we get the reason for the cancellation here in an array
Route::get('/getReasons', [ReasonsController::class, 'getReasons']);

//admin both way documentation
Route::get('/metadata/api-docs', function () {
    return view('metadata.API_Documentation');
});

//client one way documentation route
Route::get('/client-api-documentation', function () {
    return view('ClientApiDocumentation'); // Ensure this matches the name of your Blade view file
});

// These are two way communication 
Route::post('/update/cancelled-by-client', [UpdateEventsController::class, 'updateColumnMapping']);
Route::post('/update/cancelled-by-us', [UpdateEventsController::class, 'updateCancelledByUs']);
Route::post('/update/cancel-by-interpreter', [UpdateEventsController::class, 'updateCancelByInterpreter']);
Route::post('/update/dna', [UpdateEventsController::class, 'updateDNA']);
Route::post('/update/client-dna', [UpdateEventsController::class, 'updateClientDNA']);
Route::post('/update/is-confirmed-booking', [UpdateEventsController::class, 'updateIsConfirmedBooking']);

//fetching the client details in Register, Start APi access, End API access in the form 
Route::post('/client/showClientDetails', [ClientController::class, 'showClientDetails'])->name('client.showClientDetails');

//this is where we store the column names from the client input
Route::post('/columns', [ColumnController::class, 'store']);


Route::post('/test-column-mapping', [TestClientMappingController::class, 'testColumnMapping']);

Route::get('/create-metadata-table', function () {
    return view('metadata.create_metadata_table');
});

Route::post('/metadata/store', [MetadataTableController::class, 'store'])->name('metadata.store');
Route::get('/metadata', [MetadataTableController::class, 'index'])->name('metadata.index');

Route::get('/check-columns', function () {
    $columns = Schema::getColumnListing('client');
    return response()->json($columns);
});

Route::get('/columns/create', [ClientColumnMetadataController::class, 'showForm'])->name('columns.create');
Route::post('/columns/store', [ClientColumnMetadataController::class, 'store'])->name('columns.store');



Route::post('/clients/register', [ClientController::class, 'register'])->name('client.register');
Route::get('/client/register', [ClientController::class, 'showRegisterForm'])->name('client.showRegisterForm');

Route::post('/clients/login', [ClientController::class, 'login'])->name('client.login');
Route::get('/client/login', [ClientController::class, 'showLoginForm'])->name('client.showLoginForm');

// Route to stop API access
Route::post('/clients/stop-api-access', [ClientController::class, 'stopApiAccess'])->name('client.stopApiAccess');
Route::get('/clients/stop-api-access', [ClientController::class, 'stopApiAccess'])->name('client.stopApiAccess');

// Route to start API access
Route::post('/clients/start-api-access', [ClientController::class, 'startApiAccess'])->name('client.startApiAccess');
Route::get('/clients/start-api-access', [ClientController::class, 'startApiAccess'])->name('client.startApiAccess');

Route::post('/client-columns', [ClientColumnController::class, 'store']);
Route::get('/client-columns/{clientId}', [ClientColumnController::class, 'show']);
Route::put('/client-columns/{clientId}', [ClientColumnController::class, 'update']);
Route::delete('/client-columns/{clientId}', [ClientColumnController::class, 'destroy']);
Route::get('/client-columns-form', [ClientColumnController::class, 'showForm'])->name('client-columns-form');

Route::middleware('api.token')->group(function () {
    //logout function remove the API-Secret-Key so the client cannot login
    Route::post('/clients/logout', [ClientController::class, 'logout']);
    //storing the client as user
    Route::get('/clients/user', [ClientController::class, 'user']);
    //we store new booking here
    Route::post('/bookings', [BookingController::class, 'store']);
    //updates the previous booking as CancelledByClient
    Route::post('/updatecancelledbyclient', [BookingController::class, 'updateCancelledByClient']);
    //updates the previous booking as Interpreter did not attend
    Route::post('/interpreterdidnotattend', [BookingController::class, 'interpreterdidnotattend']);
    //updates the previous booking as CancelledByAgency
    Route::post('/updatecancelledbyagency', [BookingController::class, 'updateCancelledByAgency']);
    //updates the previous booking as CancelledByInterpreter
    Route::post('/updatecancelledbyinterpreter', [BookingController::class, 'updateCancelledByInterpreter']);
    // Route to update DateOfJOb and/or TimeOfJob
    Route::post('/booking/update-date-time', [BookingController::class, 'updateDateTime']);
    // Route to update NoOfHoursBooked
    Route::post('/booking/update-no-of-hours-booked', [BookingController::class, 'updateNoOfHoursBooked']);
    // Route to update address fields
    Route::post('/booking/update-address', [BookingController::class, 'updateAddress']);
    
   

});


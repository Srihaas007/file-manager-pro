<?php
// server.php
 
error_reporting(E_ALL);
ini_set('display_errors', 1);
 require_once '../../../page_fragment/define.php';
include '../../../page_fragment/dbConnect.php';
include '../../../page_fragment/dbGeneral.php';
include '../../../page_fragment/njGeneral.php';
include '../../Config.php';
$statusFile = __DIR__ .'./calling_status.txt';
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
	
 $BookingID= isset($_POST["BookingID"]) ? $_POST["BookingID"] : '';
 

 
 
// Endpoint to handle incoming push notification requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON input from the request

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    // Check if the required fields are present in the request
    if (  true) {
        
     
        // Send push notification to the topic
		       
		   
 
$sqlLinguistic = "SELECT * FROM Bookings WHERE BookingID = '$BookingID'"  ;
$resultLinguistic = $conn->query($sqlLinguistic);
		
		 $rowLinguistic = $resultLinguistic->fetch_assoc();
		 
    $ClientID = $rowLinguistic['ClientID'];
		 $InterpreterID= $rowLinguistic['InterpreterID'];
		  $Language1ID= $rowLinguistic['Language1ID'];
		  $DateOfJOb= $rowLinguistic['DateOfJOb'];
		  $TimeOfJob= $rowLinguistic['TimeOfJob'];

		
         $notification = [
    "title" => "Booking Confirrmation",
    "body" => "As requested, bookingID $BookingID, on Date '$DateOfJOb' at '$TimeOfJob' has been assigned to you"
];
 
		 
			 $topic1 = '/topics/'.$ClientID ;
		 $topic2 = '/topics/'.$InterpreterID;
		
           // sendPushNotification($topic1, $notification);
   sendPushNotification($topic2, $notification);
       
    }
}
 

// Function to send a push notification to a topic using the FCM API
function sendPushNotification($topic, $notification) {
 
    $url = 'https://fcm.googleapis.com/fcm/send';

    $headers = [
        'Authorization: key=' . FIREBASE_API_KEY,
        'Content-Type: application/json',
    ];

    $data = [
        'to' => $topic,
        'notification' => $notification,
    ];

    $options = [
        'http' => [
            'header' => implode("\r\n", $headers),
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
	
  

// Check for errors in the response
if ($result === FALSE) {
    $error = error_get_last();
    echo 'Error sending push notification: ' . $error['message'];
} else {
    // Success
    echo 'Push notification sent successfully to '.$topic;
    // Log the response for further analysis
    // You can log $result, which contains the response from FCM
}
}

mysqli_close($conn);
?>

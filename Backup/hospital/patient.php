<?php

 
// MySQL database connection settings
require_once '../../../page_fragment/define.php';
include('../../../page_fragment/dbConnect.php');
include('../../../page_fragment/dbGeneral.php');
include('../../../page_fragment/njGeneral.php');

$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the POST request has been made and contains 'client_id'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ClientID'])) {
    $client_id = $_POST['ClientID'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE ClientID = ? and IsPatientNotificationSent = 0 and PatientNotificationResponse = 0  and DateOfJOb >= CURDATE()  ");
    $stmt->bind_param("i", $client_id); 
    
    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();
	$resultArrays=array();
    if ($result->num_rows > 0) {
        // Fetch associative array and dump it
        while($row = $result->fetch_assoc()) {
             
        	$resultArrays[] = array(
						'ClientID' => $row['ClientID'],
						'DateOfJOb' => $row['DateOfJOb'],
						'TimeOfJob' => $row['TimeOfJob'],
						'InterpreterID' => $row['InterpreterID'],
						'IsPatientNotificationSent' => $row['IsPatientNotificationSent'],
						'PatientNotificationResponse' => $row['PatientNotificationResponse'],					 
					);
        }
    } else {
        echo "0 results";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No client ID provided or invalid request method.";
}

	$response = array(
 
			 "Bookings"=>$resultArrays
		);

	echo json_encode($response);
// Closing the database connection
$conn->close();
?>
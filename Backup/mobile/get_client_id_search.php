<?php 
require_once("inc/connections.php");
$db = new DbConnect();
$conn = $db->connect();


		
	$client_sql= "SELECT Bookings.ClientID FROM Bookings INNER JOIN Clients ON Bookings.ClientID = Clients.ClientID 
		WHERE DateOfJOb >= CURDATE() AND IsConfirmedBooking = 0 AND CancelledByClient = 0 AND DoubleBookingDetected = 0 GROUP BY ClientID";
	$query= mysqli_query($conn,$client_sql)or die(mysqli_error());
	$rowcount = 0;
	while($select_timesheet_row = mysqli_fetch_assoc($query)) 
	{
		$rowcount = $rowcount + 1;
		$response['result'][] = $select_timesheet_row; 
		$response['error'] = false;
	}
	
	
	die(json_encode($response));

?>
<?php
// MySQL database connection settings
$servername = "127.0.0.1";
$port = 3037; 
$username = "user1";
$password = "password@123";
$dbname = "hospital";

// database connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM languages ");
    
    
    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();
	$resultArrays=array();
    if ($result->num_rows > 0) {
        // Fetch associative array and dump it
        while($row = $result->fetch_assoc()) {
             
        	$resultArrays[] = array(
						'LanguageId' => $row['LanguageId'],
						'LanguageName' => $row['LanguageName'],
										 
					);
                }
            } else {
                echo "0 results";
            }
        
            // Close the statement
            $stmt->close();
        
            $response = array(
         
                     "Bookings"=>$resultArrays
                );
        
            echo json_encode($response);
// Closing the database connection


// Closing the database connection
$conn->close();
?>

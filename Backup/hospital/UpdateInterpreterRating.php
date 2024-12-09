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

// Check if something is submitted and process update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $boostlingoid = isset($_POST['boostlingoid']) ? $_POST['boostlingoid'] : "";
    $RatingByInterpreter = isset($_POST['RatingByInterpreter']) ? $_POST['RatingByInterpreter'] : "";

    // Validate input 
    if (!empty($boostlingoid) && !empty($RatingByInterpreter)) {

        // Checking if boostlingoid exists in the database
        $stmt_check = $conn->prepare("SELECT boostlingoid FROM callreports WHERE boostlingoid = ?");
        $stmt_check->bind_param("s", $boostlingoid);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // if Boostlingoid exists, proceed with update
            $stmt_check->close();

            // SQL statement for update
            $sql = "UPDATE callreports SET RatingByInterpreter=? WHERE boostlingoid=?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bind the parameters
                $stmt->bind_param("ss", $RatingByInterpreter, $boostlingoid);

                // Execute statement
                if ($stmt->execute()) {
                    echo "Record with ID $boostlingoid updated successfully. ";
                } else {
                    echo "Error updating record with ID $boostlingoid: " . $stmt->error . "<br>";
                }
            } else {
                echo "Error preparing statement: " . $conn->error . "<br>";
            }
        } else {
            // if Boostlingoid does not exist in the database
            echo "ID $boostlingoid does not exist in the database. Skipping update.";
        }
    } else {
        echo "Please provide both boostlingoid and RatingByInterpreter.";
    }
} else {
    echo "Form not submitted.";
}

// Closing the database connection
$conn->close();
?>

<?php
$response = []; 
// Function to clean and sanitize filename
function cleanFilename($filename) {
    // Remove any directory traversal sequences
    $filename = preg_replace('/\.\.\//', '', $filename);
    // Remove any non-word characters (leaving '-' and '_')
    $filename = preg_replace('/[^\w\-\.]/', '', $filename);
    return $filename;
}

// Check if the form was submitted for file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Directory where uploaded files will be saved
    $uploadDir = 'uploads/';

    // Create uploads directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory with full permissions
    }

    // Check if a file was uploaded without errors
    if ($_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {
        // Get the filename and sanitize it
        $filename = cleanFilename($_FILES['csvFile']['name']);
        $uploadFile = $uploadDir . $filename;
        
        // Check if file already exists
        if (file_exists($uploadFile)) {
            while(file_exists($uploadFile)) {
                $uploadFile = $uploadFile.date('mdYHis').".csv" ;
            };
            //die("Error: File already exists.");
        }

        // Check file extension (only allow .csv)
        $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($fileType != "csv") {
            $response['error'] = "Error: Only CSV files are allowed.";
        }

        // Move uploaded file to designated directory
        if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $uploadFile)) {
            $response['message'] = "File <strong>" . htmlspecialchars($filename) . " has been uploaded successfully.";

            // Process the uploaded CSV file
            processCSVFile($uploadFile); // Call function to process CSV
        } else {
            $response['error'] = "Error: There was an error uploading your file.";
        }
    } else {
        $response['error'] ="Error: " . $_FILES['csvFile']['error'];
    }
}

// Function to process the uploaded CSV file
function processCSVFile($csvFilePath) {
    // MySQL database connection settings
    $servername = "127.0.0.1";
    $port = 3037;
    $username = "user1";
    $password = "password@123";
    $dbname = "hospital";

    // Attempt MySQL database connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        $response['error'] = "Connection failed: " . $conn->connect_error;
    }

    // Mapping between CSV column names and database column names
    $columnMapping = [
        'boostlingoid' => '﻿﻿Call Id',
        'NoOfHrsCharged' => 'Duration',
        'WaitingTimeBeforeCallConnectionToInterpreter' => 'Queue Time (s)',
        'CallStatusBackup' => 'Call Status',
        'ConferenceDurationMinutes' => 'Conference Duration',
        'OtherParticipants' => 'Other Participants'
    ];

    try {
        // Open the CSV file
        if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
            // Read the header row
            $header = fgetcsv($handle);

            // Clean up header names from invisible characters
            foreach ($header as &$column) {
                $column = trim($column);
            }

            // Check if all expected keys are present in the header row
            $missingKeys = array_diff(array_values($columnMapping), $header);
            if (!empty($missingKeys)) {
                $response['error'] = "Error: Missing column(s) in CSV file: " . implode(', ', $missingKeys);
            }

            // Find the index of the Call Id column
            $callIdIndex = array_search('﻿﻿Call Id', $header);

            // Check if the Call Id column exists
            if ($callIdIndex === FALSE) {
                $response['error'] = "Call Id column not found in CSV file";
            }

            // Iterate through each row in the CSV
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Get the Call Id value from the row
                $callId = $data[$callIdIndex];
                // Convert the Call Id to a numeric string to avoid scientific notation
                $callId = sprintf('%0.0f', $callId);

                // Create an associative array for the row data
                $rowData = array_combine($header, $data);

                // Extract relevant fields based on column mapping
                $boostlingoid = $callId;
                $duration = $rowData['Duration'];
                $queueTime = $rowData['Queue Time (s)'];
                $otherParticipants = $rowData['Other Participants'];
                $conferenceDuration = $rowData['Conference Duration'];
                $callStatus = $rowData['Call Status'];

                // Fetch record from database based on boostlingoid (or Call Id)
                $sql = "SELECT * FROM callreports WHERE boostlingoid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $callId); // Assuming boostlingoid is stored in the database as a string
                $stmt->execute();
                $result = $stmt->get_result();
                $dbRecord = $result->fetch_assoc();

                // Perform operations based on the fetched record
                if ($dbRecord) {
                    // Check conditions to determine if update is needed
                    $isBackupUsed = $dbRecord['IsBackupUsed'];
                    $callType = $dbRecord['CallType'];
                    $dbCallStatus = $dbRecord['CallStatus'];

                    if ($isBackupUsed == 'Yes' && $callType == 'video' && $dbCallStatus == 'yes') {
                        // Update database record with CSV data
                        $updateSql = "
                            UPDATE callreports
                            SET NoOfHrsCharged = ?, 
                                WaitingTimeBeforeCallConnectionToInterpreter = ?, 
                                CallStatusBackup = ?, 
                                ConferenceDurationMinutes = ?, 
                                OtherParticipants = ?
                            WHERE boostlingoid = ?
                        ";

                        $updateStmt = $conn->prepare($updateSql);
                        $updateStmt->bind_param(
                            "ssssss",
                            $duration,
                            $queueTime,
                            $callStatus,
                            $conferenceDuration,
                            $otherParticipants,
                            $boostlingoid
                        );
                        $updateStmt->execute();

                        if ($updateStmt->affected_rows > 0) {
                            $response['message'] = "Updated record for boostlingoid $boostlingoid";
                        } else {
                            $response['message'] = "No changes made for boostlingoid $boostlingoid";
                        }
                        $updateStmt->close();
                    }
                }
            }

            fclose($handle);
        } else {
            $response['error'] = "Error opening CSV file";
        }

    } catch (Exception $e) {
        $response['error'] = "Error processing CSV or updating database: " . $e->getMessage();
    }

    // Close the database connection
    $conn->close();
}

echo json_encode($response);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV File</title>
</head>
<body>
    <h2>Upload CSV File</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="csvFile" accept=".csv" required>
        <br><br>
        <input type="submit" name="submit" value="Upload">
        <h4>File Format is only .csv </h4>
    </form>
</body>
</html>

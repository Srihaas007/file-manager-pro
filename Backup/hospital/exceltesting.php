<?php
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
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle Excel file processing
function handleExcelProcessing($conn) {
    // Specify the path to your Excel file
    $excelFilePath = "C:/xampp3/htdocs/hospital/exceltesting.xlsx"; // Adjust this path

    // Check if the file exists
    if (!file_exists($excelFilePath)) {
        die("Excel file not found at: $excelFilePath");
    }

    // Loading the Excel file using PhpSpreadsheet
    require 'vendor/autoload.php'; // Adjust path to autoload.php if necessary
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFilePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();

    // Defining the database columns
    $dbColumns = ['ID', 'Duration', 'NumberofParticipants', 'MainName', 'BackUp']; // Adjust according to your table

    // As column names are in the first row of the Excel sheet
    $excelColumns = [];
    foreach ($worksheet->getRowIterator(1, 1) as $row) {
        $cellIterator = $row->getCellIterator();
        foreach ($cellIterator as $cell) {
            $excelColumns[] = $cell->getValue();
        }
    }

    // Verifying the column names
    if (array_diff($excelColumns, $dbColumns) == array_diff($dbColumns, $excelColumns)) {
        // if the Column names matches, proceeding with updating the database
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
            
            // The first column is 'ID' and other columns follow
            $ID = $rowData[0];
            $Duration = $rowData[1];
            $NumberofParticipants = $rowData[2];
            $MainName = $rowData[3];
            $BackUp = $rowData[4];

            // Checking if ID exists in the database
            $sql_check = "SELECT ID FROM exceltesting WHERE ID = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("i", $ID);
            $stmt_check->execute();
            $stmt_check->store_result();
            $num_rows = $stmt_check->num_rows;
            
            if ($num_rows > 0) {
                // executing SQL statement
                //$sql = "UPDATE OnDemand SET Duration=?, QueTime=?, ConferenceDuration=?, OtherParticipants=?, CallStatus=?, WHERE ID=? and isBackupused=? and CallType=? ";
                $sql = "UPDATE exceltesting SET Duration=?, NumberofParticipants=?, MainName=?, BackUp=? WHERE ID=? ";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sissi", $Duration, $NumberofParticipants, $MainName, $BackUp, $ID);
                
                if ($stmt->execute()) {
                    echo "Record with ID $ID updated successfully.<br>";
                } else {
                    echo "Error updating record with ID $ID: " . $conn->error . "<br>";
                }
            } else {
                echo "ID $ID does not exist in the database. Skipping update.<br>";
            }
        }
    } else {
        echo "Column names do not match.";
    }
}

// Call the function to handle Excel file processing
handleExcelProcessing($conn);

// Close connection
$conn->close();
?>

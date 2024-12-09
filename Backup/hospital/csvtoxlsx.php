<?php
// Path to your CSV file
$csvFile = 'C:\\xampp3\\htdocs\\hospital\\OnDemandLog.csv';

// Open the file for reading
if (($handle = fopen($csvFile, 'r')) !== FALSE) {
    // Read the header row
    $header = fgetcsv($handle, 1000, ',');

    // Clean up header names from invisible characters
    foreach ($header as &$column) {
        $column = trim($column);
    }

    // Find the index of the Call Id column
    $callIdIndex = array_search('﻿﻿Call Id', $header);

    // Check if the Call Id column exists
    if ($callIdIndex === FALSE) {
        die("Call Id column not found in CSV file");
    }

    // Read the data rows
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        // Get the Call Id value from the row
        $callId = $data[$callIdIndex];

        // Convert the Call Id to a numeric string to avoid scientific notation
        $callId = sprintf('%0.0f', $callId);

        // Output the Call Id (or match it against your database)
        echo "Call Id: " . $callId . "\n";
        
        // Here, you can add your database matching logic
        // For example:
        // $query = "SELECT * FROM your_table WHERE call_id = ?";
        // $stmt = $pdo->prepare($query);
        // $stmt->execute([$callId]);
        // $result = $stmt->fetch();
        // if ($result) {
        //     // Do something with the result
        // }
    }

    // Close the file
    fclose($handle);
} else {
    die("Unable to open CSV file");
}
?>

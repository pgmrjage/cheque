<?php
require "accDB.php"; // Ensure this file establishes the $conn connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['dvNumber'])) {
    $dvNumber = $_GET['dvNumber'];
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($select_printing_details);
    $stmt->bind_param("s", $dvNumber);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // Convert amount to float
            $data['FINAL_AMOUNT'] = (float)$data['FINAL_AMOUNT'];

            // Convert date from mm/dd/yyyy to yyyy-mm-dd
            $date = DateTime::createFromFormat('m/d/Y H:i:s', $data['CHECK_DATE']);
            if ($date !== false) {
                $data['CHECK_DATE'] = $date->format('Y-m-d');
            } else {
                $data['CHECK_DATE'] = null; // Handle invalid date format
            }

            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No details found for this DV number']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to execute query']);
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'DV number not provided']);
}
?>

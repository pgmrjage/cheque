<?php

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountCode = $_POST['accountCode'];

    // Prepare and execute the query to fetch the last check and DV numbers for the given account code
    $stmt = $conn->prepare("SELECT check_number, dv_number
                            FROM tbcheckrecords 
                            WHERE account_code = ? 
                            ORDER BY check_id DESC 
                            LIMIT 1");
    $stmt->bind_param("s", $accountCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if any results were returned and send back as JSON
    if ($row) {
        echo json_encode([
            'checkNumber' => $row['check_number'] + 1,
            'dvNumber' => $row['dv_number'],
        ]);
    } else {
        echo json_encode([
            'checkNumber' => '',
            'dvNumber' => '',
        ]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

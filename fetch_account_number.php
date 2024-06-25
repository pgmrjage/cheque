<?php
// Include the database connection file
require 'database.php';

if (isset($_POST['accountCode'])) {
    $accountCode = $_POST['accountCode'];
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT account_number FROM tbbankaccount WHERE account_code = ?");
    $stmt->bind_param("s", $accountCode);
    
    // Execute the query
    $stmt->execute();
    $stmt->bind_result($accountNumber);
    $stmt->fetch();
    
    echo $accountNumber;
    
    $stmt->close();
    $conn->close();
}
?>

<?php
require "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $accountCode = $conn->real_escape_string($_POST['accountCode']);
    $accountNumber = $conn->real_escape_string($_POST['accountNumber']);
    $checkNumber = $conn->real_escape_string($_POST['checkNumber']);
    $payee = $conn->real_escape_string($_POST['payee']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $amountWords = $conn->real_escape_string($_POST['amountWords']);
    $chequeDate = $conn->real_escape_string($_POST['chequeDate']);
    $dvNumber = $conn->real_escape_string($_POST['dvNumber']);

    if ($accountCode === "addNew") {
        $newAccountCode = $_POST['newAccountCode'];
        // Insert the new account code and account number into tbbankaccount table
        $sql = "INSERT INTO tbbankaccount (account_code, account_number) VALUES ('$newAccountCode', '$accountNumber')";
        if ($conn->query($sql) === TRUE) {
            $accountCode = $newAccountCode; // Use the new account code for the rest of the form processing
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Insert data into database
    $sql = "INSERT INTO tbcheckrecords (check_number, amount, date, payee, dv_number, account_code) 
            VALUES ('$checkNumber', '$amount', '$chequeDate', '$payee', '$dvNumber', '$accountCode')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
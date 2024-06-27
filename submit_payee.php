<?php
require "database.php";

$payee = $_POST['payee'];
$sql = "SELECT name FROM tbpayee WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $payee);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Payee already exists.";
} else {
    $sql = "INSERT INTO tbpayee (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $payee);
    if ($stmt->execute()) {
        echo "Payee added successfully.";
    } else {
        echo "Error adding payee: " . $conn->error;
    }
}

$conn->close();
?>

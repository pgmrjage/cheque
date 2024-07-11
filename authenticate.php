<?php
session_start();
require "database.php";

$inputUsername = $_POST['username'];
$inputPassword = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM account WHERE username = ?");
$stmt->bind_param("s", $inputUsername);
$stmt->execute();
$stmt->store_result();

$response = ['success' => false];

if ($stmt->num_rows > 0) {
    $stmt->bind_result($passwordHash);
    $stmt->fetch();

    if ($inputPassword === $passwordHash) {  // Use password_verify() if passwords are hashed
        $_SESSION['username'] = $inputUsername;
        $response['success'] = true;
        $response['redirectURL'] = 'cheque.php';
    }
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>

<?php
require "database.php";

if (isset($_POST['check_number'])) {
    $check_number = $_POST['check_number'];

    // Database connection
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM tbcheckrecords WHERE check_id= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $check_number);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No record ID provided";
}
?>

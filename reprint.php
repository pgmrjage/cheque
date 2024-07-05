<?php
require "database.php";

if (isset($_POST['check_number'])) {
    $check_number = $_POST['check_number'];

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM tbcheckrecords WHERE check_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $check_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<tr id='record-" . $row["check_id"] . "'>";
                echo "<td>" . $row["check_number"] . "</td>";
                echo "<td>" . $row["payee"] . "</td>";
                echo "<td>" . $row["amount"] . "</td>";
                $date = new DateTime($row["date"]);
                echo "<td>" . $date->format('m/d/Y') . "</td>";
                echo "<td>" . $row["dv_number"] . "</td>";
                echo "<td>" . $row["account_code"] . "</td>";
                echo "<td class='action-btn-container'>";
    }

    $stmt->close();
    $conn->close();
}
?>

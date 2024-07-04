<?php
require "database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_number = $_POST['check_number'];

    $sql = "SELECT * FROM tbcheckrecords WHERE check_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $check_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $chequeData = array(
            "account_code" => $row["account_code"],
            "payee" => $row["payee"],
            "amount" => $row["amount"],
            "amount_words" => $row["amount_words"], // Assuming you have the amount in words
            "date" => (new DateTime($row["date"]))->format('m/d/Y'),
            "dv_number" => $row["dv_number"],
            "check_number" => $row["check_number"]
        );

        echo json_encode($chequeData);
    } else {
        echo json_encode(array("error" => "No record found for Check Number: " . $check_number));
    }

    $stmt->close();
    $conn->close();
}
?>

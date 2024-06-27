<?php
require "database.php";

$term = $_GET['term'];
$sql = "SELECT name FROM tbpayee WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%".$term."%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$payees = array();
while ($row = $result->fetch_assoc()) {
    $payees[] = $row['name'];
}

echo json_encode($payees);

$conn->close();
?>

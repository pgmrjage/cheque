<?php
require "accDB.php";

$term = $_GET['term'];
$sql = "SELECT DV_NUMBER FROM cheque_view WHERE DV_NUMBER LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);
$searchTerm = "%".$term."%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$dvNo = array();
while ($row = $result->fetch_assoc()) {
    $dvNo[] = $row['DV_NUMBER'];
}

echo json_encode($dvNo);

$conn->close();
?>

<?php
require "database.php";

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$entries = isset($_GET['entries']) ? $_GET['entries'] : 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Ensure $entries is an integer or 'all'
$entries = $entries === 'all' ? 'all' : intval($entries);

$start = ($page - 1) * $entries;
$entriesQuery = ($entries === 'all') ? '' : "LIMIT $start, $entries";

$searchQuery = $search ? "WHERE check_number LIKE '%$search%' OR payee LIKE '%$search%' OR amount LIKE '%$search%' OR date LIKE '%$search%' OR dv_number LIKE '%$search%' OR account_number LIKE '%$search%'" : '';

// Fetch data with search and pagination
$sql = "
    SELECT check_id, check_number, payee, amount, date, dv_number, account_number
    FROM tbcheckrecords 
    $searchQuery
    ORDER BY check_id DESC
    $entriesQuery
";
$result = $conn->query($sql);

$records = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = [
            'check_id' => $row['check_id'],
            'check_number' => $row['check_number'],
            'payee' => $row['payee'],
            'amount' => $row['amount'],
            'date' => (new DateTime($row['date']))->format('m/d/Y'),
            'dv_number' => $row['dv_number'],
            'account_number' => $row['account_number'],
        ];
    }
}

// Fetch total records count for pagination
$sqlCount = "SELECT COUNT(*) AS total FROM tbcheckrecords $searchQuery";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount ? $resultCount->fetch_assoc() : ['total' => 0];
$totalItems = $rowCount['total'];
$totalPages = ($entries === 'all') ? 1 : ceil($totalItems / $entries);

$conn->close();

echo json_encode([
    'records' => $records,
    'totalPages' => $totalPages
]);
?>

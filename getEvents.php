<?php
header('Content-Type: application/json');
require "database.php";
// Database connection parameters


// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch events
    $stmt = $pdo->prepare("SELECT date FROM tbcheckrecords"); // Adjust query according to your table
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Format events into a JSON object
    $eventCount = array_count_values($events);
    echo json_encode($eventCount);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_number = $_POST['check_number'];
    
    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Delete the record
    $sql = "DELETE FROM checks WHERE check_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $check_number);
    $stmt->execute();
    
    // Close the database connection
    $stmt->close();
    $conn->close();
    
    // Redirect to the main page
    header('Location: your_main_page.php');
    exit();
}
?>

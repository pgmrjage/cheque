<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_number = $_POST['check_number'];
    
    // Retrieve the check details from the database
    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM checks WHERE check_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $check_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Output the check details for reprinting
        // This is where you would include your code to reprint the check
        // For example, you could output the check details in a printable format
        echo "Check Number: " . $row["check_number"] . "<br>";
        echo "Payee: " . $row["payee"] . "<br>";
        echo "Amount: " . $row["amount"] . "<br>";
        $date = new DateTime($row["date"]);
        echo "Date: " . $date->format('m/d/Y') . "<br>";
        echo "DV Number: " . $row["dv_number"] . "<br>";
        echo "Account Code: " . $row["account_code"] . "<br>";
        // Add your reprint logic here
    } else {
        echo "No record found for Check Number: " . $check_number;
    }
    
    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

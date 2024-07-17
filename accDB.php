<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hail_hydra";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Queries on Accounting Database
$select_printing_details = "SELECT BANK, BANK_ACCTNO, CHECK_NUMBER, PAYEE, FINAL_AMOUNT, CHECK_DATE FROM cheque_view WHERE YEAR(STR_TO_DATE(CHECK_DATE, '%c/%e/%Y %H:%i:%s')) = YEAR(CURDATE()) AND DV_NUMBER = ?";
$select_dv_numbers = "SELECT DV_NUMBER FROM cheque_view WHERE YEAR(STR_TO_DATE(CHECK_DATE, '%c/%e/%Y %H:%i:%s')) = YEAR(CURDATE()) AND DV_NUMBER LIKE ? LIMIT 10"
?>
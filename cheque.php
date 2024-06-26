<?php
// Include the database connection file
require 'database.php';

// Query to fetch account codes
$sql = "SELECT account_code FROM tbbankaccount";
$result = $conn->query($sql);

$options = '';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row["account_code"] . '">' . $row["account_code"] . '</option>';
    }
} else {
    $options = '<option value="">No data found</option>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cheque_styles.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <title>Cheque Printing System</title>
        
    
</head>
<body>

<div class="tab-container">
  <div class="tab active" onclick="openTab(event, 'tab1')">Print</div>
  <div class="tab" onclick="openTab(event, 'tab2')">History</div>
  <div class="tab" onclick="openTab(event, 'tab3')">Summary</div>
</div>


<!-- TAB 1 - PRINTING CHEQUE SECTION -->
<div id="tab1" class="tab-content active">
<div class="cheque_container">
    <h2>Cheque Printing System</h2>

    <form id="chequeForm">
        <div class="form-group">
            <label for="accountCode">Account Code</label>
            <select name="accountCode" id="accountCodeInput" onchange="toggleNewAccountInput()">
                <option value = "addNew">Add New Account Number</option>
                <?php echo $options; ?>
            </select>
        </div>

        <!-- HIDDEN INPUT BOX -->
        <div class="form-group hidden" id="newAccountInputGroup">
            <label for="newAccountCode">New Account Code</label>
            <input type="text" id="newAccountCode" name="newAccountCode">
        </div>
        
        <div class="form-group">
            <label for="accountNumber">Account Number:</label>
            <input type="text" id="accountNumberInput" name="accountNumber" required readonly>
        </div>
        <div class="form-group">
            <label for="checkNumber">Check Number:</label>
            <input type="text" id="checkNumberInput" name="checkNumber" required>
        </div>
        <div class="form-group">
            <label for="payee">Payee:</label>
            <input type="text" id="payeeInput" name="payee" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amountInput" name="amount" step="0.01" oninput="updateAmountInWords()" required>
        </div>
        <div class="form-group">
            <label for="amountWords">Amount (in words):</label>
            <input type="text" id="amountWordsInput" name="amountWords" readonly required>
        </div>
        <div class="form-group">
            <label for="chequeDate">Date:</label>
            <input type="date" id="chequeDateInput" name="chequeDate" required>
        </div>
        <div class="form-group">
            <label for="dvNumber">DV Number:</label>
            <input type="text" id="dvNumberInput" name="dvNumber" required>
            <p hidden id="lastdvused"></p>
        </div>
        <button type="button" class="styled-button" onclick="save_and_print()">Print and Save</button>
    </form>
    <div id="responseMessage" style="display:none;"></div>

    <div id="cheque">
        <div class="cheque-field" id="accountNumber"></div>
        <div class="cheque-field" id="payee"></div>
        <div class="cheque-field" id="amount"></div>
        <div class="cheque-field" id="amountWords"></div>
        <div class="cheque-field" id="chequeDate"></div>
        <div class="cheque-field" id="dvNumber"></div>
        <div class="cheque-field" id="checkNumber"></div>
    </div>
</div>
</div>



<!-- TAB 2 - HISTORY SECTION -->
<div id="tab2" class="tab-content">
    <div class="history_container">
        <h2>Logs</h2>
        <div class="search">
            <input type="text" class="searchinput" placeholder="Type your text">
            <button class="searchbutton">
                <svg class="searchicon" aria-hidden="true" viewBox="0 0 24 24">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
            </button>
        </div>

        <?php
        require "database.php";     
        // Include the database connection
        // Fetch data from the database
        $sql = "SELECT check_id, check_number, payee, amount, date, dv_number, account_code FROM tbcheckrecords";
        $result = $conn->query($sql);
        ?>

        <table>
        <thead>
            <tr>
                
                <th>Cheque Number</th>
                <th>Payee</th>
                <th>Amount</th>
                <th>Date</th>
                <th>DV Number</th>
                <th>Account Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["check_number"] . "</td>";
                echo "<td>" . $row["payee"] . "</td>";
                echo "<td>" . $row["amount"] . "</td>";
                $date = new DateTime($row["date"]);
                echo "<td>" . $date->format('m/d/Y') . "</td>";
                echo "<td>" . $row["dv_number"] . "</td>";
                echo "<td>" . $row["account_code"] . "</td>";
                echo "<td class='action-btn-container'>";
                echo "<form method='post' action='reprint.php' class='action-button-green'>
                        <input type='hidden' name='check_number' value='" . $row["check_number"] . "'>
                        <button type='submit'>Reprint</button>
                        </form>";
                echo "<form method='post' action='delete.php' class='action-button-red'>
                        <input type='hidden' name='check_number' value='" . $row["check_number"] . "'>
                        <button type='submit'>Delete</button>
                        </form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        // Close the database connection
        $conn->close();
        ?>
            
            
        </tbody>
    </table>

    </div>
</div>


<!-- TAB 3 - SUMMARY SECTION -->
<div id="tab3" class="tab-content">
    <div class="summary_container">
        <h2>Summary Report</h2>

        <div class="calendar-container">
        <table class="calendar">
            <thead>
                <tr class="header">
                    <th colspan="7">
                        <button onclick="prevMonth()">&#10094;</button>
                        <span id="monthYear"></span>
                        <button onclick="nextMonth()">&#10095;</button>
                    </th>
                </tr>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody id="calendarBody">
                <!-- Calendar body will be dynamically generated -->
            </tbody>
        </table>
        <div class="summary">
            <h3>Summary for <span id="summaryMonth"></span></h3>
            <p>Total: <span id="#">0</span></p>
        </div>
    </div>
        
    

    </div>
</div>

<script src="script.js"></script>

</body>
</html>

<?php
    session_start();
    $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="cheque_styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <title>Cheque Printing System</title>
        
    
</head>
<body>

<header class="mainHeader">
    <div class="header-left">
        <img src="gsclogo.png" width="50px" height="50px" id="logo-details">
        <h1 class="title-header">CTO-CPS</h1>
    </div>
    <div class="header-right">
        <span class="username">Welcome, <?php echo "$username";?></span>
        <span class="material-symbols-outlined" onclick="confirmLogout()">Logout</span>
    </div>
</header>


<div class="whole-container">



<div class="tab-container">
  <div class="tab active" onclick="openTab(event, 'tab1')">Print</div>
  <div class="tab" onclick="openTab(event, 'tab2')">History</div>
  <div class="tab" onclick="openTab(event, 'tab3')">Summary</div>
</div>


<!-- TAB 1 - PRINTING CHEQUE SECTION -->

    <div id="tab1" class="tab-content active">
    <div class="cheque_container">
        <h2>Cheque Information:</h2>

        <form id="chequeForm">
        <div class="form-group">
            <label for="dvNumber">DV Number:</label>
            <input type="text" id="dvNumberInput" name="dvNumber" required>
        </div>  
        <div class="form-group">
            <label for="accountNumber">Account Number:</label>
            <input type="text" id="accountNumberInput" name="accountNumber" readonly required>
        </div>
        <div class="form-group">
            <label for="checkNumber">Check Number:</label>
            <input type="text" id="checkNumberInput" name="checkNumber" readonly required>
        </div>
        <div class="form-group">
            <label for="payee">Payee:</label>
            <input type="text" id="payeeInput" name="payee" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amountInput" name="amount" step="0.01" readonly required>
        </div>
        <div class="form-group">
            <label for="amountWords">Amount (<i>in words</i>):</label>
            <input type="text" id="amountWordsInput" name="amountWords" readonly required>
        </div>
        <div class="form-group">
            <label for="chequeDate">Date:</label>
            <input type="date" id="chequeDateInput" name="chequeDate" readonly required>
        </div>
        <button type="submit" class="styled-button" onclick="save_and_print()">Print</button>
        <!-- <button type="submit" class="styled-button" onclick="save_only()">Save only</button> -->
        </form>

        <!-- SNACKBAR || TOAST NOTIF -->
        <!-- The actual snackbar -->
        <div id="snackbar">Data has been saved</div>

        <div id="responseMessage" style="display:none;"></div>

        <h2>Cheque Preview:</h2>
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

                <div class="history-table-header">

                
                    <!-- Filter options -->
                    <div class="filter">
                        <label for="entries">Show entries:</label>
                        <select id="entries" onchange="updateEntries()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <!-- Search bar -->
                    <div class="search">
                        <input type="text" class="searchinput" placeholder="Type your text" id="searchvalue" onkeyup="searching()">
                        <button class="searchbutton">
                            <svg class="searchicon" aria-hidden="true" viewBox="0 0 24 24">
                                <g>
                                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                                </g>
                            </svg>
                        </button>
                    </div>

                </div>
            

                    <!-- Data table -->
                    <div class="container-table">
                        <div class="table-wrapper">
                            <table id="scrollable-table">
                                <thead>
                                    <tr>
                                        <th>Cheque Number</th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>DV Number</th>
                                        <th>Account Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <!-- Data will be loaded here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>


                        <div class="history-table-footer">
                            <!-- Pagination -->
                            <div class="pagination" id="pagination">
                                <a href="#" id="prev-page">Previous</a>
                                <span id="page-numbers"></span>
                                <a href="#" id="next-page">Next</a>
                                <!-- <input type="number" id="page-input" min="1" max="" placeholder="Page"> -->
                            </div>

                            <!-- Jump to page input -->
                            <!-- <div class="jump-to-page">
                                Jump to page number: <input type="number" id="page-input" min="1" max="" placeholder="Page">
                            </div> -->

                            <!-- Showing entries count -->
                            <div class="entries-count" id="entries-count">
                                Showing <span id="start-entry"></span> to <span id="end-entry"></span> of <span id="total-entries"></span> entries
                            </div>
                        </div>
                </div>
        </div>



        <!-- TAB 3 - SUMMARY SECTION -->
    <div id="tab3" class="tab-content">
        <div class="summary_container">
            <h2>Summary Report</h2>

            <div class="calendar-container">
            <table class="calendar">
                <thead>
                    <tr class="calendar-header">
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
                <p>Monthly Total: <span id="monthlyTotal">0</span></p>
                <h3>Annual Summary for <span id="summaryYear"></span></h3>
                <p>Total: <span id="annualTotal">0</span></p>
            </div>  

        </div>
        
        <div id="tblreport">
                <h3>Monthly and Annual Report</h3>
                <table id="reportTable">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    
                    <tbody id="reportBody">
                        <!-- Report body will be dynamically generated -->
                    </tbody>

                    <thead>
                        <tr>
                            <th>Annual</th>
                            <th><span id="annualTotal2">0</span></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <button id="printreport-btn" onclick="printReport()">Print Report</button>
    </div>
</div>




<script src="script.js"></script>

</div>
</body>
</html>

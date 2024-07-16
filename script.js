// TOP SCRIPT
//payee start
$(function() {
    $("#dvNumberInput").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "getDvNo.php",
                type: "GET",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            // Code to execute when an item is selected
            //console.log("Selected item: ", ui.item.value);
            fetchDetails(ui.item.value);
        }
    });
});

$("#chequeForm").submit(function(event) {
    event.preventDefault();
    $.ajax({
        url: "submit_payee.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(data) {
            //alert(data);
        }
    });
});
//payee end


//dv num and cheque num history




// BOTTOM SCRIPT


function openTab(evt, tabName) {
    // Get all elements with class="tab-content" and hide them
    
    var tabContents = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
    }

    // Get all elements with class="tab" and remove the class "active"
    var tabs = document.getElementsByClassName("tab");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].className = tabs[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";

    // Store the active tab in local storage
    localStorage.setItem("activeTab", tabName);
    
}



// Show the default tab
document.addEventListener("DOMContentLoaded", function() {
    var defaultTab = localStorage.getItem("activeTab") || "tab2"; // Default to 'History' tab if none is set
    var defaultTabButton = document.querySelector(".tab[onclick=\"openTab(event, '" + defaultTab + "')\"]");

    if (defaultTabButton) {
        defaultTabButton.click();
    }
});







function numberToWords(num) {
        const belowTwenty = [
            'Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];
        const tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];
        const thousands = [
            '', 'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion', 'Quintillion'
        ];

        if (num === 0) return 'Zero';
        if (num < 0) return 'Negative ' + numberToWords(Math.abs(num));

        let word = '';
        let i = 0;

        while (num > 0) {
            if (num % 1000 !== 0) {
                word = helper(num % 1000) + thousands[i] + ' ' + word;
            }
            num = Math.floor(num / 1000);
            i++;
        }

        return word.trim();
    }

    function helper(num) {
        const belowTwenty = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];
        const tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        let word = '';

        if (num < 20) {
            word = belowTwenty[num] + ' ';
        } else if (num < 100) {
            word = tens[Math.floor(num / 10)] + ' ' + belowTwenty[num % 10] + ' ';
        } else {
            word = belowTwenty[Math.floor(num / 100)] + ' Hundred ' + helper(num % 100);
        }

        return word.trim() + ' ';
    }

    function updateAmountInWords() {
        const amountInput = document.getElementById('amountInput').value;
        const amountWordsInput = document.getElementById('amountWordsInput');

        if (amountInput) {
            const parts = amountInput.split('.');
            const pesos = parseInt(parts[0]);
            const cents = parts[1] ? parseInt(parts[1]) : 0;

            let words = numberToWords(pesos) + ' Pesos'; 
            if (cents > 0) {
                words += ' and ' + numberToWords(cents) + ' Centavos' + ' Only';
            }

            amountWordsInput.value = words;
        } else {
            amountWordsInput.value = '';
        }
    }


    function generateCheque() {
        var printContent = document.getElementById("cheque").innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        
        var style = document.createElement('style');
        style.innerHTML = '@page { size: landscape; margin-top: 100px; position: absolute; top: 0; left: 0; width: 100%; height: auto; }';
        document.head.appendChild(style);

        window.print();
        document.body.innerHTML = originalContent;
        document.head.removeChild(style);
        
    }
    
    document.getElementById('accountNumberInput').addEventListener('input', updateCheque);
    document.getElementById('checkNumberInput').addEventListener('input', updateCheque);
    document.getElementById('payeeInput').addEventListener('input', updateCheque);
    document.getElementById('amountInput').addEventListener('input', function() {
        updateAmountInWords();
        updateCheque();
    });
    document.getElementById('chequeDateInput').addEventListener('input', updateCheque);
    document.getElementById('dvNumberInput').addEventListener('input', updateCheque);
    function updateCheque() {
        const accountNumber = document.getElementById('accountNumberInput').value;
        const checkNumber = document.getElementById('checkNumberInput').value;
        const payee = document.getElementById('payeeInput').value;
        const amount = document.getElementById('amountInput').value;
        const amountWords = document.getElementById('amountWordsInput').value;
        const chequeDate = document.getElementById('chequeDateInput').value;
        const dvNumber = document.getElementById('dvNumberInput').value;

        document.getElementById('accountNumber').innerText = accountNumber;
        document.getElementById('checkNumber').innerText = checkNumber;
        document.getElementById('payee').innerText = "*** " + payee + " ***";
        document.getElementById('amount').innerText = parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('amountWords').innerText = amountWords;
        document.getElementById('chequeDate').innerText = formatDate(chequeDate);
        document.getElementById('dvNumber').innerText = dvNumber;
    }    

        

    function formatDate(inputDate) {
        const date = new Date(inputDate);
        const day = ("0" + date.getDate()).slice(-2);
        const month = ("0" + (date.getMonth() + 1)).slice(-2);
        const year = date.getFullYear();
        return `${month} ${day} ${year}`;
    }


    


    // JS FOR SUMMARY
    // ===================================
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let events = {}; // Object to store events, keyed by date string

    document.addEventListener('DOMContentLoaded', () => {
        fetchEvents();
    });
    
    function fetchEvents() {
        fetch('getEvents.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error fetching events:', data.error);
                    return;
                }
                events = {};
                for (let key in data) {
                    let date = key.split(' ')[0]; // Get the date part only
                    events[date] = data[key];
                }
                console.log(events);
                generateCalendar(currentMonth, currentYear);
            })
            .catch(error => console.error('Fetch error:', error));
            
    }
    
    function generateCalendar(month, year) {
        const firstDay = (new Date(year, month)).getDay();
        const daysInMonth = 32 - new Date(year, month, 32).getDate();
        const tbl = document.getElementById("calendarBody");
    
        tbl.innerHTML = "";
    
        let date = 1;
        for (let i = 0; i < 6; i++) {
            let row = document.createElement("tr");
    
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    let cell = document.createElement("td");
                    let cellText = document.createTextNode("");
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                } else if (date > daysInMonth) {
                    break;
                } else {
                    let cell = document.createElement("td");
                // Ensure date format matches YYYY-MM-DD
                    let formattedDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;
                    cell.setAttribute('data-date', formattedDate);
                    //cell.addEventListener('click', () => addEvent(cell));
                    let cellText = document.createTextNode(date);
                    cell.appendChild(cellText);
    
                    let eventCount = events[formattedDate];
                    if (eventCount > 0) {
                        let eventBadge = document.createElement("span");
                        eventBadge.className = "event";
                        eventBadge.textContent = ` (${eventCount})`;
                        cell.appendChild(eventBadge);
                    }
    
                    if (date === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth()) {
                        cell.classList.add("today");
                    }
                    row.appendChild(cell);
                    date++;
                }
            }
            tbl.appendChild(row);
        }
    
        document.getElementById("monthYear").innerText = `${monthNames[month]} ${year}`;
        document.getElementById("summaryMonth").innerText = `${monthNames[month]} ${year}`;
        document.getElementById("summaryYear").innerText = `${year}`;
        updateSummary(month, year);
        updateReportTable(year);
    }

 

function updateSummary(month, year) {
    let monthlyTotal = 0;
    let annualTotal = 0;

    for (let date in events) {
        let [eventYear, eventMonth] = date.split('-').map(Number);
        if (eventYear === year) {
            annualTotal += events[date];
            if (eventMonth === month + 1) {
                monthlyTotal += events[date];
            }
        }
    }

    document.getElementById("monthlyTotal").innerText = monthlyTotal;
    document.getElementById("annualTotal").innerText = annualTotal;
    document.getElementById("annualTotal2").innerText = annualTotal;
}

function updateReportTable(year) {
    const reportBody = document.getElementById("reportBody");
    reportBody.innerHTML = "";

    for (let month = 0; month < 12; month++) {
        let monthlyTotal = 0;
        for (let date in events) {
            let [eventYear, eventMonth] = date.split('-').map(Number);
            if (eventYear === year && eventMonth === month + 1) {
                monthlyTotal += events[date];
            }
        }

        let row = document.createElement("tr");
        let cellMonth = document.createElement("td");
        let cellTotal = document.createElement("td");
        cellMonth.textContent = monthNames[month];
        cellTotal.textContent = monthlyTotal;

        row.appendChild(cellMonth);
        row.appendChild(cellTotal);
        reportBody.appendChild(row);
    }
}

function prevMonth() {
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    currentYear = (currentMonth === 11) ? currentYear - 1 : currentYear;
    generateCalendar(currentMonth, currentYear);
}

function nextMonth() {
    currentMonth = (currentMonth === 11) ? 0 : currentMonth + 1;
    currentYear = (currentMonth === 0) ? currentYear + 1 : currentYear;
    generateCalendar(currentMonth, currentYear);
}

document.addEventListener('DOMContentLoaded', function () {
    generateCalendar(currentMonth, currentYear);
});




    // ajax for saving form
    
    function saveFormData() {
        var form = document.getElementById('chequeForm');
        var formData = new FormData(form);
    
        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "submit_cheque.php", true);
    
        // Define a callback function to handle the response
        xhr.onload = function () {
            var responseMessage = document.getElementById('responseMessage');
            if (xhr.status === 200) {
                responseMessage.innerHTML = xhr.responseText;
                responseMessage.style.display = 'block';
                responseMessage.style.color = 'green';
            } else {
                responseMessage.innerHTML = 'An error occurred!';
                responseMessage.style.display = 'block';
                responseMessage.style.color = 'red';
            }
            
            // Hide the message after 3 seconds
            setTimeout(function() {
                responseMessage.style.display = 'none';
            }, 300000);
        };
    
        // Send the form data
        xhr.send(formData);
    }


    function save_and_print(){
        if(document.getElementById("amountInput").value.trim() === "")
            alert("invalid input");
        else
        {
            saveFormData();
            generateCheque();  
            // Save the state to session storage
            sessionStorage.setItem('showSnackbar', 'true');
            location.reload();
        }
    }
    function save_only(){
        if(document.getElementById("amountInput").value.trim() === "")
            alert("invalid input");
        else
        {
            saveFormData();
            sessionStorage.setItem('showSnackbar', 'true');
            location.reload();
        }
    }
    //for the snackbar after the page reloaded
    window.onload = function() {
        if (sessionStorage.getItem('showSnackbar') === 'true') {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            // Clear the session storage flag
            sessionStorage.removeItem('showSnackbar');
        }
    };
        



    // JS FOR ADDING NEW ACCOUNT NUMBER
    // =============================================






    // JS FOR SEARCH BOX
    // =============================================
    // =============================================
    function searching(){
        // Declare variables
        var input, filter, table, tr,td, i, txtValue;
        input = document.getElementById("searchvalue");
        filter = input.value.toUpperCase();
        table = document.getElementById("scrollable-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i=1; i<tr.length; i++){
            td = tr[i].getElementsByTagName("td");
            tr[i].style.display = "none";
            for (j=0; j<td.length; j++)
                {
                    if (td[j]){
                        txtValue = td[j].textContent || td[j].innerText
                        if (txtValue.toUpperCase().indexOf(filter) > -1){
                            tr[i].style.display = "";  
                            break;
                        }
                    }
                }
        }

        // FOR REFERENCE USE
        // for (i = 1; i < tr.length; i++) {
        //     td = tr[i].getElementsByTagName("td");
        //     tr[i].style.display = "none";
        //     // Only check the text content of the first and second td (index 0 and 1)
        //     for (var j = 0; j < 2; j++) {
        //         txtValue = td[j].textContent || td[j].innerText;
        //         if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //             tr[i].style.display = "";
        //             break;
        //         }
        //     }
        // }

    }
    




    // JS FOR SUMMARY PRINT REPORT
    function printReport(){
        var printContent = document.getElementById("tblreport").innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;

        var style = document.createElement('style');
        style.innerHTML = '@page { size: portrait; max-width: 75%; height: auto; margin: 50px;  }';
        document.head.appendChild(style);

        window.print();
        
        
        document.body.innerHTML = originalContent;
        document.head.removeChild(style);
    }




    // JS FOR SET CURRENT OR DEFAULT DATE
    // document.addEventListener('DOMContentLoaded', (event) => {
    //     const dateInput = document.getElementById('chequeDateInput');
    //     const today = new Date().toISOString().split('T')[0];
    //     dateInput.value = today;
    // });

        function setCurrentDate() {
        const dateInput = document.getElementById('chequeDateInput');
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    }





    // JS FOR PRINT AGAIN BUTTON IN HISTORY TAB
    //function printchequeHistory(checkNumber) {
        // $.ajax({
        //     url: 'reprint.php',
        //     type: 'POST',
        //     data: { check_number: checkNumber },
        //     success: function(response) {
        //         var chequeData = JSON.parse(response);

        //         document.getElementById('accountNumber').innerText = chequeData.account_code;
        //         document.getElementById('payee').innerText = chequeData.payee;
        //         document.getElementById('amount').innerText = chequeData.amount;
        //         document.getElementById('amountWords').innerText = chequeData.amount_words; // Assuming you have the amount in words
        //         document.getElementById('chequeDate').innerText = chequeData.date;
        //         document.getElementById('dvNumber').innerText = chequeData.dv_number;
        //         document.getElementById('checkNumber').innerText = chequeData.check_number;

                
        //     }
        // });
        // generateCheque();

        function printchequeHistory(chequeNum) {
            var content = document.getElementById(chequeNum);
            var printContent = content.innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            
            var style = document.createElement('style');
            style.innerHTML = '@page { size: landscape; margin-top: 100px; position: absolute; top: 0; left: 0; width: 100%; height: auto; }';
            document.head.appendChild(style);
    
            window.print();
            
            
            document.body.innerHTML = originalContent;
            document.head.removeChild(style);
    }

    //deleting a record
    function deleteRecord(checkNumber) {
        if (confirm('Are you sure you want to delete this record?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_record.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
            xhr.onload = function() {
                if (xhr.status === 200) {
                    //alert(xhr.responseText);
                    // Remove the deleted record from the list
                    var recordElement = document.getElementById('record-' + checkNumber);
                    if (recordElement) {
                        recordElement.remove();
                    }
                } else {
                    alert('An error occurred while deleting the record.');
                }
            };
    
            xhr.send('check_number=' + checkNumber);
        }
    }

    // NO PURPOSE CODE
    //amount to words for reprint
    // function numberToWords(amount) {
    //     const ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    //     const teens = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    //     const tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    
    //     // Function to convert a number less than 1000 to words
    //     function convertLessThanOneThousand(num) {
    //         let words = '';
    //         if (num >= 100) {
    //             words += ones[Math.floor(num / 100)] + ' hundred ';
    //             num %= 100;
    //         }
    //         if (num >= 20) {
    //             words += tens[Math.floor(num / 10)] + ' ';
    //             num %= 10;
    //         }
    //         if (num >= 10) {
    //             words += teens[num - 10] + ' ';
    //             num = 0;
    //         }
    //         if (num > 0) {
    //             words += ones[num] + ' ';
    //         }
    //         return words.trim();
    //     }
    
    //     // Function to convert the decimal part (cents) to words
    //     function convertCents(cents) {
    //         if (cents === 0) {
    //             return 'zero cents';
    //         } else if (cents === 1) {
    //             return 'one cent';
    //         } else {
    //             return convertLessThanOneThousand(cents) + ' cents';
    //         }
    //     }
    
    //     // Split amount into integer and decimal parts
    //     let integerPart = Math.floor(amount);
    //     let decimalPart = Math.round((amount - integerPart) * 100);
    
    //     // Convert integer part to words
    //     let words = convertLessThanOneThousand(integerPart) + ' pesos';
    
    //     // Convert decimal part to words
    //     if (decimalPart > 0) {
    //         words += ' and ' + convertCents(decimalPart);
    //     }
    
    //     return words;
    // }


    //hail hydra database retrieval
    document.getElementById('dvNumberInput').addEventListener('change', function() {
        var dvNumber = this.value;
        //if (event.key === 'Enter' || event.key === 'Tab') {
            fetchDetails(dvNumber);
        //}
    });
    document.getElementById('dvNumberInput').addEventListener('input', function() {
        var dvNumber = this.value;
        //if (event.key === 'Enter' || event.key === 'Tab') {
            fetchDetails(dvNumber);
        //}
    });
    
    function fetchDetails(dvNumber) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetchDetails.php?dvNumber=' + dvNumber, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    
                    document.getElementById('accountNumberInput').value = response.data.BANK_ACCTNO;
                    document.getElementById('checkNumberInput').value = response.data.CHECK_NUMBER;
                    document.getElementById('payeeInput').value = response.data.PAYEE.toUpperCase();
                    document.getElementById('amountInput').value = response.data.FINAL_AMOUNT;
                    //document.getElementById('chequeDateInput').value = response.data.CHECK_DATE;
                    updateAmountInWords();
                    setCurrentDate();
                    updateCheque();
                } else {
                    //alert('No details found for this DV number');
                    document.getElementById('accountNumberInput').value = 'No details found for this DV number';
                    document.getElementById('checkNumberInput').value = 'No details found for this DV number';
                    document.getElementById('payeeInput').value = 'No details found for this DV number';
                    document.getElementById('amountInput').value = null;
                }
            }
        };
        xhr.send();
    }



    //LOGGING OUT
    function confirmLogout() {
        const confirmation = confirm("Are you sure you want to log out?");
        if (confirmation) {
            logout();
        }
    }

    function logout() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'logout.php', true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.href = 'index.php';
            }
        };

        xhr.send();
    }
    
    



    // JS FOR SHOW PASSWORD

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var showPassCheckbox = document.getElementById('showPass');
        
        if (showPassCheckbox.checked) {
          passwordInput.type = 'text';
        } else {
          passwordInput.type = 'password';
        }
      }


    // function showpassword(){
    //     document.getElementById('showPass').click();
    //     var x = document.getElementById("password");
    //     if (x.type === "password"){
    //         x.type = "text";
    //     }else{
    //         x.type = "password";
    //     }
    // }

    
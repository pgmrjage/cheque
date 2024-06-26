// TOP SCRIPT

        $(document).ready(function(){
            $('#accountCodeInput').change(function(){
                var accountCode = $(this).val();
                if(accountCode) {
                    $.ajax({
                        type: 'POST',
                        url: 'fetch_account_number.php',
                        data: {accountCode: accountCode},
                        success: function(response){
                            $('#accountNumberInput').val(response);
                        }
                    });
                } else {
                    $('#accountNumberInput').val('');
                }
            });
        });
    



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
}






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
        
        window.print();
    }
    document.getElementById('accountNumberInput').addEventListener('input', updateCheque);
    document.getElementById('checkNumberInput').addEventListener('input', updateCheque);
    document.getElementById('payeeInput').addEventListener('input', updateCheque);
    document.getElementById('amountInput').addEventListener('input', updateCheque);
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
        document.getElementById('payee').innerText = payee;
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
                    cell.setAttribute('data-date', `${year}-${month + 1}-${date}`);
                    cell.addEventListener('click', () => addEvent(cell));
                    let cellText = document.createTextNode(date);
                    cell.appendChild(cellText);

                    let eventCount = events[`${year}-${month + 1}-${date}`] || 0;
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
        updateSummary();
    }

    function addEvent(cell) {
        let date = cell.getAttribute('data-date');
        if (!events[date]) {
            events[date] = 0;
        }
        events[date]++;
        generateCalendar(currentMonth, currentYear);
    }

    function updateSummary() {
        let totalEvents = Object.values(events).reduce((sum, val) => sum + val, 0);
        document.getElementById("totalEvents").innerText = totalEvents;
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









    // JS FOR ADDING NEW ACCOUNT NUMBER
    // =============================================
    function toggleNewAccountInput() {
        var select = document.getElementById("accountCodeInput");
        var newAccountInputGroup = document.getElementById("newAccountInputGroup");

        if (select.value === "addNew") {
            newAccountInputGroup.classList.remove("hidden");
        } else {
            newAccountInputGroup.classList.add("hidden");
        }
    }
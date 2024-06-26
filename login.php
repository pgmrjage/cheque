<?php
session_start();    // start session at the beginning

$server = "";
$username = "root";
$password = "";
$database = "";
$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  if (isset($_POST[""])) {
    if () {
      echo "Both fields are required";
      exit(); // Exit after displaying error
    }

    // No need to sanitize IDnum as it's an integer

  $sql = "SELECT IDnum, password, type FROM users WHERE IDnum = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $IDnum); // Assuming IDnum is an integer
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();

  if ($data == NULL) {
    echo '<script>alert("No data found"); window.location.href = "login.php";</script>';
    exit(); // Exit if no data found
  }

  // Directly compare the password from the database with the entered password
  if ($password != $data["password"]) {
    echo '<script>alert("Wrong ID Number or Password. Please try again"); window.location.href = "login.php";</script>';
    exit(); // Exit if password is incorrect
  }

  if ($data['type'] == 1) { // Assuming type 1 represents admin
    $_SESSION['username'] = $IDnum;
    $_SESSION['type'] = $data['type'];
    header("Location: admin.php");
    exit(); // Exit after redirecting
  } else {
    $_SESSION['username'] = $IDnum;
    $_SESSION['type'] = $data['type'];
    header("Location: checker.php");
    exit(); // Exit after redirecting
  }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins');

        /* BASIC */

        html {
        background-color: white;
        }

        body {
        font-family: "Poppins", sans-serif;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        a {
        color: #92badd;
        display:inline-block;
        text-decoration: none;
        font-weight: 400;
        }

        h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        display:inline-block;
        margin: 40px 8px 10px 8px; 
        color: #cccccc;
        }

        /* STRUCTURE */

        .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column; 
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
        }

        #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        text-align: center;
        }

        #formContent-signup {
            display: none;
        }

        #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
        }

        /* TABS */

        h2.inactive {
        color: #cccccc;
        }

        h2.active {
        color: #0d0d0d;
        border-bottom: 2px solid #5fbae9;
        }

        /* FORM TYPOGRAPHY*/

        input[type=button], input[type=submit], input[type=reset]  {
        background-color: #56baed;
        border: none;
        color: white;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        margin: 5px 20px 40px 20px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        }

        input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
        background-color: #39ace7;
        }

        input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
        -moz-transform: scale(0.95);
        -webkit-transform: scale(0.95);
        -o-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
        }

        input[type=text] {
        background-color: #f6f6f6;
        border: none;
        color: #0d0d0d;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 5px;
        width: 85%;
        border: 2px solid #f6f6f6;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        }

        input[type=text]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
        }

        input[type=text]:placeholder {
        color: #cccccc;
        }

        /* ANIMATIONS */

        /* Simple CSS3 Fade-in-down Animation */
        .fadeInDown {
        -webkit-animation-name: fadeInDown;
        animation-name: fadeInDown;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        }

        @-webkit-keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }
        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
        }

        @keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }
        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
        }

        /* Simple CSS3 Fade-in Animation */
        @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

        .fadeIn {
        opacity:0;
        -webkit-animation:fadeIn ease-in 400ms;
        -moz-animation:fadeIn ease-in 400ms;
        animation:fadeIn ease-in 400ms;

        -webkit-animation-fill-mode:forwards;
        -moz-animation-fill-mode:forwards;
        animation-fill-mode:forwards;

        -webkit-animation-duration: 400ms;
        -moz-animation-duration:400ms;
        animation-duration:400ms;
        }

        .fadeIn.first {
        -webkit-animation-delay: 400ms;
        -moz-animation-delay: 400ms;
        animation-delay: 400ms;
        }

        .fadeIn.second {
        -webkit-animation-delay: 90ms;
        -moz-animation-delay: 90ms;
        animation-delay: 90ms;
        }

        .fadeIn.third {
        -webkit-animation-delay: 120ms;
        -moz-animation-delay: 120ms;
        animation-delay: 120ms;
        }

        .fadeIn.fourth {
        -webkit-animation-delay: 800ms;
        -moz-animation-delay: 800ms;
        animation-delay: 800ms;
        }

        /* Simple CSS3 Fade-in Animation */
        .underlineHover:after {
        display: block;
        left: 0;
        bottom: -10px;
        width: 0;
        height: 2px;
        background-color: #56baed;
        content: "";
        transition: width 0.2s;
        }

        .underlineHover:hover {
        color: #0d0d0d;
        }

        .underlineHover:hover:after{
        width: 100%;
        }

        /* OTHERS */

        *:focus {
            outline: none;
        } 

        #icon {
        width:60%;
        }

        * {
        box-sizing: border-box;
        }
    </style>

</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            

            <!-- Login Form -->
            <form id="signInForm">
                <!-- Tabs Titles -->
                <h2 class="active" onclick="showSignIn()"> Sign In </h2>
                <h2 class="inactive underlineHover" onclick="showSignUp()">Sign Up </h2>

                <!-- Icon -->
                <div class="fadeIn first">
                <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
                </div>
                <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
                <input type="text" id="password" class="fadeIn third" name="password" placeholder="Password">
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>

            <!-- Sign Up Form -->
            <form id="signUpForm" style="display: none;">
                <!-- Tabs Titles -->
                <h2 class="inactive underlineHover" onclick="showSignIn()"> Sign In </h2>
                <h2 class="active" onclick="showSignUp()">Sign Up </h2>

                <!-- Icon -->
                <div class="fadeIn first">
                <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
                </div>
                <input type="text" id="firstname" class="fadeIn second" name="firstname" placeholder="Firstname">
                <input type="text" id="surname" class="fadeIn second" name="surname" placeholder="Surname">
                <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email">
                <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
                <input type="text" id="password" class="fadeIn second" name="login" placeholder="Password">
                <input type="submit" class="fadeIn fourth" value="Create Account">
            </form>

            <!-- Remind Password -->
            <div id="formFooter">
            <a class="underlineHover" href="#">Forgot Password?</a>
            </div>

        </div>
    </div>

    <script>
        function showSignIn() {
            document.getElementById('signInForm').style.display = 'block';
            document.getElementById('signUpForm').style.display = 'none';
        }

        function showSignUp() {
            document.getElementById('signInForm').style.display = 'none';
            document.getElementById('signUpForm').style.display = 'block';
            
        }
    </script>
</body>
</html>





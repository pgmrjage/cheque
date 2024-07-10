

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
        color: #fff;
        display:inline-block;
        text-decoration: none;
        font-weight: 600;
        }

        h2 {
        text-align: center;
        /* font-size: 16px; */
        font-weight: 600;
        /* text-transform: uppercase; */
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
        width: 36%;
        min-height: 100%;
        padding: 20px;
        }

        #formContent {
        display: grid;
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 650px;
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
        /* background-color: #f6f6f6;
        border-top: 1px solid #dce8f1; */
        padding: 25px;
        text-align: center;
        /* -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px; */
        }

        /* TABS */

        h2.inactive {
        color: #cccccc;
        }

        h2.active {
        color: #0d0d0d;
        border-bottom: 2px solid #395dab;
        }

        /* FORM TYPOGRAPHY*/

        input[type=button], input[type=submit], input[type=reset]  {
        /* background-color: #ffc42e; */
        /* border: none; */
        color: #333;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 600;
        /* -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        -webkit-border-radius: 5px 5px 5px 5px; */
        border-radius: 5px 5px 5px 5px;
        margin: 20px 40px 20px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        }

        input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
        background-color: #ffc42e;
        
        }

        input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
        -moz-transform: scale(0.95);
        -webkit-transform: scale(0.95);
        -o-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
        }

        input[type=text], input[type=password] {
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
        border: 1px solid #333;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        }

        /* input[type=text]:focus, input[type=password]:focus {
        background-color: #fff;
        border-bottom: 2px solid #4068c0;
        }

        input[type=text]:placeholder input[type=password]:placeholder {
        color: #cccccc;
        } */

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
        background-color: #395dab;
        content: "";
        transition: width 0.2s;
        }

        .underlineHover:hover {
        color: #395dab;
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



        /* CSS FOR CONTAINER OF LOGO AND LOGIN INFO*/
        /* ===================================== */
        .formContent-logo{
            /* display: flex;
            align-items: center;
            justify-content: center; */
            background-color: #395dab;
        }
    

        .formContent-info{
            background-color: #f6f6f6;
        }

        .header-logo{
            display: flex;
            justify-content: space-between;
            padding: 20px;
            color: #fff;
        }

        

        /* CSS FOR BACK BUTTON */
        
        .material-symbols-outlined {
            display: flex;
            justify-content: start;
            align-items: center ;
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
        }

    </style>

</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="formContent-logo">
                <div class="header-logo">
                    <!-- <img src="reset.png" width="120px" height="120px" id="logo-details"> -->
                    <a href = "login.php"><span class="material-symbols-outlined">arrow_back</span></a>
                </div>
            </div>
            <div class="formContent-info">
                <!-- Login Form -->
                <form id="signInForm">
                    <!-- Tabs Titles -->
                    <h2 class="active" onclick="showSignIn()"> Change your password </h2>
                    <p>Enter a new password below to change old password.</p>
                    <!-- <h2 class="inactive underlineHover" onclick="showSignUp()">Sign Up </h2> -->

                    <!-- Icon -->
                    <div class="fadeIn first">
                    <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
                    </div>
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Old Password" required>
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="New Password" required>
                    <input type="submit" class="fadeIn fourth" value="Change Password">
                </form>
            </div>

            
            

            

            <!-- Remind Password -->
            

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





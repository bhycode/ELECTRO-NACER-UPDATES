<!DOCTYPE html>
<html>
<head>
    <title>ELECTRO NACER</title>
    <meta name="description" content="An website for electronic pieces and Arduino.">
    <meta name="keywords" content="electronic, Arduino, servo motor, Arduino Uno, sensor, distance sensor">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

    


    <!-- LOGIN -->
    <div id="signin-div">
        <form method="post" class="login-form" style="margin-left: 300px; margin-right: 300px;">
            <span class="login-input-title">LOG IN</span>
            <input class="login-input" name="login_email" type="email">
            <input class="login-input" name="login_password" type="password">
            <button id="login-button" class="login-button" name="send" type="submit">LOG IN</button>
            <button id="signup-button-go" class="login-button" type="button" >SIGN UP</button>
        </form>
    </div>
    <!-- LOGIN -->


    <!-- SIGN-UP -->
    <div id="registration-div">
        <form method="post" class="login-form" style="margin-left: 300px; margin-right: 300px;">
            <span class="login-input-title">SIGN UP</span>
            <input class="login-input" name="signup_email" type="email">
            <input class="login-input" name="signup_password" type="password">
            <button id="signup-button" class="login-button" name="send" type="submit">SIGN UP</button>
            <button id="signin-button-go" class="login-button" type="button">LOG IN</button>
        </form>
    </div>
    <!-- SIGN-UP -->


    <?php
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "electro_nacer_updates";

        $connection = new mysqli($hostname, $username, $password, $database);



        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }


        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // LOGIN
            // Check if email and password are set
            if (isset($_POST['login_email'], $_POST['login_password'])) {

                // Get user input from the form
                $loginEmail = $connection->real_escape_string($_POST['login_email']);
                $loginPassword = $connection->real_escape_string($_POST['login_password']);

                // Query to check if the userId and password match in the User table
                $query = "SELECT * FROM User WHERE email = '$loginEmail' AND userPassword = '$loginPassword'";
                $result = $connection->query($query);
                $userID = $connection->query("SELECT userID from User where email = '$loginEmail' AND userPassword = '$loginPassword'");

                session_start();
                $_SESSION["current_id"] = $userID;
                $_SESSION["current_email"] = $_POST['login_email'];
                $_SESSION["current_password"] = $_POST['login_password'];
                
                // Check if any rows were returned
                if ($result->num_rows > 0) {
            
                    header("Location: home.php");
                    exit();
                } else {
                    echo '<script>alert("Login failed. Please check your userId and password.");</script>';
                }
            }


            // SIGN UP
            // Check if email and password are set
            if (isset($_POST['signup_email'], $_POST['signup_password'])) {
                // Get user input from the form
                $signupEmail = $connection->real_escape_string($_POST['signup_email']);
                $signupPassword = $connection->real_escape_string($_POST['signup_password']);

                // Generate a random userID (assuming you have a function for this)
                $userID = generateRandomString(40);

                // Default values for other columns
                $isAdmin = 0; // Assuming the new user is not an admin by default
                $isActiveAccount = 0; // Assuming the new user account is active by default

                // Query to insert a new user into the User table
                $query = "INSERT INTO User (userID, email, userPassword, isAdmin, isActiveAccount) VALUES ('$userID', '$signupEmail', '$signupPassword', $isAdmin, $isActiveAccount)";

                // Perform the query
                if ($connection->query($query) === TRUE) {
                    echo '<script>alert("User registered successfully.");</script>';
                } else {
                    echo '<script>alert("Error registering user: ' . $connection->error . '");</script>';
                }
            }




        }


        // Close the MySQL connection
        $connection->close();
    ?>


    <?php

        function generateRandomString($length = 40) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
        
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
        
            return $randomString;
        }

    ?>


<script src="assets/js/index.js"></script>
</body>


</html>
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

    <form method="post" class="login-form" style="margin-left: 300px; margin-right: 300px;">
        <span class="login-input-title">LogIn</span>
        <input class="login-input" name="userId" type="text">
        <input class="login-input" name="password" type="password">
        <button id="login-button" class="login-button" name="send" type="submit">LogIn</button>
    </form>


    <?php
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "electro_nacer";

        $connection = new mysqli($hostname, $username, $password, $database);



        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if userId and password are set
        if (isset($_POST['userId'], $_POST['password'])) {
            // Get user input from the form
            $userId = $connection->real_escape_string($_POST['userId']);
            $password = $connection->real_escape_string($_POST['password']);

            // Query to check if the userId and password match in the User table
            $query = "SELECT * FROM User WHERE userID = '$userId' AND userPassword = '$password'";
            $result = $connection->query($query);

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                header("Location: home.php");
                exit();
            } else {
                echo '<script>alert("Login failed. Please check your userId and password.");</script>';

            }
            }
        }

        // Close the MySQL connection
        $connection->close();
    ?>


</body>

<script src="assets/js/index.js"></script>

</html>

<!DOCTYPE html>

<html>

<head>
    <title>ELECTRO NACER - ADMIN_PAGE</title>
    <meta name="description" content="An website for electronic pieces and arduino.">
    <meta name="keywords" content="electronic, arduino, servo motor, arduino uno, sensor, diastance sensor">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="assets/css/home.css">
</head>


<body>

    <!--Header-->
    <header>

        <nav class="header-nav">

            <a href="home.php">Home</a>
            <a class="active" href="admin_page.php">Users manager</a>
            <a href="products_manager.php">Products manager</a>
            <a href="categories_manager.php">Categories manager</a>

        </nav>

    </header>
    <!--Header-->


    <h2 style="margin-top: 100px;">Users</h2>


<!-- Connect to database and get data -->
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "electro_nacer_updates";

$connection = new mysqli($hostname, $username, $password, $database);



if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if(!isset($_SESSION["current_id"])) {
        header("Location: index.php");
        exit;
}

function removeUser($userID) {

    // Implement the logic to remove the user with the given ID
    $sql = "DELETE FROM User WHERE userID = '$userID'";

    if ($connection->query($sql) === TRUE) {
        return "User removed successfully";
    } else {
        return "Error removing user: " . $connection->error;
    }
}

function activateUser($userID) {
    // Implement the logic to activate the user with the given ID
    $sql = "UPDATE User SET isActiveAccount = 1 WHERE userID = '$userID'";
    
    if ($connection->query($sql) === TRUE) {
        return "User activated successfully";
    } else {
        return "Error activating user: " . $connection->error;
    }
}


function makeAdmin($userID) {
    // Implement the logic to make the user with the given ID an admin
    $sql = "UPDATE User SET isAdmin = 1 WHERE userID = '$userID'";
    
    if ($connection->query($sql) === TRUE) {
        return "User made admin successfully";
    } else {
        return "Error making user admin: " . $connection->error;
    }
}

echo "<div id='users-dashboard'>";

// Fetch users from the database
$sql = "SELECT * FROM User";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Email</th><th>Password</th><th>Remove user</th><th>Acitvate account</th><th>Make it admin</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $userID = $row["userID"];
        echo "<tr>";
        echo "<td>" . $row["userID"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["userPassword"] . "</td>";


        // Show Remove button for all users
        if(!$row["isAdmin"]) {
            echo "<td>";
            echo '<a href= "admin_page.php?removeuser='.$row["userID"].'" class="button_a" style="color: black;">Remove</a>';
            echo "</td>";
        } else {
            echo "<td>";
            echo '<a class="button_a" style="color: black;">Remove</a>';
            echo "</td>";
        }
        

        // Show Activate button only for inactive users
        if (!$row["isActiveAccount"]) {
            echo "<td>";
            echo '<a href="admin_page.php?activateaccount='.$row["userID"].'" class="button_a" style="color: black;">Activate</a>';
            echo "</td>";
        } else {
            echo "<td>";
            echo '<a class="button_a" style="color: black;">Activate</a>';
            echo "</td>";
        }

        // Show Make Admin button only for non-admin users
        if (!$row["isAdmin"]) {
            echo "<td>";
            echo '<a href="admin_page.php?makeitadmin='.$row["userID"].'" class="button_a" style="color: black;">Make admin</a>';
            echo "</td>";
        } else {
            echo "<td>";
            echo '<a class="button_a" style="color: black;">Make admin</a>';
            echo "</td>";
        }


        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}
echo "</div>";
echo "<br><br><br><br>";


if($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(isset($_GET['removeuser'])) {

        $id = $_GET['removeuser'];
        $sql = "DELETE FROM User WHERE userID = '$id'";

        if ($connection->query($sql) === TRUE) {
            echo "<script>location.reload();</script>";
        } else {
            echo "Error removing user: " . $connection->error;
        }

    }

    if(isset($_GET['activateaccount'])) {
        $id = $_GET['activateaccount'];
        $sql = "UPDATE User SET isActiveAccount = 1 WHERE userID = '$id'";
    
        if ($connection->query($sql) === TRUE) {
            echo "<script>location.reload();</script>";
        } else {
            echo "Error activating user: " . $connection->error;
        }
    }

    if(isset($_GET['makeitadmin'])) {
        $id = $_GET['makeitadmin'];
        $sql = "UPDATE User SET isAdmin = 1 WHERE userID = '$id'";
    
        if ($connection->query($sql) === TRUE) {
            echo "<script>location.reload();</script>";
        } else {
            echo "Error making user admin: " . $connection->error;
        }
    }
}



?>

</body>

</html>
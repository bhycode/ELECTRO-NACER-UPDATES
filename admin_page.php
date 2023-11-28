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
    echo "<tr><th>ID</th><th>Email</th><th>Password</th><th>Action</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $userID = $row["userID"];
        echo "<tr>";
        echo "<td>" . $row["userID"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["userPassword"] . "</td>";
        echo "<td>";


        // Show Remove button for all users
        if(!$row["isAdmin"]) {
            echo '<button class="btn btn-remove" onclick="removeUser(\'' . $userID . '\')">Remove</button>';
        }
        

        // Show Activate button only for inactive users
        if (!$row["isActiveAccount"]) {
            echo '<button class="btn btn-activate" onclick="activateUser(\'' . $userID . '\')">Activate</button>';
        }

        // Show Make Admin button only for non-admin users
        if (!$row["isAdmin"]) {
            echo '<button class="btn btn-make-admin" onclick="makeAdmin(\'' . $userID . '\')">Make Admin</button>';
        }

        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}
echo "</div>";
echo "<br><br><br><br>";









// Function to add a new category
function addCategory($categoryName, $categoryImage) {
    $categoryID = uniqid(); // You can generate a unique ID using any method you prefer
    $isActive = true;

    $stmt = $conn->prepare("INSERT INTO ProductCategory (categoryID, categoryName, categoryImage, isActive) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $categoryID, $categoryName, $categoryImage, $isActive);

    if ($stmt->execute()) {
        echo "Category added successfully.";
    } else {
        echo "Error adding category: " . $stmt->error;
    }

    $stmt->close();
}

// Function to hide a category
function hideCategory($categoryID) {
    $stmt = $conn->prepare("UPDATE ProductCategory SET isActive = false WHERE categoryID = ?");
    $stmt->bind_param("s", $categoryID);

    if ($stmt->execute()) {
        echo "Category hidden successfully.";
    } else {
        echo "Error hiding category: " . $stmt->error;
    }

}


// Function to modify a category
function modifyCategory($categoryID, $newCategoryName, $newCategoryImage) {
    $stmt = $conn->prepare("UPDATE ProductCategory SET categoryName = ?, categoryImage = ? WHERE categoryID = ?");
    $stmt->bind_param("sss", $newCategoryName, $newCategoryImage, $categoryID);

    if ($stmt->execute()) {
        echo "Category modified successfully.";
    } else {
        echo "Error modifying category: " . $stmt->error;
    }

    $stmt->close();
}




?>

</body>

</html>
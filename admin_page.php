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


<!-- Add Category Form with File Upload -->
<h2>Add Category</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="categoryName">Category Name:</label>
    <input type="text" name="categoryName" required><br>
    <label for="categoryImage">Category Image:</label>
    <input type="file" name="categoryImage" accept="image/*" required><br>
    <input type="submit" value="Add Category">
</form>


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








// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["categoryName"];

    $uploadDir = "assets/images/"; // Specify your upload directory
    $uploadFile = $uploadDir . basename($_FILES["categoryImage"]["name"]);

    if (move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $uploadFile)) {
        addCategory($connection, $categoryName, $uploadFile);
    } else {
        echo "Error uploading file.";
    }
}


// Function to add a new category
function addCategory($connection, $categoryName, $categoryImage) {
    // Assuming you have a $connection variable set up earlier using mysqli

    // You can generate a unique ID using any method you prefer
    $categoryID = uniqid();
    $isActive = 1; // Assuming isActive is an integer field

    // Use mysqli_real_escape_string to sanitize input (for demonstration purposes)

    $query = "INSERT INTO ProductCategory (categoryID, categoryName, categoryImage, isActive) VALUES ('$categoryID', '$categoryName', '$categoryImage', $isActive)";

    $result = $connection->query($query);

    if ($result) {
        $message = "Category added successfully.";
        echo '<script>alert("' . $message . '");</script>';
    } else {
        $errorMessage = "Error adding category: " . $connection->error;
        echo '<script">alert("' . $errorMessage . '");</script>';
    }

    $idd = "656750ce57bfb";
    hideCategory($connection, $idd);
}


// Function to hide a category
function hideCategory($connection, $categoryID) {
    
    $result = $connection->query("UPDATE ProductCategory SET isActive = 0 WHERE categoryID = '$categoryID'");

    if($result) {
        $message = "Category modified successfully.";
        echo '<script>alert("' . $message . '");</script>';
    } else {
        $errorMessage = "Error modify category: " . $connection->error;
        echo '<script">alert("' . $errorMessage . '");</script>';
    }

}


// Function to modify a category
function modifyCategory($categoryID, $newCategoryName, $newCategoryImage) {
    $stmt = $conn->prepare("UPDATE ProductCategory SET categoryName = ?, categoryImage = ? WHERE categoryID = ?");
    $stmt->bind_param("sss", $newCategoryName, $newCategoryImage, $categoryID);

    $result = $connection->query("UPDATE ProductCategory SET isActive = 0 WHERE categoryID = '$categoryID'");

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
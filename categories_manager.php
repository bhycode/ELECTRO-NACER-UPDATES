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


showCategories($connection);

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["categoryName"];

    $uploadDir = "assets/images/"; // Specify your upload directory
    $uploadFile = $uploadDir . basename($_FILES["categoryImage"]["name"]);

    if (move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $uploadFile)) {
        addCategory($connection, $categoryName, $uploadFile);
        showCategories($connection);
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



function showCategories($connection) {
    // Assuming $connection is your database connection object
    $categoriesList = $connection->query("SELECT * FROM ProductCategory;");

    echo '<table class="table" style="margin-top: 50px;">
            <thead>
                <tr>
                    <th scope="col">Category ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Category Image</th>
                    <th scope="col">Is Active</th>
                </tr>
            </thead>
            <tbody>';

    while ($category = $categoriesList->fetch_assoc()) {
        echo '<tr>
                <td>' . $category['categoryID'] . '</td>
                <td>' . $category['categoryName'] . '</td>
                <td><img src="' . $category['categoryImage'] . '" alt="Category Image" style="max-width: 100px; max-height: 100px;"></td>
                <td>' . ($category['isActive'] ? 'Yes' : 'No') . '</td>
              </tr>';
    }

    echo '</tbody></table>';
}






?>

</body>

</html>
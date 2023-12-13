<!DOCTYPE html>

<html>

<head>
    <title>ELECTRO NACER - HOME</title>
    <meta name="description" content="An website for electronic pieces and arduino.">
    <meta name="keywords" content="electronic, arduino, servo motor, arduino uno, sensor, diastance sensor">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="assets/css/home.css">
    
</head>


<body>



    <!--Header-->
    <header>

        <nav class="header-nav">

            <a class="active" href="home.php">Home</a>
            <a href="products_manager.php">Products manager</a>
            <a href="categories_manager.php">Categories manager</a>

        </nav>

    </header>
    <!--Header-->




    <section class="top-section">

        <!-- Top title -->
        <span class="top-title">Our Products</span>
        <!-- Top title -->

    </section>
    

<!-- Connect to database and get data -->
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "electro_nacer_updates";

session_start();

$connection = new mysqli($hostname, $username, $password, $database);


if (!$connection && isset($_SESSION["currect_id"])) {
    die("Connection failed: " . mysqli_connect_error());
}


// Get data from database
$productsCategories = $connection->query("select * from ProductCategory;");
$products = $connection->query("SELECT Product.productID, Product.imagePath, Product.label, Product.unitPrice, Product.minQuantity, Product.stockQuantity, Product.category, ProductCategory.categoryName FROM Product JOIN ProductCategory ON Product.categoryID_fk = ProductCategory.categoryID ORDER BY Product.categoryID_fk;");
// Get data from database


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
        echo '<button class="btn btn-remove" onclick="removeUser(\'' . $userID . '\')">Remove</button>';
        echo '<button class="btn btn-activate" onclick="activateUser(\'' . $userID . '\')">Activate</button>';
        echo '<button class="btn btn-make-admin" onclick="makeAdmin(\'' . $userID . '\')">Make Admin</button>';
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}
echo "</div>";
echo "<br><br><br><br>";





?>



<!-- Filter products by category -->
<form method="post">
        <label for="categorySelect">Select a category:</label>
        <select name="selectedCategory" id="categorySelect">
            <?php
            // Iterate through the fetched categories and populate the dropdown
            echo '<option value="All">All</option>';
            while ($productsCategory = $productsCategories->fetch_assoc()) {
                $categoryName = $productsCategory['categoryName'];
                echo '<option value="' . $categoryName . '">' . $categoryName . '</option>';
            }
            ?>
        </select>

        <button class = "filter-button" type="submit">Get Selected Category</button>
</form>
<!-- Filter products by category -->


<!-- Filter products that's have'nt a enough quantity -->
<form method="post">
    <button class = "filter-button" name="end-soon-products" type="submit">Products that will expire soon</button>
</form>
<!-- Filter products that's have'nt a enough quantity -->



<?php


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected category from the form submission
    

    // Filter data by quantity
    if (isset($_POST["end-soon-products"])) {

        $filteredProductsByQuantity = $connection->query("SELECT * from Product where stockQuantity < minQuantity;");


        displayProducts($filteredProductsByQuantity);
    }
    // Filter data by quantity


    if (isset($_POST['selectedCategory'])) {
        $selectedCategory = $_POST['selectedCategory'];

        if($selectedCategory == "All") {
            displayProducts($products);
        } else {
            // Fetch products based on the selected category
            $filteredProducts = $connection->query("SELECT Product.productID, Product.imagePath, Product.label, Product.unitPrice, Product.minQuantity, Product.stockQuantity, Product.category, ProductCategory.categoryName FROM Product JOIN ProductCategory ON Product.categoryID_fk = ProductCategory.categoryID and ProductCategory.categoryName = '$selectedCategory';");
            // Call the function to display filtered products
            displayProducts($filteredProducts);
        }
    }

    
    
} else {
    // If the form is not submitted, display all products initially
    displayProducts($products);
}
?>












<?php
// Function showing products
function displayProducts($products)
{
    echo '<section class="products-catalog-section">';
    echo '<div class="products-catalog-cards">';

    while ($product = $products->fetch_assoc()) {
        $imagePath = $product['imagePath'];
        $label = $product['label'];
        $unitPrice = $product['buyingPrice'];

        // Display product card
        echo '<div class="products-catalog-card" style="background-image: url(\'assets/images/' . $imagePath . '\');">';
        echo '<p>' . $label . '</p>';
        echo '<p>' . $unitPrice . ' DH</p>';


        echo '</div>';
    }
    echo '</div>';
    echo '</section>';
}
?>






    <script src="assets/js/home.js"></script>
</body>

</html>
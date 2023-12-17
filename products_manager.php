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

        <a href="home.php">Home</a>
        <a href="admin_page.php">Users manager</a>
        <a class="active" href="products_manager.php">Products manager</a>
        <a href="categories_manager.php">Categories manager</a>

        </nav>

    </header>
    <!--Header-->


    <section class="top-section">

        <!-- Top title -->
        <span class="top-title">Products</span>
        <!-- Top title -->

    </section>
    

    <!-- Add Product Form with File Upload -->
    <h2 style = "margin_top=50px">Add Product</h2>
    <form method="post">
        <label for="imagePath">Product Image:</label>
        <input type="file" name="imagePath" accept="image/*" required><br>
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" required><br>
        <label for="label">Label:</label>
        <input type="text" name="label" required><br>
        <label for="fullDescription">Full Description:</label>
        <input type="text" name="fullDescription" required><br>
        <label for="minQuantity">Minimum Quantity:</label>
        <input type="number" name="minQuantity" step="any" required><br>
        <label for="stockQuantity">Stock Quantity:</label>
        <input type="number" name="stockQuantity" required><br>
        <label for="buyingPrice">Buying Price:</label>
        <input type="number" name="buyingPrice" step="any" required><br>
        <label for="finalPrice">Final Price:</label>
        <input type="number" name="finalPrice" step="any" required><br>
        <label for="offerPrice">Offer Price:</label>
        <input type="number" name="offerPrice" step="any"><br>
        <label for="categoryID_fk">Category ID:</label>
        <input type="text" name="categoryID_fk" required><br>
        <input type="submit" value="Add Product">
    </form>


    <!-- Update Product Form with File Upload -->
    <h2 style = "margin_top=50px">Update Product</h2>
    <form method="post">
        <label for="productId">Product id:</label>
        <input type="text" name="productId" required><br>
        <label for="imagePath">Product Image:</label>
        <input type="file" name="imagePath" accept="image/*" required><br>
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" required><br>
        <label for="label">Label:</label>
        <input type="text" name="label" required><br>
        <label for="fullDescription">Full Description:</label>
        <input type="text" name="fullDescription" required><br>
        <label for="minQuantity">Minimum Quantity:</label>
        <input type="number" name="minQuantity" step="any" required><br>
        <label for="stockQuantity">Stock Quantity:</label>
        <input type="number" name="stockQuantity" required><br>
        <label for="buyingPrice">Buying Price:</label>
        <input type="number" name="buyingPrice" step="any" required><br>
        <label for="finalPrice">Final Price:</label>
        <input type="number" name="finalPrice" step="any" required><br>
        <label for="offerPrice">Offer Price:</label>
        <input type="number" name="offerPrice" step="any"><br>
        <label for="categoryID_fk">Category ID:</label>
        <input type="text" name="categoryID_fk" required><br>
        <input type="submit" value="Update Product">
    </form>




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


session_start();
if(!isset($_SESSION["current_id"])) {
        header("Location: index.php");
        exit;
}

// Get data from database
$products = $connection->query("SELECT * FROM Product;");
// Get data from database

showProducts($connection, $products);

function showProducts($connection, $productsList) {

    echo '<table class="table" style="margin-top: 50px;">
            <thead>
                <tr>
                    <th >Product ID</th>
                    <th >Product Image</th>
                    <th >Barcode</th>
                    <th >Label</th>
                    <th >Full Description</th>
                    <th >Min Quantity</th>
                    <th >Stock Quantity</th>
                    <th >Buying Price</th>
                    <th >Final Price</th>
                    <th >Offer Price</th>
                    <th >Category ID</th>
                    <th >Is Active</th>
                    <th >Hide</th>
                </tr>
            </thead>
            <tbody>';

    while ($product = $productsList->fetch_assoc()) {
        echo '<tr>
                <td>' . $product['productID'] . '</td>
                <td><img src="' . $product['imagePath'] . '" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                <td>' . $product['barcode'] . '</td>
                <td>' . $product['label'] . '</td>
                <td>' . $product['full_description'] . '</td>
                <td>' . $product['minQuantity'] . '</td>
                <td>' . $product['stockQuantity'] . '</td>
                <td>' . $product['buyingPrice'] . '</td>
                <td>' . $product['finalPrice'] . '</td>
                <td>' . ($product['offerPrice'] ?: '-') . '</td>
                <td>' . $product['categoryID_fk'] . '</td>
                <td>' . ($product['isActive'] ? "Yes":"No") . '</td>
                <td>
                    <a class = "button_a" href="products_manager.php?hide_product_id=' . $product['productID'] . '">Hide</a>
                </td>
              </tr>';
    }

    echo '</tbody></table>';

}





if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['productId'])) {

        // Assuming your form fields have names like the ones in the HTML form
        $productData = [
            'productID' => $_POST['productId'],
            'imagePath' => $_FILES['imagePath']['name'], // Assuming imagePath is the name attribute for the file input
            'barcode' => $_POST['barcode'],
            'label' => $_POST['label'],
            'fullDescription' => $_POST['fullDescription'],
            'minQuantity' => $_POST['minQuantity'],
            'stockQuantity' => $_POST['stockQuantity'],
            'buyingPrice' => $_POST['buyingPrice'],
            'finalPrice' => $_POST['finalPrice'],
            'offerPrice' => $_POST['offerPrice'],
            'categoryID_fk' => $_POST['categoryID_fk'] 
        ];

        updateProduct($connection, $productData);

    } else {

        // Assuming your form fields have names like the ones in the HTML form
        $productData = [
            'imagePath' => $_FILES['imagePath']['name'], // Assuming imagePath is the name attribute for the file input
            'barcode' => $_POST['barcode'],
            'label' => $_POST['label'],
            'fullDescription' => $_POST['fullDescription'],
            'minQuantity' => $_POST['minQuantity'],
            'stockQuantity' => $_POST['stockQuantity'],
            'buyingPrice' => $_POST['buyingPrice'],
            'finalPrice' => $_POST['finalPrice'],
            'offerPrice' => $_POST['offerPrice'],
            'categoryID_fk' => $_POST['categoryID_fk'] 
        ];

        addProduct($connection, $productData);
    }

}
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET['hide_product_id'])) {

        $id = $_GET['hide_product_id'];

        $result = mysqli_query($connection, "UPDATE Product SET isActive = false WHERE productID = '$id' and isActive = true;");
        
        
        if(isset($_GET['hide_product_id'])) {
            header('Refresh: 1; url=products_management.php');
        }
        
        
    }
}



function addProduct($connection, $productData) {
    // Assuming $connection is your database connection object

    // Escape and sanitize input data to prevent SQL injection
    $productID = uniqid();
    $imagePath = mysqli_real_escape_string($connection, $productData['imagePath']);
    $barcode = mysqli_real_escape_string($connection, $productData['barcode']);
    $label = mysqli_real_escape_string($connection, $productData['label']);
    $fullDescription = mysqli_real_escape_string($connection, $productData['fullDescription']);
    $minQuantity = floatval($productData['minQuantity']);
    $stockQuantity = intval($productData['stockQuantity']);
    $buyingPrice = floatval($productData['buyingPrice']);
    $finalPrice = floatval($productData['finalPrice']);
    $offerPrice = isset($productData['offerPrice']) ? floatval($productData['offerPrice']) : null;
    $categoryID_fk = mysqli_real_escape_string($connection, $productData['categoryID_fk']);

    // SQL query to insert data into the Product table
    $query = "INSERT INTO Product (productID, imagePath, barcode, label, full_description, minQuantity, stockQuantity, buyingPrice, finalPrice, offerPrice, categoryID_fk)
              VALUES ('$productID', '$imagePath', '$barcode', '$label', '$fullDescription', $minQuantity, $stockQuantity, $buyingPrice, $finalPrice, ";
    $query .= $offerPrice ? "$offerPrice, " : "NULL, ";
    $query .= "'$categoryID_fk')";

    // Execute the query
    $result = $connection->query($query);

    // Check if the query was successful
    if ($result) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product: " . $connection->error;
    }
}


function updateProduct($connection, $productData) {
    // Assuming $connection is your database connection object

    // Escape and sanitize input data to prevent SQL injection
    $productID = $productData['productID'];
    $imagePath = mysqli_real_escape_string($connection, $productData['imagePath']);
    $barcode = mysqli_real_escape_string($connection, $productData['barcode']);
    $label = mysqli_real_escape_string($connection, $productData['label']);
    $fullDescription = mysqli_real_escape_string($connection, $productData['fullDescription']);
    $minQuantity = floatval($productData['minQuantity']);
    $stockQuantity = intval($productData['stockQuantity']);
    $buyingPrice = floatval($productData['buyingPrice']);
    $finalPrice = floatval($productData['finalPrice']);
    $offerPrice = isset($productData['offerPrice']) ? floatval($productData['offerPrice']) : null;
    $categoryID_fk = mysqli_real_escape_string($connection, $productData['categoryID_fk']);

    // SQL query to insert data into the Product table
    $query = "INSERT INTO Product (productID, imagePath, barcode, label, full_description, minQuantity, stockQuantity, buyingPrice, finalPrice, offerPrice, categoryID_fk)
              VALUES ('$productID', '$imagePath', '$barcode', '$label', '$fullDescription', $minQuantity, $stockQuantity, $buyingPrice, $finalPrice, ";
    $query .= $offerPrice ? "$offerPrice, " : "NULL, ";
    $query .= "'$categoryID_fk')";

    // Execute the query
    $result = $connection->query($query);

    // Check if the query was successful
    if ($result) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product: " . $connection->error;
    }
}



?>







    <script src="assets/js/home.js"></script>
</body>

</html>
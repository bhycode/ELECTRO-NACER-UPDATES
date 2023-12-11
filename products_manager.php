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




    <section class="top-section">

        <!-- Top title -->
        <span class="top-title">Products</span>
        <!-- Top title -->

    </section>
    

    <!-- Add Product Form with File Upload -->
    <h2>Add Product</h2>
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
$products = $connection->query("SELECT * FROM Product;");
// Get data from database

showProducts($connection, $products);

function showProducts($connection, $productsList) {

    echo '<table class="table" style="margin-top: 50px;">
            <thead>
                <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Label</th>
                    <th scope="col">Full Description</th>
                    <th scope="col">Min Quantity</th>
                    <th scope="col">Stock Quantity</th>
                    <th scope="col">Buying Price</th>
                    <th scope="col">Final Price</th>
                    <th scope="col">Offer Price</th>
                    <th scope="col">Category ID</th>
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
              </tr>';
    }

    echo '</tbody></table>';

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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



?>







    <script src="assets/js/home.js"></script>
</body>

</html>
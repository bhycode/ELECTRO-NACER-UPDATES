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
        <span class="top-title">Our Products</span>
        <!-- Top title -->

    </section>
    

<!-- Connect to database and get data -->
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "electro_nacer";

$connection = new mysqli($hostname, $username, $password, $database);



if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


// Get data from database
$productsCategories = $connection->query("select * from ProductCategory;");
$products = $connection->query("SELECT Product.productID, Product.imagePath, Product.label, Product.unitPrice, Product.minQuantity, Product.stockQuantity, Product.category, ProductCategory.categoryName FROM Product JOIN ProductCategory ON Product.categoryID_fk = ProductCategory.categoryID ORDER BY Product.categoryID_fk;");
// Get data from database

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
        $unitPrice = $product['unitPrice'];

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
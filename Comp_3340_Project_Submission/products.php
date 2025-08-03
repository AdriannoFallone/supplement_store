<?php
 // My credentials for establishing db connection
    $host = 'localhost';
    $db = 'fallone2_supplement_store';
    $user = 'fallone2_supplement_store';
    $pass = 'jh9xJ4MS9xcnhmD4SWwg';
session_start(); //starts session

//confirms if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Runs when not logged in
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "You must be logged in to add to your cart.";
        exit();
    }
}

$user_id = $_SESSION['user_id'] ?? null; //gets user's id


//  Handles POST requests for updating items in cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['version_id'], $_POST['quantity'])) {
    $version_id = intval($_POST['version_id']);
    $quantity = max(1, intval($_POST['quantity'])); 

   

    $conn = new mysqli($host, $user, $pass, $db); //connects to db
    if ($conn->connect_error) {
        exit();
    }

    //Prepares to get products information for the version_id selected
    $stmt = $conn->prepare("SELECT product_id, name, price FROM product_versions WHERE version_id = ?");
    $stmt->bind_param("i", $version_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();

        //Determines whether ot not the product is already in cart
        $stmt2 = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_name = ?");
        $stmt2->bind_param("is", $user_id, $product['name']);
        $stmt2->execute();
        $res2 = $stmt2->get_result();

        if ($res2->num_rows > 0) {
            //updates quantity if item is alread in cart
            $row = $res2->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;

            $stmt3 = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_name = ?");
            $stmt3->bind_param("iis", $new_quantity, $user_id, $product['name']);
            $stmt3->execute();
        } 
        
        else {
            //If the product is not in the cart, it is inserted as a new row in the table
            $stmt3 = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?)");         
            $stmt3->bind_param("iisdi", $user_id, $product['product_id'], $product['name'], $product['price'], $quantity);
            $stmt3->execute();
        }
    }
    $conn->close();

    //Success response
    echo "OK";
    exit();
}

//GET Requests

//re-establish connection to db
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Fetches the products by product_id
$sql = "SELECT * FROM products ORDER BY product_id";
$result = $conn->query($sql);
$products = []; //array for products

//adds all products to the array
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['versions'] = [];  //array for product versions
        $products[$row['product_id']] = $row;
    }
}

//Fetches the product versions by product_id
$sql_versions = "SELECT * FROM product_versions ORDER BY product_id";
$result_versions = $conn->query($sql_versions);

//add each product version to its product's versions array
if ($result_versions && $result_versions->num_rows > 0) {
    while($row = $result_versions->fetch_assoc()) {
        $products[$row['product_id']]['versions'][] = $row;
    }
}
$conn->close();
?>

<!--
Name: Adrianno Fallone
Date: July 30, 2025
Description: Final Project Submission
Professor: Dr. Ziad Kobti-->

<!-- Initial declarations, metatags-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Top-rated workout supplements and health aids listed below" />
    <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, health, protein-powder" />
    <meta name="author" content="Adrianno Fallone" />
    <link id="themeStyle" rel="stylesheet" href="css_files/products.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Fall-1-Factor</title>
</head>
<!--body section with header and table of contents-->
<body class="standard_view"> <!--Begin in Standard View-->

<!--header section-->
<header>
    <nav class="navigationbar">
        <div class="logo">Fall-1-Factor</div>
        
        <!--unordered list for table of contents-->
        <ul class="links_navigation">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="products.php">Our Products</a></li>
            <li><a href="exercise.html">Exercise Selection Tool</a></li>
            <li><a href="macrocalc.html">Macronutrient Calculator</a></li>
            <li><a href="wikinav.html">Help Pages</a></li>
            <li><a href="ouraffiliates.html">Our Affiliates</a></li>
            <li><a href="reviewnav.html">Reviews</a></li>
            <li><a href="contactus.html">Contact</a></li>
        </ul>

<!--login/register form links and welcome message when user is logged in-->
    <div class="user-info">
    <?php
    session_start();
    if (isset($_SESSION['username'])):
    ?>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="user_menu.php">My Account</a> |
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> |
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>
</nav>

    <!--element for linking to cart -->
    <a href="cart.php" class="cart-link" title="View Cart">
        <span class="material-icons">shopping_cart</span>
    </a>
</header>


<!--main content-->
<main>
    <section class="grid_products" id="product_preview">
       <!-- Product cards generated and displayed here by main.js -->
    </section>
</main>

<!--page footer-->
<footer>
    <p>&copy; 2025 Fall-1-Factor Industries. All Rights Reserved</p>
</footer>

<!--Place PHP generated array into JS-->
<script>const productsFromPHP = <?php echo json_encode(array_values($products), JSON_HEX_TAG); ?>;</script>

<script src="js_files/main.js"></script> <!--external script for the product cards-->

</body>
</html>

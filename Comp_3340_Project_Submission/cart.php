<?php
session_start(); //starts the session

//verify user is logged into the session
if (!isset($_SESSION['user_id'])) {
    die("Please log in to view your cart.");
}

require 'db_connection.php'; //links to db connection file
$user_id = $_SESSION['user_id'];

//query to get items in the cart and their relevant attributes
$stmt = $conn->prepare("
SELECT c.id, c.product_name, c.product_price, c.quantity, p.image
    FROM cart c
    LEFT JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?


");
$stmt->bind_param("i", $user_id);  //binds user attribute
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
$subtotal = 0.0;

//calculate total by iterating over every item in the cart of the user signed in
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $subtotal += $row['product_price'] * $row['quantity'];
}
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Cart page of site to view selected products" />
    <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, shopping cart, checkout" />
    <meta name="author" content="Adrianno Fallone" />
    <link id="themeStyle" rel="stylesheet" href="css_files/cart.css">

    <title>Fall-1-Factor</title> <!--title-->
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

</header>
<!-- main content section-->
<main class="cart-container">

    <div id="cart-items">  <!--container for cart items-->
        <?php if (count($cartItems) === 0): ?>
            <p>Your cart is empty. <a style="text-decoration:none; color: limegreen; font-weight: bold" href="products.php">Shop now!</a></p> <!--shows this message if the cart has no items in it-->
        <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    
                    <!--product image-->
                    <img src="<?= htmlspecialchars($item['image'] ?: 'images/adaptedimg1.png') ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">



                     <!-- container for product info from cart table: price, name, quantity-->
                    <div class="item-info">
                        <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                        <p>Quantity: <?= $item['quantity'] ?></p>
                        <p>Price: $<?= number_format($item['product_price'], 2) ?></p>
                        <p>Total: $<?= number_format($item['product_price'] * $item['quantity'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!--cart summary-->

    <div class="cart-summary">
        <h2>Order Summary</h2>
        <p id="subtotal">Subtotal: $<?= number_format($subtotal, 2) ?></p>
        <a style="text-decoration:none" href="checkout.php" class="checkout-btn">Proceed to Checkout</a>

        <a href="products.php" class="back-link">Continue Shopping</a> <!--link back to product page-->
    </div>

</main>

<!--page footer-->
<footer>
    <p>&copy; 2025 Fall-1-Factor Industries.  All Rights Reserved</p>
</footer> 

</body>

</html>

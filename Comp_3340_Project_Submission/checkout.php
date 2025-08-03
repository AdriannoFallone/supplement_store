<?php
session_start(); //starts the session

//verify user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to checkout.");
}

require 'db_connection.php'; //links to db connection file

$user_id = $_SESSION['user_id'];

//checkout is processed after form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    
    // Fetches current cart items for user
    $stmt = $conn->prepare("SELECT id, product_id, product_name, product_price, quantity FROM cart WHERE user_id = ?");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();


     //check if cart is empty
    if ($result->num_rows === 0) {
        die("Your cart is empty.");
    }


     //get summative cost of cart
    $cart_items = [];
    $total = 0;
    while ($item = $result->fetch_assoc()) {
        $cart_items[] = $item;
        $total += $item['product_price'] * $item['quantity'];
    }

    //placeholder information that I left in for all checkout processes
    $shipping_address = "University of Windsor";
    $payment_method = "Credit Card";
    $status = "Pending";
    $order_date = date('Y-m-d H:i:s');

  
    $conn->begin_transaction();

    try {
        // Places data of the order summary in the table, orders
        $insert_order = $conn->prepare("INSERT INTO orders (user_id, order_date, total, status, shipping_address, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_order->bind_param("isdsss", $user_id, $order_date, $total, $status, $shipping_address, $payment_method);
        $insert_order->execute();
        
        $order_id = $conn->insert_id;

        //Places the cart item data into the table, order_items
       $insert_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
foreach ($cart_items as $item) {
    $insert_item->bind_param("iisid", $order_id, $item['product_id'], $item['product_name'], $item['quantity'], $item['product_price']);
    $insert_item->execute();
}


        //delete all data from the user's cart
        $clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $clear_cart->bind_param("i", $user_id);
        $clear_cart->execute();

        $conn->commit();

        //brings user to the order success page, which has a message
        header("Location: order_success.php?order_id=" . $order_id);
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Order failed: " . $e->getMessage());
    }
} else {
    //show checkout summary
    $stmt = $conn->prepare("SELECT product_name, product_price, quantity FROM cart WHERE user_id = ?"); //retirves items in the cart
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total = 0;
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
        $total += $row['product_price'] * $row['quantity'];
    }
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Top-rated workout supplements for muscle growth and recovery. Homepage" />
  <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, homepage" />
  <meta name="author" content="Adrianno Fallone" />
  <link id="themeStyle" rel="stylesheet" href="css_files/cart.css">
  <title>Fall-1-Factor</title> <!--title-->
</head>
<!--body section with header and table of contents-->
<body class="standard_view"> <!--Begin in Standard View-->

<!-- header section-->
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


<h2>Checkout</h2> <!--section heading-->
<?php if (count($items) === 0): ?>
    <p>Your cart is empty. <a href="products.php">Continue Shopping</a></p> <!--message displayed if cart is empty-->
<?php else: ?>
    <div class="checkout-items">
        <?php foreach ($items as $item): ?>
            <div class="checkout-item">
                <p><strong><?= htmlspecialchars($item['product_name']) ?></strong></p>
                <p>Price: $<?= number_format($item['product_price'], 2) ?></p>
                <p>Quantity: <?= $item['quantity'] ?></p>
                <p>Subtotal: $<?= number_format($item['product_price'] * $item['quantity'], 2) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <!--return and show the cost of all items(total)-->
    <h3>Total: $<?= number_format($total, 2) ?></h3>

    <form method="post" action="checkout.php"> <!--form confirms order-->
        <button type="submit" name="checkout">Confirm Order</button>
    </form>
<?php endif; ?>

<!--page footer-->
<footer>
    <p>&copy; 2025 Fall-1-Factor Industries.  All Rights Reserved</p>
</footer> 
</body>
</html>

<?php
session_start(); //start session

//verify user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0; //gets order-id(to be displayed via below functionality in this file)
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
    
    
    <title>Order Success</title> <!--page title-->
    
    
    <link rel="stylesheet" href="css_files/cart.css">
</head>

<!--body section with header and table of contents-->
<body class="standard_view"> <!--Begin in Standard View-->
    <header>
    <div class="logo">Fall-1-Factor</div>
            
</header>
<!--main section confirming order success-->
    <main class="order-success">
        <h1>Thank You for Your Purchase with Fall-1-Factor!</h1>
        <p>Your order <strong>#<?= htmlspecialchars($order_id) ?></strong> has been placed successfully.</p> <!-- displays order id-->
        <a style="color:limegreen; text-decoration: none; font-weight: strong" href="index.php">Back To Home</a>.</p>
    </main>

    <!--page footer-->
    <footer>
        <p>&copy; 2025 Fall-1-Factor Industries. All Rights Reserved.</p>
    </footer>
</body>
</html>

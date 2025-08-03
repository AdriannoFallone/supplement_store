
<?php
session_start(); //start the session
require 'db_connection.php'; //link to db connection string
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
    <meta name="description" content="User Menu and Account Page" />
    <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, health, protein-powder, my-account" />
    <meta name="author" content="Adrianno Fallone" />
    <link id="themeStyle" rel="stylesheet" href="css_files/products.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Fall-1-Factor</title> <!--title-->
</head>
<!--body section with header and table of contents-->
<body class="standard_view">   <!--Begin in Standard View-->

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

<!--user menu heading-->
  <h2>User Settings</h2>

<!-- form for updating user account information-->
  <form id="update-form">
    <label>New Username:</label><br>
    <input type="text" name="username" /><br><br>

    <label>New Password:</label><br>
    <input type="password" name="password" /><br><br>

    <button type="submit">Update</button>
  </form>

  <p id="message"></p> <!--success/error message to be displayed to user-->

  <script>
    //prevent page from re-loading
    document.getElementById("update-form").addEventListener("submit", async function (e) {
      e.preventDefault();
      
      
      const formData = new FormData(this); //form object

       //forward the info to the PHP backend through POST method
      const res = await fetch("update_user.php", {
        method: "POST",
        body: formData
      });

      //display response to user
      const text = await res.text();
      document.getElementById("message").textContent = text;
    });
  </script>

  
<!--page footer-->
<footer>
    <p>&copy; 2025 Fall-1-Factor Industries.  All Rights Reserved</p>
</footer> 
</body>
</html>

<?php


session_start();  //starts session

//My credentials for connecting to the db
$host = 'localhost';
$db = 'fallone2_supplement_store';
$user = 'fallone2_supplement_store';
$pass = 'jh9xJ4MS9xcnhmD4SWwg';

$conn = new mysqli($host, $user, $pass, $db); //establishes connection to db

//check for any connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Message variable for response to user
$message = '';

//determine if request submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    //ensure both fields are filled in by user
    if (!empty($username) && !empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        //Prepare to add new user to the db
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);

         //provide feedback to user on whether or not operation was successful
        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Please fill in all fields.";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Registration Page" />
  <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, register" />
  <meta name="author" content="Adrianno Fallone" />
  <link id="themeStyle" rel="stylesheet" href="css_files/main.css">
  
  <title>Fall-1-Factor</title> <!--title-->
</head>
<!--body section with header and table of contents-->
<body class="standard_view">  <!--Begin in Standard View-->

<!--header sectyion-->
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
<body>
   <!-- user registration form container-->
    <form class="userlogin" method="POST" action="">
     <h2>User Registration</h2>
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br> <!--username input-->

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br> <!--password input-->

        <button type="submit">Register</button> <!--submission button-->
    </form>

    <!--feedback message to user-->

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

<!--page footer-->
<footer>
    <p>&copy; 2025 Fall-1-Factor Industries.  All Rights Reserved</p>
</footer> 
</body>
</html>
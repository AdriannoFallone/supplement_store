<?php
session_start(); //starts session

//my credentials for connecting to db
$host = 'localhost';
$db = 'fallone2_supplement_store';
$user = 'fallone2_supplement_store';
$pass = 'jh9xJ4MS9xcnhmD4SWwg';
$conn = new mysqli($host, $user, $pass, $db); //creates connection

$message = '';

//validate that form was submitted with POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

//prepares to fetch dteails from the user table by username
$stmt = $conn->prepare("SELECT user_id, password_hash, is_admin FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

//bind to variables
$stmt->bind_result($user_id, $password_hash, $is_admin);

//confirm if user is found and that password is valid
if ($stmt->fetch() && password_verify($password, $password_hash)) {
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;
    $_SESSION["is_admin"] = (int)$is_admin;  
    $message = "Login successful!"; //success message
   
} else {
    $message = "Invalid username or password."; //failure message
}


    $stmt->close();
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Top-rated workout supplements for muscle growth and recovery. Homepage" />
    <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, homepage" />
    <meta name="author" content="Adrianno Fallone" />
    <link id="themeStyle" rel="stylesheet" href="css_files/main.css">

    <!-- title-->
    <title>Fall-1-Factor</title>
</head>
 
<!--body section with header and table of contents-->
<body class="standard_view"> <!--Begin in Standard View-->

<!--Header Section-->
<header>
  

    <nav class="navigationbar">
    <div class = "logo">Fall-1-Factor</div>

    <!--unordered list for table of contents-->
    <ul class = "links_navigation">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="products.php">Our Products</a></li>
        <li><a href = "exercise.html">Exercise Selection Tool</a></li>
        <li><a href = "macrocalc.html">Macronutrient Calculator</a></li>
        <li><a href="wikinav.html">Help Pages</a></li>
        <li><a href="ouraffiliates.html">Our Affiliates</a></li>
        <li><a href="reviewnav.html">Reviews</a></li>
        <li><a href="contactus.html">Contact</a></li>

    </ul>
</nav>

</header>



     <!--user login form container-->
    <form class="userlogin" method="POST" action="">
        <h2>User Login</h2> <!--section heading-->
        
        <label>Username:</label><br> 
        <input type="text" name="username" required><br><br> <!--username input-->

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br> <!--password input-->

        <button type="submit">Login</button> <!--login button-->
    </form>

    <!--displays applicable message-->
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

<!--page footer-->
<footer>
<p>&copy; 2025 Fall-1-Factor Industries.  All Rights Reserved</p>
</footer> 
</body>
</html>
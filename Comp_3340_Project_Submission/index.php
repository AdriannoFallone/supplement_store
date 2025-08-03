<?php

session_start(); //starts session
// DB connection
$host = 'localhost';
$db = 'fallone2_supplement_store';
$user = 'fallone2_supplement_store';
$pass = 'jh9xJ4MS9xcnhmD4SWwg';

//makes connection to db
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); //in the event of a failed connection
} 

//gets all products from the products table
$sql = "SELECT * FROM products ORDER BY product_id";
$result = $conn->query($sql);
$products = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[$row['product_id']] = $row; //Places each product in an array
    }
}

//gets specific product versions from the product_versions table
$sql_versions = "SELECT * FROM product_versions ORDER BY product_id";
$result_versions = $conn->query($sql_versions);
$versions = [];

if ($result_versions && $result_versions->num_rows > 0) {
    while($row = $result_versions->fetch_assoc()) {
        $versions[$row['product_id']][] = $row; //groups version by corresponding product_id
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
  <meta name="description" content="Top-rated workout supplements for muscle growth and recovery. Homepage" />
  <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, homepage" />
  <meta name="author" content="Adrianno Fallone" />
  <link id="themeStyle" rel="stylesheet" href="css_files/main.css">
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
      <li><a href="admin.php">Admin</a></li>
      <li>
        <select id="themeChange"> <!--Theme change list options-->
          <option value="css_files/main.css">Standard View</option>
          <option value="css_files/bulking.css">Bulking View</option>
          <option value="css_files/cutting.css">Cutting View</option>
        </select>
      </li>
    </ul>
  <!--login/register form links and welcome message when user is logged in-->
  <div class="user-info">
    <?php
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
  <h1>Explore Our Massive Selection of Quality Assured and Tested Supplements</h1>
</header>

<!--main section-->
<main class="content_main">
  <section class="ht">
    <h2>Welcome To The Fall-1-Factor Online Supplement Store</h2>
    <p>Browse all your fitness journey needs with a wide variety of supplements <br> and site services</p>
  </section>

  <section class="pop_out"> <!--pop out container for page animation-->
    <div class="pop_out_elements">
      <img src="images/adaptedimg1.png" alt="Promo Image" width="600" height="600"/>
      <h3 class="promo_text">Factor Your Life Today</h3> <!--text to go over image--->
    </div>
    <p class="promo_msg">
      Ever wondered what it felt like to be at peak physical performance for your fitness goals and athletic journeys. Ever think there was something more you could be doing, some untapped 
      avenue of exploration. Well, with Fall-1-Factor's Online Supplement Shop, gain access to the highest quality fitness and health supplements on the market. 
      Carrying you closer to your end goal one scoop at a time!
    </p> <!--paragraph to go alongside promo image-->
  </section>

  <!-- product preview container for allowing a dynamic scroll view of products directly on homepage-->
  <div class="scrolling-container">
    <section class="product_overview">
      <div id="product_preview" class="grid_products">
        
        <!--iterate over each product-->
        <?php foreach ($products as $product_id => $product): ?>
          <?php
          //check if the product has versions(they all do)
            $hasVersions = isset($versions[$product_id]);
            
            //sets the default price and image for the product
            $defaultVersion = $hasVersions ? $versions[$product_id][0] : null;
            $price = $hasVersions ? $defaultVersion['price'] : $product['price'];
            $image = $hasVersions ? $defaultVersion['image'] : $product['image'];
          ?>
          <div class="product-holder">
            
            <!--show product image, name, price, and description-->
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product_image" />
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <strong class="product-price"><?= htmlspecialchars($price) ?></strong>

            <!--display the vserion dropdown menu(for each product)-->

            <?php if ($hasVersions): ?>
              <label>Version:
                <select class="version-select">
                  <?php foreach ($versions[$product_id] as $index => $version): ?>
                    <option value="<?= $index ?>"><?= htmlspecialchars($version['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </label>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</main>

<!--page footer-->
<footer>
  <p>&copy; 2025 Fall-1-Factor Industries. All Rights Reserved</p>
</footer>

<script src="js_files/main.js"></script>

<!--script for automatically scrolling through products on homepage-->
<script>
  const scrollContainer = document.querySelector('.scrolling-container'); //container for scrolling

  let scrollSpeed = 1; //speed of scroll in pixels/anim frame

  function autoScroll() { //auto-scroll function
    scrollContainer.scrollLeft += scrollSpeed; //horizontal direction specified

    
    if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth - scrollContainer.clientWidth) {
      scrollContainer.scrollLeft = 0; //this reset when end is reached
    }

    requestAnimationFrame(autoScroll); //this keeps scrolling on following animation frame
  }

  autoScroll(); //function call(begin auto-scrolling)
</script>

</body>
</html>

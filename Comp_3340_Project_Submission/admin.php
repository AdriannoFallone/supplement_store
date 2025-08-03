
<?php

//start the session
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header('Location: index.php'); //determine if user has access to the admin panel (admin or standard user)
    exit();
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
  <link id="themeStyle" rel="stylesheet" href="css_files/admin1.css">
  <title>Fall-1-Factor</title>
</head>
<body>

<header>
<ul style = "list-style-type: none;">

  <li><a href="index.php">Home</a></li> <!-- links back to homepage-->
  <li><a href="status.php">Server Status Page</a> </li> <!-- links to server page-->
</header>

    <h1>Admin Dashboard</h1>

    <!--Theme switching drop-down for dynamic style-abilities of admin.php-->
    <div class="section">
        <h3>Switch Site Theme</h3>
        <select id="themeSelector">
      <option value="css_files/admin1.css">Standard</option> <!--my default style-->
      <option value="css_files/admin2.css">Bulking</option>
      <option value="css_files/admin3.css">Cutting</option>
    </select>
    </div>

    <!--Section used to manage products in the db-->
    <div class="section">
        <h3>Edit Products</h3>
        <div id="productTable"></div>
    </div>

    <!--Section to manage users in the db-->
    <div class="section">
        <h3>Manage User Accounts</h3>
        <div id="userTable"></div>
    </div>

    <script>
        //Based on the dropdown selection, theme is switched from its default value, if applicable
    document.getElementById('themeSelector').addEventListener('change', function () {
      document.getElementById('themeStyle').setAttribute('href', this.value);
    });

    //Get products from the server and display them to admins in a table(which they can dynamically change)
    fetch('admin_fetch_products.php')
      .then(res => res.json()) //response to .json
      .then(products => {
        
        //creates the table
        const table = document.createElement('table');
        table.innerHTML = '<tr><th>Name</th><th>Price</th><th>Update</th></tr>';
        
        //creates a table row for each product via forEach loop
        products.forEach(p => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><input value="${p.name}" id="name-${p.id}" /></td>
            <td><input type="number" value="${p.price}" id="price-${p.id}" /></td>
            <td><button onclick="updateProduct(${p.id})">Save</button></td>
          `;
          table.appendChild(row); //adds current row to the table
        });
        document.getElementById('productTable').appendChild(table);
      });

    //sends product updates directly to db server
    function updateProduct(product_id) {
      const name = document.getElementById(`name-${product_id}`).value;
      const price = document.getElementById(`price-${product_id}`).value;
      
      //updates products in the db
      fetch('admin_update_product.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `product_id=${product_id}&name=${encodeURIComponent(name)}&price=${price}`
      }).then(res => res.text()).then(alert);
    }

//gets the users from the users table in the db and shows them in a table
fetch('admin_fetch_users.php')
  .then(res => res.json()) // response to .json
  .then(users => {
    
    //table creation for user data
    const table = document.createElement('table');
    table.innerHTML = '<tr><th>Username</th><th>Status</th><th>Action</th></tr>';
    
    //creates new row for each user
    users.forEach(u => {
      const row = document.createElement('tr');
      const status = u.disabled == 1 ? 'Disabled' : 'Active';
      row.innerHTML = `
        <td>${u.username}</td>
        <td>${status}</td>
        <td>
          <button onclick="disableUser(${u.user_id}, ${u.disabled})">Disable</button>
          <button onclick="reactivateUser(${u.user_id}, ${u.disabled})">Activate</button>
        </td> 
      `; //buttons for activating user and disabling user
      table.appendChild(row); //adds the current row to the table
    });
    document.getElementById('userTable').appendChild(table);
  });


//function to disable user
function disableUser(user_id, disabled) {
  if (disabled == 1) //check if already disabled
  {
    alert("User already disabled");
    return;
  }
  toggleUserStatus(user_id, 1);  //disabled = 1 in db
}

//active a user if they are disabled
function reactivateUser(user_id, disabled) {
  if (disabled == 0) {
    alert("User already active");
    return;
  }
  toggleUserStatus(user_id, 0); //active = 0 in db
}

//request to change user status based on update(s)
function toggleUserStatus(user_id, targetStatus) {
  fetch('admin_toggle_user.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `user_id=${user_id}&target_status=${targetStatus}`
  })
  .then(res => res.text())
  .then(alert)
  .then(() => location.reload());
}

    </script>

</body>

</html>
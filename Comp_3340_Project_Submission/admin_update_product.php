<?php
session_start(); //starts session
require 'db_connection.php'; //links do db connection file

//get and store product data locally
$id = $_POST['product_id'];
$name = $_POST['name'];
$price = $_POST['price'];

$stmt = $conn->prepare("UPDATE products SET name=?, price=? WHERE product_id=?"); //prepare query for performing update
$stmt->bind_param("sdi", $name, $price, $id);
$stmt->execute(); //update command

echo "Product updated successfully."; //success message shown to user

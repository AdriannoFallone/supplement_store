<?php
//start session
session_start();
require 'db_connection.php';

$result = $conn->query("SELECT product_id, name, price FROM products"); //gets attributes from the product table in the db
$products = []; //hold the product info

//goes through each row in the database and adds to the above array
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
echo json_encode($products); //return as .json response

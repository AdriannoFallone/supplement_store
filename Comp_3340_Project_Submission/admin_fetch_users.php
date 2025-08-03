<?php


require 'db_connection.php'; //links to db connection file

$result = $conn->query("SELECT  user_id, username, disabled FROM users");  //selects userid, username, and disabled attribute from users table in the db
$users = []; //holds the data

//add each user's infor to the array
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users); //output as .json response

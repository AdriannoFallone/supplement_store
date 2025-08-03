<?php
session_start(); //starts the session
require 'db_connection.php'; //links to db connection file

//verify that user_id is set
if (!isset($_POST['user_id'])) {
    die("Error: user_id not provided.");  //haults program execution
}

$id = (int) $_POST['user_id']; //cast to integer to maintain my table datatypes

//validates user_id
if ($id <= 0) {
    die("Error: Invalid user ID.");
}

//makes sure that the user has admin privellege in db
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    die("Access denied.");
}

$result = $conn->query("SELECT disabled FROM users WHERE user_id = $id"); //returns whether user is enabled or disabled

//verify user exists
if (!$result || $result->num_rows === 0) {
    die("Error: User not found.");
}

$current = $result->fetch_assoc()['disabled'];
$new_status = $current == 1 ? 0 : 1;


//updates status of user in db
if ($conn->query("UPDATE users SET disabled = $new_status WHERE user_id = $id")) {
    echo "User status updated.";
} else {
    echo "Error updating user: " . $conn->error;
}

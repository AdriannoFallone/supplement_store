<?php

session_start(); //start session
require 'db_connection.php'; //link to db connection file

header('Content-Type: text/plain; charset=utf-8'); //plain text response config

//confirm user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); //return error
    exit("You must be logged in to update your information.");
}

//get user_id
$user_id = $_SESSION['user_id'];

//get input values in form
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');


//error if both fields are empty
if (empty($username) && empty($password)) {
    http_response_code(400);
    exit("Please provide a new username or password.");
}

//if username is filled in, update the db
if (!empty($username)) {
    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE user_id = ?");
    $stmt->bind_param("si", $username, $user_id);
    $stmt->execute();
}

//if password is filled in, update the db
if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashed, $user_id);
    $stmt->execute();
}

echo "User info updated successfully."; //success message displayed to user
?>

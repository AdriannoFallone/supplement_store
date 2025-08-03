<?php
//credentials for db sign-on
$host = 'localhost';
$db = 'fallone2_supplement_store';
$user = 'fallone2_supplement_store';
$pass = '';

//connection made to db
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); //error message upon failure
}
$conn->set_charset("utf8mb4");
?>

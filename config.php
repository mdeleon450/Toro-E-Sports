<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$database = "users";

// Create connection
$link = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<?php
// Include config file
require "config.php";
// Initialize the session
session_start();

if (mysqli_query($link, "UPDATE user SET isonline = 0 WHERE username = '".$_SESSION["username"]."'")){
	// Unset all of the session variables
	$_SESSION = array();
	// Destroy the session.
	session_destroy();
	// Redirect to login page
	header("location: index.php");
	exit;
	
}
else echo "Error trying to logout.";
?>
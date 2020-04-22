<?php
// Include config file
require_once "..\config.php";
include 'myteam.php';
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index1.php");
    exit;
}
	$deleteTeam = "DELETE FROM team WHERE idteam = $teamid";
	// trying to create a delete team 

	if($link->query($deleteTeam) === TRUE){ 
		echo "Team was disbanded successfully.";
		echo "	<script>
					window.onload = function(){
						setTimeout(\"location.href = 'myteam.php'\",125);	
					};
				</script>";
	}  
	else{ 
		echo "ERROR: Could not disband team." . mysqli_error($link); 
	} 
	// ends here
?>
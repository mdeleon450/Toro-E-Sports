<?php
	// Include config file
	require "../config.php";
	// Initialize the session
	session_start();
	$msg = "";
	$msg_class = "";
	if (isset($_POST['save_profile'])) {
	// for the database
	$bio = stripslashes($_POST['bio']);
	$profileImageName = time() . '-' . $_FILES["profileImage"]["name"];
	// For image upload
	$target_dir = "userpics/";
	$target_file = $target_dir . basename($profileImageName);
	// VALIDATION
	// validate image size. Size is calculated in Bytes
	if($_FILES['profileImage']['size'] > 200000) {
	  $msg = "Image size should not be greated than 200Kb";
	  $msg_class = "alert-danger";
	}
	$sql = "SELECT user_dir FROM user_image 
			WHERE iduser = (SELECT iduser FROM user WHERE username = '".$_SESSION['username']."')";
		if(mysqli_query($link, $sql)){
			// check if file exists
			if($pevious_target_file == "default.png") {
			  
			}
			else if(file_exists($pevious_target_file)) {
			  unlink($pevious_target_file);
			}
		}
	
	// Upload image only if no errors
	if (empty($error)) {
	  if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
		  echo $profileImageName;
		  echo $target_file;
		$sql = "UPDATE user_image SET image_dir = '$profileImageName', bio='$bio', is_set = 1 
				WHERE iduser = (SELECT iduser FROM user WHERE username = '".$_SESSION['username']."')";
		if(mysqli_query($link, $sql)){
		  $msg = "Image uploaded and saved in the Database";
		  $msg_class = "alert-success";
		  // Redirect user to welcome page
          header("location: profile.php");
		} 
		else {
		  $msg = "There was an error in the database";
		  $msg_class = "alert-danger";
		}
	  } 
	  else {
		$error = "There was an erro uploading the file";
		$msg = "alert-danger";
	  }
	}
}
?>
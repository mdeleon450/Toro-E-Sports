<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	// User is not logged in don't do antyhing
}

else if (strcmp ($_GET['user'], $_SESSION['username']) == 0){
	// The user is viewing their own profile
	header("location: signedinuser/profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="signedinuser/css/profile.css">
    <title>	Profile</title>
</head>
<body>
<aside>
	<figure>
	</figure>
	<img class = "imenu" src = "images/menu.svg">
		<nav>
            <div id="mtabs">
                <ul>
					<li><a href="javascript:history.back()">Go Back</a></li>
					<li><a href="..\index.php">Home</a></li>
					<li><a href="#">Messege This User</a></li>
                </ul>
            </div>
        </nav>
</aside>
    <main>
		<h1 id = "mainContent">
		<div id = "avatar">
			<?php
			$username = $_GET['user'];
			
				
			$resultUserID = mysqli_query($link, "SELECT iduser FROM user WHERE username = '".$username."'");
			$rowUser = mysqli_fetch_assoc($resultUserID);
			$userid = $rowUser["iduser"];
			$table = "SELECT image_dir FROM user_image JOIN user USING (iduser) WHERE iduser = '$userid'";
			if($result = $link->query($table)){
				$row = $result->fetch_assoc();
				$imagelocation = "signedinuser/userpics/".$row['image_dir'];
				echo '<img class = "toro" src ='.$imagelocation.' style="width:250px;height:250px;" >';
			}
			?>
		</div>
            Bio
        </h1>
		<p id = "subContent">
			<?php
			
			$resultBio = mysqli_query($link, "SELECT bio FROM user_image 
											WHERE iduser = 
											(SELECT iduser FROM user WHERE username = '".$username."') LIMIT 1");
			$rowBio = mysqli_fetch_assoc($resultBio);
			echo "" . $rowBio['bio'];
				
				
			?>
        </p>
        <h1 id = "mainContent">
            Recent Matches
        </h1>
		<p id = "subContent">
			<?php
			
			$result = mysqli_query($link, "SELECT created_at FROM user WHERE username = '$username' LIMIT 1");
			$row = mysqli_fetch_assoc($result);
			echo "Member since: " . $row['created_at'];
				
				
			?>
        </p>
        <p id = "subContent">
            <?php
			
			$result = mysqli_query($link, "SELECT * FROM user WHERE username = '$username' LIMIT 1");
			$row = mysqli_fetch_assoc($result);
			echo 
					'<br>Wins: '.$row['user_wins'].' </br> 
					<br>Losses: '.$row['user_wins'].' </br> 
					<br>Matches: '.$row['user_matches'].' </br>';
				
				
			$link->close();
			?>
        </p>
    </main>
    <script>
        (function() {
            var menu = document.querySelector('ul'),
            menulink = document.querySelector('.imenu');

            menulink.addEventListener('click',function(e) {
                menu.classList.toggle('active');
                e.preventDefault();
            });
        })();
    </script>
</body>
</html>
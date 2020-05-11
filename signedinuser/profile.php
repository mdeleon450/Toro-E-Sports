<?php

// Include config file
require "../config.php";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ..\index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/profile.css">
    <title>	Profile</title>
</head>
<body>
    <aside>
        <figure>
            <div id = "avatar" >
                <?php
                $userid = $_SESSION['id'];
                $table = "SELECT image_dir FROM user_image JOIN user USING (iduser) WHERE iduser = '$userid'";
                if($result = $link->query($table)){
                    $row = $result->fetch_assoc();
                    $imagelocation = "userpics/".$row['image_dir'];
                    echo '<img class = "toro" src ='.$imagelocation.'>';
                }
                ?>
            </div>
            <figcaption><?php echo $_SESSION["username"]?></figcaption>
        </figure>
        <img class = "imenu" src = "images/menu.svg">
        
        <nav>
            <div id="mtabs">
                <ul>
					<li><a href="..\index.php">Home</a></li>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="myteam.php">My Team</a></li>
                    <li><a href="myladders.php">My Ladders</a></li>
                    <li><a href="inbox.php">Inbox</a></li>
                    <li><a href="../signout.php">Sign Out</a></li>
                </ul>
            </div>
        </nav>
    </aside>
    <main>
	<div class="mainContent" align = "right">
        <input type = "submit" class="button" value="Edit Profile" onclick="document.location.href='form.php';"/>
	</div>
		<h1 id = "mainContent">
            Bio
        </h1>
		<p id = "subContent">
			<?php
			$username = $_SESSION["username"];
			
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
			$username = $_SESSION["username"];
			
			$result = mysqli_query($link, "SELECT created_at FROM user WHERE username = '$username' LIMIT 1");
			$row = mysqli_fetch_assoc($result);
			echo "Member since: " . $row['created_at'];
				
				
			?>
        </p>
        <p id = "subContent">
            <?php
			$username = $_SESSION["username"];
			
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
        $("input[type='image']").click(function() {
		$("input[id='my_file']").click();
		});
		
		var loadFile = function(event) {
			var image = document.getElementById('output');
			image.src = URL.createObjectURL(event.target.files[0]);
		};
    </script>
</body>
</html>
<?php

// Include config file
require_once "..\config.php";

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
            <div id = "avatar" ></div>
			<img src = "images/toro.jpeg">
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
                </ul>
            </div>
        </nav>
    </aside>
    <main>
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
					'<br>Wins: '.$row['player_wins'].' </br> 
					<br>Matches: '.$row['player_matches'].' </br>';
				
				
			$link->close();
			?>
        </p>
    </main>
    <script>
        (function() {
            var menu = document.querySelector('ul'),
            menulink = document.querySelector('img');

            menulink.addEventListener('click',function(e) {
                menu.classList.toggle('active');
                e.preventDefault();
            });
        })();
    </script>
</body>
</html>
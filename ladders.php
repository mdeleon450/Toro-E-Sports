<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/main.css">
    <title>Ladders</title>
</head>
<body>
    <div class = "banner">
			<img class = "imenu" src = "images/menu.svg">
            <img class = "logo" src = "images/csudh.png">
			<nav>
                <div id = "mtabs">
                    <ul>
                        <li><a class="active" href = "index.php">Home</a></li>
                        <li><a href = "ladders.php">Ladders</a></li>
                        <li><a href = "leaderboards.php">Leaderboards</a></li>
                        <?php 	// Check if the user is already logged in
								if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
									echo "<li><a href = 'loggedteams.php'>Teams</a></li>";
									echo "<li><a href = 'signedinuser/profile.php'>Profile</a></li>";
									echo "<li><a href = 'signout.php'>Sign Out</a></li>";
								}
								
								else {
									echo "<li><a href = 'teams.php'>Teams</a></li>";
									echo "<li><a href = 'signin.php'>Sign In</a></li>";}
						?>
                    </ul>
                </div>
            </nav>
            <img class = "esport" src= "images/esportstoro.png">
    </div>
			
    <div class = "content">
	
        <div class = "searchbar">
            <input type="text" placeholder="Search..">
            <button type="submit"><i class="material-icons">search</i></button>
        </div>
		<div>
			<table id = "ladder" style="width:100%">

				
				<?php

				$table = "SELECT * FROM ladder";
				if ($result = $link->query($table)) {
					while ($row = $result->fetch_assoc()) {
						$ladderType = $row["ladderType"];
						$ladderGame = $row["game_idgame"];
						
						$getGameName = "SELECT game_name, game_image FROM game WHERE idgame = $ladderGame";
						$result1 = $link->query($getGameName);
						$row1 = $result1->fetch_assoc();
						$ladderGame = $row1["game_name"];
						$gameImage = $row1["game_image"];
						
						echo '<div class="container">
								<br> 
									<br>Ladder Type: <a href="">'.$ladderType.'</a></br>
									<br>Ladder Game: '.$ladderGame.'</br> 
									<br><img src="images/games/'.$gameImage.'.png" alt='.$ladderGame.'></br>
								</br>
							</div>';
					}
				}
				?>
			</table>
		</div>
	</div>
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
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
    <title>Leaderboards</title>
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
		<div class = "hiddenLayer">
				<table>
				  <tr>
					<th>Player</th>
					<th>Wins</th>
					<th>Matches</th>
				  
				  <?php
	
					$table = "SELECT * FROM user";
					if ($result = $link->query($table)) {
						while ($row = $result->fetch_assoc()) {
							$username = $row['username'];
							$playerwins = $row['player_wins'];
							$playermatches = $row['player_matches'];
							
							echo '<tr align = "center"> 
									<td>'.$username.'</td>
									<td>'.$playerwins.'</td> 
									<td>'.$playermatches.'</td> 
								</tr>';
						}
						
					$link->close();
					
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
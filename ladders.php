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
                        <li><a href = "teams.php">Teams</a></li>
                        <?php 	// Check if the user is already logged in
								if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
									echo "<li><a href = 'signedinuser\profile.php'>Profile</a></li>";
									echo "<li><a href = 'signout.php'>Sign Out</a></li>";
								}
								
								else echo "<li><a href = 'signin.php'>Sign In</a></li>";
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
		<h1 id="mainContent">Ladders</h1>
			<p>Filter by Game<p>
			<a href = ""><div class="img" style="background-image:url('images/games/fifa20.jpeg');"></div></a>
			<div class="img" style="background-image:url('images/games/rocketleague.jpg');"></div>
			<div class="img" style="background-image:url('images/games/codmw.png');"></div>
			<div class="img" style="background-image:url('images/games/smashultimate.jpg');"></div>
			<div class="img" style="background-image:url('images/games/lol.jpg');"></div>
		</div>
		<div>
			<p >
				<?php
	
				$table = "SELECT * FROM ladder";
				if ($result = $link->query($table)) {
					while ($row = $result->fetch_assoc()) {
						$ladderType = $row["ladderType"];
						$ladderTime = $row["ladderTime"];
						
						echo '<br> 
								<br>Ladder Type: <a href = "">'.$ladderType.'</a></br> 
								<br>Ladder Time: '.$ladderTime.'</br> 
							</br>';
					}
					
				$link->close();
				
				}
				?>
			</p>
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
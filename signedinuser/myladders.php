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
    <title>	My Ladders</title>
</head>
<body>
    <aside>
         <figure>
            <div id = "avatar" >
                <img class = "toro" src = "images/toro.jpeg">
                <figcaption><?php echo $_SESSION["username"]?></figcaption>
            </div>
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
        <h1 id = "mainContent">
            My Ladders
        </h1>
                <?php
                    $userid = $_SESSION["id"];
                    $table = "SELECT ladderType, game_name, game_image FROM game JOIN game_has_ladder USING (idgame) JOIN ladder USING (idladder) JOIN team_in_ladder USING (idladder) JOIN team USING (idteam) JOIN user_has_team USING (idteam) JOIN user USING (iduser) WHERE (iduser = '$userid')";
                    if ($result = $link->query($table)){
                        while ($row = $result->fetch_assoc()) {
					        	$ladderType = $row["ladderType"];
					            $ladderGame = $row["game_name"];
        						$gameImage = $row["game_image"];
	        					$imageLocation = '../images/games/'.$gameImage;
		        				echo '<div class="ladder" style = "background-image: url('.$imageLocation.'); background-position: center; background-repeat:no-repeat; background-size:cover; ">
		        						<div class = "ladderText" style= "position: absolute; bottom: 5%;">
				        					<br>Ladder Type: <a style= "text-decoration: none; color: #fff" href="">'.$ladderType.'</a></br>
				        					<br>Ladder Game: '.$ladderGame.'</br> 
						        		</div>
							        </div>';
			            }
                    }
					else {
						echo 'No ladders found. Either join a ladder or join team.';
					}
                ?>
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
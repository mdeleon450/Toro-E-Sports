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
                        <?php 	
                            // Check if the user is already logged in
							if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
								$username = $_SESSION["username"];
								$table = "SELECT iduser FROM user_has_team WHERE iduser = (SELECT iduser FROM user WHERE username = '$username')"; 
								if ($result = $link->query($table)) {
									
									if ($row = $result->fetch_assoc()) {
										
										$currentUser = mysqli_query($link, "SELECT iduser FROM user WHERE username = '$username'");
										$row = mysqli_fetch_assoc($currentUser);
										$iduser = $row['iduser'];
										if ($row['iduser'] == $iduser){
											echo "<li><a href = 'teams.php'>Teams</a></li>";
											echo "<li><a href = 'signedinuser/profile.php'>Profile</a></li>";
											echo "<li><a href = 'signout.php'>Sign Out</a></li>";
										}
									}
									else {
										echo "<li><a href = 'loggedteams.php'>Teams</a></li>";
										echo "<li><a href = 'signedinuser/profile.php'>Profile</a></li>";
										echo "<li><a href = 'signout.php'>Sign Out</a></li>";
									}
								}
								else {
									echo "Error with database.";
								}
							}
							else {
							    echo "<li><a href = 'teams.php'>Teams</a></li>";
								echo "<li><a href = 'signin.php'>Sign In</a></li>";
							}
						?>
                    </ul>
                </div>
            </nav>
            <img class = "esport" src= "images/esportstoro.png">
    </div>
	<div class = "searchbar">
            <form method = "POST">
                <input name = "search" type="text" placeholder="Search..">
                <button name = "searchBtn" type="submit"><i class="material-icons">search</i></button>
            </form>
    </div>
    <div class = "content">
        <br><br><br><br><h1 id = "mainContent" align = "center">Ladders</h1>
		<div class = "hiddenLayer" style="padding-left: 2em">
			<table id = "ladder" style="width:100%">

				
				<?php
                    if(!empty($_POST['search']) && isset($_POST['searchBtn'])){
	                    $sterm = '%'.$_POST['search'].'%';
				        $table = "SELECT game_name, game_image, ladderType from game JOIN game_has_ladder USING (idgame) JOIN ladder USING (idladder) WHERE CONCAT(ladderType, game_name) LIKE '%".$sterm."'";
				        if ($result = $link->query($table)) {
					        while ($row = $result->fetch_assoc()) {
					        	$ladderType = $row["ladderType"];
					            $ladderGame = $row["game_name"];
        						$gameImage = $row["game_image"];
	        					$imageLocation = 'images/games/'.$gameImage;
		        				echo '<div class="ladder" style = "background-image: url('.$imageLocation.'); background-position: center; background-repeat:no-repeat; background-size:cover; ">
		        						<div class = "ladderText" style= "position: absolute; bottom: 5%;">
				        					<br>Ladder Type: <a style= "text-decoration: none; color: #fff" href="teams.php?type='.$ladderType.'&game='.$ladderGame.'">'.$ladderType.'</a></br>
				        					<br>Ladder Game: '.$ladderGame.'</br> 
						        		</div>
							        </div>';
			                }
				        }
				    }
				    else{
				        $table = "SELECT game_name, game_image, ladderType from game JOIN game_has_ladder USING (idgame) JOIN ladder USING (idladder)";
				        if ($result = $link->query($table)) {
					        while ($row = $result->fetch_assoc()) {
					        	$ladderType = $row["ladderType"];
					            $ladderGame = $row["game_name"];
        						$gameImage = $row["game_image"];
	        					$imageLocation = 'images/games/'.$gameImage;
		        				echo '<div class="ladder" style = "background-image: url('.$imageLocation.'); background-position: center; background-repeat:no-repeat; background-size:cover; ">
		        						<div class = "ladderText" style= "position: absolute; bottom: 5%;">
				        					<br>Ladder Type: <a style= "text-decoration: none; color: #fff" href="teams.php?type='.$ladderType.'&game='.$ladderGame.'">'.$ladderType.'</a></br>
				        					<br>Ladder Game: '.$ladderGame.'</br> 
						        		</div>
							        </div>';
			                }
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
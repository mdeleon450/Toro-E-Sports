

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
									echo "<li><a href = 'signedinuser\profile.php'>Profile</a></li>";
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
				<?php
					$ladderType = $_SESSION['ladderType'];
					if ($ladderType === "Single Team"){
						echo '<h1> id="mainContent">Single Team Ladder</h1>';
						$ladderTeams = "SELECT * FROM team_in_ladder WHERE ladder_idladder = 1";
						
						if($result = $link->query($ladderTeams)) {
							while ($row = $result->fetch_assoc()) {
								$teamid = $row["team_idteam"];
								
								$teamFound = mysqli_query($link, "SELECT team_name, team_owner, team_matches, team_wins FROM team WHERE idteam = '$teamid'");
								$rowTeam = mysqli_fetch_assoc($teamFound);
								echo '<br> 
										<br>Team Name: <a href = "ladderInfo.php">'.$rowTeam['team_name'].'</a></br> 
										<br>Team Owner: '.$rowTeam['team_owner'].'</br>
										<br>Matches Played: '.$rowTeam['team_matches'].'</br> 
										<br>Matches Won: '.$rowTeam['team_wins'].'</br> 
									</br>';
							}
						}
						else {
							echo '<br>No Teams In Ladder</br>';
						}
					}
					else {
						echo $ladderType;
						//echo '<h1> id="mainContent">Double Team Ladder</h1>';
						$ladderTeams = "SELECT * FROM team_in_ladder WHERE ladder_idladder = 2";
						
						if ($result = $link->query($ladderTeams)) {
							while ($row = $result->fetch_assoc()) {
								$teamid = $row["team_idteam"];
								
								$teamFound = mysqli_query($link, "SELECT team_name, team_owner, team_matches, team_wins FROM team WHERE idteam = '$teamid'");
								$rowTeam = mysqli_fetch_assoc($teamFound);
								echo '<br> 
										<br>Team Name: <a href = "ladderInfo.php">'.$rowTeam['team_name'].'</a></br> 
										<br>Team Owner: '.$rowTeam['team_owner'].'</br>
										<br>Matches Played: '.$rowTeam['team_matches'].'</br> 
										<br>Matches Won: '.$rowTeam['team_wins'].'</br> 
									</br>';
							}
						}
						else {
							echo '<br>No Teams In Ladder</br>';
						}
					}
					$link->close();
				?>
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
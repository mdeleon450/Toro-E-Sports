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
    <title>Teams</title>
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
			
    <div class = "content">
	
        <div class = "searchbar">
            <form method = "POST">
                <input name = "search" type="text" placeholder="Search..">
                <button name = "searchBtn" type="submit"><i class="material-icons">search</i></button>
            </form>
        </div>
		
		<div>       
				<?php
				if(isset($_GET['type']) && isset($_GET['game'])){
					$ladderType = $_GET['type'];
				    $ladderGame = $_GET['game'];
					echo '<br><br><br><br><h1 id = "mainContent" align = "center">Teams playing in '.$ladderType.'</h1><h2 align = "center">Game: '.$ladderGame.'</h2>
							<div class = "hiddenLayer">
								<table>';
					// Check to see if current user has a team in this ladder			
					$currUserInTeam = "select team_in_ladder.idteam, team_in_ladder.idladder, team_in_ladder.idgame 
										from team_in_ladder 
										join team using (idteam) 
										join user_has_team using (idteam) 
										join user using (iduser) 
										where iduser = (select iduser from user where username = '$username')";
					if ($resultCurrTeamInLadder = $link->query($currUserInTeam)) {
					    if (empty($rowCurrTeamInLadder = $resultCurrTeamInLadder->fetch_assoc())) {
							if (!(isset($_SESSION["loggedin"]))){
								echo "<a href = 'signin.php'>Please sign in to join a ladder</a><br>";
							}
							else {
								$user_has_team = "select idteam, team_owner, team_type, idgame
													from team
													join user_has_team using (idteam)
													join user using (iduser)
													where iduser = (select iduser from user where username = '$username' AND 
													team_owner = '$username')";
								$foundUserTeam = mysqli_query($link, $user_has_team);
								$rowUserTeam = mysqli_fetch_assoc($foundUserTeam);
								
								if (empty($rowUserTeam))
									echo "<a href = 'loggedteams.php'>Create a team</a><a> to join ladder or ask the owner of your team.</a><br>";
								
								else {
									
									echo '<div class="form">
											<input type="submit" class="button" value="Join Ladder">
										</div><br>';
								}
							}
						}
						
						else {
							$idladder = $rowCurrTeamInLadder["idladder"];
							$idgame = $rowCurrTeamInLadder["idgame"];
							
							$foundLadder = mysqli_query($link, "SELECT idladder FROM ladder WHERE ladderType = '".$_GET["type"]."'");
							$rowLadder = mysqli_fetch_assoc($foundLadder);
							
							$foundGame = mysqli_query($link, "SELECT idgame FROM game WHERE game_name = '".$_GET["game"]."'");
							$rowGame = mysqli_fetch_assoc($foundGame);
							
							$foundOwner = mysqli_query($link, "SELECT * FROM team WHERE team_owner = '".$_SESSION["username"]."'");
							$rowOwner = mysqli_fetch_assoc($foundOwner);
							if ($rowOwner === null) $idteam = null;
							
							else $idteam = $rowOwner["idteam"];
							
							if ($idladder == $rowLadder["idladder"] && $idgame == $rowGame["idgame"] && !($idteam === null)){
								$ladderType = $_GET['type'];
								$ladderGame = $_GET['game'];
								echo '<div class="form">
										<a style = "text-decoration:none;" href="viewMatches.php?type='.$ladderType.'&game='.$ladderGame.'&team='.$idteam.'"><input type="submit" class="button" value="View/Post Matches"</a>
									</div><br>';
							}
						}
					}
				    
					$currentGame = mysqli_query($link, "SELECT idgame FROM game WHERE game_name = '$ladderGame'");
					$rowGame = mysqli_fetch_assoc($currentGame);
					$idgame = $rowGame["idgame"];
				    $tableTeams = "SELECT team_name, team_owner, team_wins, team_losses, team_type, team_matches, idgame
								FROM team
								WHERE team_type = '".$ladderType."' AND idgame = $idgame ORDER BY team_wins DESC";
					echo '<tr class = "headers">
									<th>Name</th>
									<th>Owner</th>
									<th>Wins</th>
									<th>Losses</th>
									<th>Matches</th>
									</tr>';
				    if ($resultTeamsInLadder = $link->query($tableTeams)) {
					    while ($rowTeamInLadder = $resultTeamsInLadder->fetch_assoc()) {
							
					    	$teamname = $rowTeamInLadder["team_name"];
						    $teamowner = $rowTeamInLadder["team_owner"];
					    	$teamwins = $rowTeamInLadder["team_wins"];
							$teamlosses = $rowTeamInLadder["team_losses"];
					    	$teammatches = $rowTeamInLadder["team_matches"];
						
					    	echo '<tr> 
									<td><a href = "leaderboards.php?team='.$teamname.'">'.$teamname.'</a></td> 
									<td><a href = "leaderboards.php?team='.$teamname.'&player='.$teamowner.'">'.$teamowner.'</a></td> 
									<td>'.$teamwins.'	</td> 
									<td>'.$teamlosses.'	</td> 
									<td>'.$teammatches.'	</td> 
								</tr>';
					    }
						
					
				    $link->close();
				
				    }
				}
				else if(!empty($_POST['search']) && isset($_POST['searchBtn'])){
					echo '<br><br><br><br><h1 id="mainContent" align = "center">Teams</h1>
							<div class = "hiddenLayer">
								<table>';
					echo '<tr class = "headers">
							<th>Name</th>
							<th>Owner</th>
							<th>Type</th>
							<th>Wins</th>
							<th>Losses</th>
							<th>Matches</th>
						</tr>';
	                    $sterm = '%'.$_POST['search'].'%';
	                    $table = "SELECT * FROM team WHERE (team_name LIKE '$sterm') ORDER BY team_wins DESC";
				        if ($result = $link->query($table)) {
					        while ($row = $result->fetch_assoc()) {
					        	$teamname = $row["team_name"];
					        	$teamowner = $row["team_owner"];
					        	$teamtype = $row["team_type"];
					        	$teamwins = $row["team_wins"];
								$teamlosses = $row["team_losses"];
					        	$teammatches = $row["team_matches"];
						
					        	echo '<tr> 
						    		<td><a href = "leaderboards.php?team='.$teamname.'">'.$teamname.'</a></td> 
					    			<td><a href = "leaderboards.php?team='.$teamname.'&player='.$teamowner.'">'.$teamowner.'</a></td> 
							        	<td>'.$teamtype.'	</td> 
								        <td>'.$teamwins.'	</td> 
										<td>'.$teamlosses.'	</td> 
							        	<td>'.$teammatches.'	</td> 
							        </tr>';
					        }
				            $link->close();
				        }
				}
				else{
					echo '<br><br><br><br><h1 id="mainContent" align = "center">Teams</h1>
							<div class = "hiddenLayer">
								<table>';
					echo '<tr class = "headers">
							<th>Name</th>
							<th>Owner</th>
							<th>Type</th>
							<th>Wins</th>
							<th>Losses</th>
							<th>Matches</th>
						</tr>';
				    $table = "SELECT * FROM team ORDER BY team_wins DESC";
				    if ($result = $link->query($table)) {
					    while ($row = $result->fetch_assoc()) {
					    	$teamname = $row["team_name"];
						    $teamowner = $row["team_owner"];
						    $teamtype = $row["team_type"];
					    	$teamwins = $row["team_wins"];
							$teamlosses = $row["team_losses"];
					    	$teammatches = $row["team_matches"];
						
					    	echo '<tr> 
						    		<td><a href = "leaderboards.php?team='.$teamname.'">'.$teamname.'</a></td> 
					    			<td><a href = "leaderboards.php?team='.$teamname.'&player='.$teamowner.'">'.$teamowner.'</a></td> 
							    	<td>'.$teamtype.'	</td> 
							    	<td>'.$teamwins.'	</td> 
									<td>'.$teamlosses.'	</td> 
							    	<td>'.$teammatches.'	</td> 
						    	</tr>';
					    }
					
				    $link->close();
				
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
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
    <title>Home</title>
</head>
<body>
	<div class = "banner">
        <img class = "imenu" src = "images/menu.svg">
        <img class = "logo" src = "images/csudh.png" style="max-width:100%;height:auto;">
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
        <img class = "esport" src= "images/esportstoro.png" style="max-width:100%;height:auto;">
    </div>
    
	<div class = "content">
        <div class = "searchbar">
            <form method = "POST">
                <input name = "search" type="text" placeholder="Search..">
                <button name = "searchBtn" type="submit"><i class="material-icons">search</i></button>
            </form>
        </div>
		
        <br><br><br><br><h1 id = "mainContent" align = "center">Matches</h1>
        <div class = "subContainer">
			<table>
                <tr class = "headers">
                    <th>Time</th>
                    <th>Status</th>
                    <th>Team</th>
                    <th>Vs. Team</th>
					<th>Score</th>
                </tr>
				<?php
				   if(isset($_GET['type']) && isset($_GET['game']) && isset($_GET['team'])){
					  
					   $ladderGame = $_GET['game'];
					   $ladderType = $_GET['type'];
					   $idteam = $_GET['team'];
					   
					   echo '<div class="form">
										<a href="postMatch.php?type='.$ladderType.'&game='.$ladderGame.'&team='.$idteam.'"><input type="submit" class="button" value="Post a Match"</a>
							</div><br>';
					   
					   $matchTable = "SELECT matchTime, matchStatus, idteam, vsidteam, team1score1, team1score2, team2score1, team2score2  
					    FROM esportsladdersystem.match 
						WHERE idladder = (SELECT idladder FROM ladder WHERE ladderType = '".$ladderType."')
						AND idgame = (SELECT idgame FROM game WHERE game_name = '".$ladderGame."') 
						ORDER BY matchTime ASC";
	                    if ($resultMatches = $link->query($matchTable)) {
							 
							while ($rowMatch = $resultMatches->fetch_assoc()) {
								$matchTime = $rowMatch['matchTime'];
								$matchStatus = $rowMatch['matchStatus'];
								$matchTeam = $rowMatch['idteam'];
								$matchvsTeam = $rowMatch['vsidteam'];
								$matchScore1 = $rowMatch['team1score1'];
								$matchScore2 = $rowMatch['team1score2'];
								
								if ($matchvsTeam === null){
									if ($matchStatus === "Posted"){
										echo '<tr>
												<td><a href="">'.$matchTime.'</a></td>
												<td>'.$matchStatus.'</td>
												<td>'.$matchTeam.'</td>
												<td></td>
												<td></td>
										</tr>'; 
									}
								}
								else {
									
									$teamNameQuery = "SELECT team_name FROM team WHERE idteam = $matchTeam";
									$foundTeamName = mysqli_query($link, $teamNameQuery);
									$rowTeamName = mysqli_fetch_assoc($foundTeamName);
									$matchTeam = $rowTeamName['team_name'];
									
									$teamvsNameQuery = "SELECT team_name FROM team WHERE idteam = $matchvsTeam";
									$foundTeamName = mysqli_query($link, $teamvsNameQuery);
									$rowvsTeamName = mysqli_fetch_assoc($foundvsTeamName);
									$matchvsTeam = $rowvsTeamName['team_name'];
									echo '<tr>
                                            <td>'.$matchTime.'</td>
                                            <td>'.$matchStatus.'</td>
                                            <td>'.$matchTeam.'</td>
                                            <td>'.$matchvsTeam.'</td>
                                            <td>'.$matchScore1.'-'.$matchScore2.'</td>
                                    </tr>'; 
								}
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
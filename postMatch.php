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
		<?php
		    if(isset($_POST['Post'])){
		        $ladderType = $_GET['type'];
		        $game = $_GET['game'];
		        $teamid = $_GET['team'];
				$matchTime = $_POST["matchTime"];
				echo $matchTime;
		        $table = "SELECT idladder FROM ladder WHERE ladderType = '$ladderType'";
		        if($result = $link->query($table)){
		            $row = $result->fetch_assoc();
		            $ladderid = $row['idladder'];
		        }
		        $table = "SELECT idgame FROM game WHERE game_name = '$game'";
		        if($result = $link->query($table)){
		            $row = $result->fetch_assoc();
		            $gameid = $row['idgame'];
		        }
		        $table = "INSERT INTO esportsladdersystem.match (idgame, idladder, idteam) VALUES ('$gameid', '$ladderid', '$teamid')";
		        echo $table;
		        if($result = $link->query($table)){
		            echo '<h1> Successfuly Posted Match</h1>';
		        }
		    }
		?>
        <br><br><br><br><br><h1 align = "center">Posting a Match 
        </h1>
        <div class = "hiddenLayer">
			<form method = "post" style = table>
			    <?php 
                $ladderType = $_GET['type'];
                $game = $_GET['game'];
                echo '<br><input type = "text" value="'.$game.'"  disabled="disabled"/><br>
                        <br><input type ="text" value="'.$ladderType.'"  disabled="disabled"/><br><br>';
				?>
				<label for="meeting-time">Choose a time for the match:</label>
				<br><input type="datetime-local" id="myDatetimeField" name="matchTime"><br><br>
				
			    <input class = "button" name="Post" type = "submit" value = "Post" />
			</form>
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
		window.addEventListener("load", function() {
			var now = new Date();
			var utcString = now.toISOString().substring(0,19);
			var year = now.getFullYear();
			var month = now.getMonth() + 1;
			var day = now.getDate();
			var hour = now.getHours();
			var minute = now.getMinutes();
			var second = now.getSeconds();
			var localDatetime = year + "-" +
							  (month < 10 ? "0" + month.toString() : month) + "-" +
							  (day < 10 ? "0" + day.toString() : day) + "T" +
							  (hour < 10 ? "0" + hour.toString() : hour) + ":" +
							  (minute < 10 ? "0" + minute.toString() : minute) +
							  utcString.substring(16,19);
			var datetimeField = document.getElementById("myDatetimeField");
			datetimeField.value = localDatetime;
		});
    </script>
</body>
</html>
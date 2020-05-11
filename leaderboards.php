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
				  <?php
				    if(isset($_GET['player']) && isset($_GET['team'])){
						$teamName = $_GET['team'];
				        echo '<br><br><br><br><br><div><h1 align = "center">'.$teamName.'\'s Owner</h1></div>';
						echo '<div class = "hiddenLayer">
								<table style>
									<tr class = "headers">
										<th>Player</th>
										<th>Wins</th>
										<th>Matches</th>';
				        $sterm = $_GET['player'];
				        
				        $table = "SELECT * FROM user WHERE (username LIKE '$sterm') ORDER BY user_wins DESC";
	                    if ($result = $link->query($table)) {
						    while ($row = $result->fetch_assoc()) {
							    $username = $row['username'];
							    $playerwins = $row['user_wins'];
							    $playermatches = $row['user_matches'];
								$playerOnline = $row['isonline'];
								if ($playerOnline == 0){
									$imagelocation = "status/offline.png";
								}
								else $imagelocation = "status/online.png";
							
						    	echo '<tr align = "center"> 
							    		<td><a href="viewProfile.php?user='.$username.'">'.$username.'<a/><img class = "toro" src ='.$imagelocation.' style="width:13px;height:13px;" ></td>
								    	<td>'.$playerwins.'</td> 
								    	<td>'.$playermatches.'</td> 
								    </tr>';
					    	}
						
					    $link->close();
					
					    }
				    }
				    else if(isset($_GET['team'])){
						$teamName = $_GET['team'];
				        echo '<br><br><br><br><br><div><h1 align = "center">'.$teamName.'</h1><h3 align = "center">Members</h3></div>';
						echo ' <div class = "hiddenLayer">
									<table style>
										<tr class = "headers">
											<th>Player</th>
											<th>Wins</th>
											<th>Matches</th>';
				       
				        $table = "SELECT username, user_wins, user_matches, isonline FROM user JOIN user_has_team USING (iduser) JOIN team USING (idteam) WHERE team_name = '$teamName'";
				        if ($result = $link->query($table)) {
						    while ($row = $result->fetch_assoc()) {
							    $username = $row['username'];
							    $playerwins = $row['user_wins'];
							    $playermatches = $row['user_matches'];
								$playerOnline = $row['isonline'];
								if ($playerOnline == 0){
									$imagelocation = "status/offline.png";
								}
								else $imagelocation = "status/online.png";
							
						    	echo '<tr align = "center"> 
							    		<td><a href="viewProfile.php?user='.$username.'">'.$username.'<a/><img class = "toro" src ='.$imagelocation.' style="width:13px;height:13px;" ></td>
								    	<td>'.$playerwins.'</td> 
								    	<td>'.$playermatches.'</td> 
								    </tr>';
					    	}
						
					    $link->close();
					
					    }
				    }
	                else if(!empty($_POST['search']) && isset($_POST['searchBtn'])){
						echo '<br><br><br><br><h1 id = "mainContent" align = "center">Leaderboards</h1>
								<div class = "hiddenLayer">
									<table style>
										<tr class = "headers">
											<th>Player</th>
											<th>Wins</th>
											<th>Matches</th>';
	                    $sterm = '%'.$_POST['search'].'%';
	                    $table = "SELECT * FROM user WHERE (username LIKE '$sterm') ORDER BY user_wins DESC";
	                    if ($result = $link->query($table)) {
						    while ($row = $result->fetch_assoc()) {
							    $username = $row['username'];
							    $playerwins = $row['user_wins'];
							    $playermatches = $row['user_matches'];
								$playerOnline = $row['isonline'];
								if ($playerOnline == 0){
									$imagelocation = "status/offline.png";
								}
								else $imagelocation = "status/online.png";
							
						    	echo '<tr align = "center"> 
							    		<td><a href="viewProfile.php?user='.$username.'">'.$username.'<a/><img class = "toro" src ='.$imagelocation.' style="width:13px;height:13px;" ></td>
								    	<td>'.$playerwins.'</td> 
								    	<td>'.$playermatches.'</td> 
								    </tr>';
					    	}
						
					    $link->close();
					
					    }
	                }
	                else{
						echo '<br><br><br><br><h1 id = "mainContent" align = "center" >Leaderboards</h1>
								<div class = "hiddenLayer">
									<table style>
										<tr class = "headers">
											<th>Player</th>
											<th>Wins</th>
											<th>Matches</th>';
	                    $table = "SELECT * FROM user ORDER BY user_wins DESC";
					    if ($result = $link->query($table)) {
						    while ($row = $result->fetch_assoc()) {
							    $username = $row['username'];
							    $playerwins = $row['user_wins'];
							    $playermatches = $row['user_matches'];
								$playerOnline = $row['isonline'];
								if ($playerOnline == 0){
									$imagelocation = "status/offline.png";
								}
								else $imagelocation = "status/online.png";
							
						    	echo '<tr align = "center"> 
							    		<td><a href="viewProfile.php?user='.$username.'">'.$username.'</a><img class = "toro" src ='.$imagelocation.' style="width:13px;height:13px;" ></td>
								    	<td>'.$playerwins.'</td> 
								    	<td>'.$playermatches.'</td> 
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
<?php

// Include config file
require_once "config.php";

// Initialize the session
session_start();
 
 
// Form that was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate team name
    if(empty(trim($_POST["teamname"]))){
        $teamname_err = "Please enter a team name.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT idteam FROM team WHERE team_name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_teamname);
            
            // Set parameters
            $param_teamname = trim($_POST["teamname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $teamname_err = "This team name is already taken.";
					echo $teamname_err;
                } else{
                    $teamname = trim($_POST["teamname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
	// Validate team type
    if(empty(trim($_POST["teamtype"]))){
        $teamtype_err = "Please select a team type.";  
		echo $teamtype_err;
    } else{
        $teamtype = trim($_POST["teamtype"]);
    }
	
	$username = trim($_SESSION["username"]);
	
    // Check input errors before inserting in database
    if(empty($teamname_err) && empty($teamtype_err)){
        
        // Prepare an insert statement for team creation
        $sql = "INSERT INTO team (team_name, team_owner, team_type) VALUES (?, ? , ?)";
		
         
        if($stmt = mysqli_prepare($link, $sql)){
			
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_teamname, $param_username, $param_teamtype);
            
            // Set parameters
            $param_teamname = $teamname;
            $param_teamtype = $teamtype;
			$param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				
				// Get the team id
				$result = mysqli_query($link, "SELECT idteam FROM team WHERE team_owner = '$username' LIMIT 1");
				$row = mysqli_fetch_assoc($result);
				$idteam = (int)$row['idteam'];
				
				// Assign team to user
				// Get the user id
				$result = mysqli_query($link, "SELECT iduser FROM user WHERE username = '$username' LIMIT 1");
				$row = mysqli_fetch_assoc($result);
				$iduser = (int)$row['iduser'];
					
				// Prepare an update statement for the user's information
				$updateuser = "UPDATE user SET team_idteam = ? WHERE iduser = ?";
					
					 
				if($stmt = mysqli_prepare($link, $updateuser)){

					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "is", $param_idteam, $param_iduser);
						
					// Set parameters
					$param_idteam = $idteam;
					$param_iduser = $iduser;
						
					if(mysqli_stmt_execute($stmt)){
						// Redirect to login page
						header("location: signedinuser/myteam.php");
					}
						
					else {
						echo "Something went wrong. Please try again later.";
					}
						
						
					// Close statement
					mysqli_stmt_close($stmt);
					} 
					else {
						echo "Something went wrong. Please try again later.";
					}
				
				
				
            } 
			else {
                echo "Something went wrong. Please try again later.hi";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
		else {
                echo "Something went wrong. Please try again later.";
        }
    }
}
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
								while ($row = $result->fetch_assoc()) {
									$currentUser = mysqli_query($link, "SELECT iduser FROM user WHERE username = '$username'");
									$row = mysqli_fetch_assoc($currentUser);
									$iduser = $row['iduser'];
									if ($row['iduser'] == $iduser){
										echo "<li><a href = 'teams.php'>Teams</a></li>";
										echo "<li><a href = 'signedinuser/profile.php'>Profile</a></li>";
										echo "<li><a href = 'signout.php'>Sign Out</a></li>";
									}
									else {
										echo "<li><a href = 'loggedteams.php'>Teams</a></li>";
										echo "<li><a href = 'signedinuser/profile.php'>Profile</a></li>";
										echo "<li><a href = 'signout.php'>Sign Out</a></li>";
									}
								}
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
		<h1 id="mainContent">Teams</h1>
			<div class = "subContent" align = "center">
			    
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                    <div class="form">
                        <label>Team Name </label><br>
                        <input type="text" name="teamname" required >
					</div>
					
					<div class="form">
						<input type="radio" name="teamtype" value="Single Team" required>
						<label>Single Team</label>
					</div>
					
					<div class="form">
                        <input type="radio" name="teamtype" value="Double Team" required>
						<label>Double Team</label>
					</div>
					
					<div class="form">
                        <input type="radio" name="teamtype" value="Quad Team" required>
						<label>Quad Team</label>
					</div>
					
					<br>
					
					<div class="form">
                        <input type="submit" class="button" value="Register Team">
                    </div>
					
				</form>
			</div>
			
			<br>
			<div class = "hiddenLayer">
			    <table>
			        <tr class = "headers">
			            <th>Team Name</th>
			            <th>Team Owner</th>
			            <th>Team Type</th>
			            <th>Team Wins</th>
			            <th>Team Matches</th>
			        </tr>
				    <?php
				    if(!empty($_POST['search']) && isset($_POST['searchBtn'])){
	                    $sterm = '%'.$_POST['search'].'%';
	                    $table = "SELECT * FROM team WHERE (team_name LIKE '$sterm') OR (team_owner LIKE '$sterm') OR (team_type LIKE '$sterm') OR (team_matches LIKE '$sterm') OR (team_wins LIKE '$sterm')";
                        if ($result = $link->query($table)) {
					        while ($row = $result->fetch_assoc()) {
						        $teamname = $row["team_name"];
						        $teamowner = $row["team_owner"];
						        $teamtype = $row["team_type"];
						        $teamwins = $row["team_wins"];
						        $teammatches = $row["team_matches"];
						
						        echo '<tr> 
								    <td><a href = "">'.$teamname.'</a></td> 
								    <td><a href = "">'.$teamowner.'</a></td> 
								    <td>'.$teamtype.'	</td> 
								    <td>'.$teamwins.'	</td> 
								    <td>'.$teammatches.'	</td> 
							    </tr>';
					        }
					
				        $link->close();
				
				        }
				    }
				    else{
				        $table = "SELECT * FROM team";
				        if ($result = $link->query($table)) {
					        while ($row = $result->fetch_assoc()) {
						        $teamname = $row["team_name"];
						        $teamowner = $row["team_owner"];
						        $teamtype = $row["team_type"];
						        $teamwins = $row["team_wins"];
						        $teammatches = $row["team_matches"];
						
						        echo '<tr> 
								    <td><a href = "">'.$teamname.'</a></td> 
								    <td><a href = "">'.$teamowner.'</a></td> 
								    <td>'.$teamtype.'	</td> 
								    <td>'.$teamwins.'	</td> 
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
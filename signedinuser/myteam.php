<?php

// Include config file
require_once "../config.php";

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
    <title>	My Team</title>
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
            My Team
        </h1>
        <table>
			        <tr class = "headers">
			            <th>Members</th>
			        </tr>
			<?php
			$username = $_SESSION["username"];
			
			$table = "SELECT iduser, idteam FROM user_has_team WHERE iduser = (SELECT iduser FROM user WHERE username = '$username')"; 
			if ($result = $link->query($table)) {
				while ($rowUserHasTeam = $result->fetch_assoc()) {
					$currentUser = mysqli_query($link, "SELECT iduser FROM user WHERE username = '$username'");
					$row = mysqli_fetch_assoc($currentUser);
					$iduser = $row['iduser'];
					if ($rowUserHasTeam['iduser'] == $iduser){
						$teamid = $rowUserHasTeam['idteam'];
						$result = mysqli_query($link, "SELECT team_name FROM team WHERE idteam = '$teamid'");
						$rowTeamName = mysqli_fetch_assoc($result);
						echo '<h1 align = "center"><a href = "">' . $rowTeamName['team_name'] . '</a></h1>';
						$teamTable = "SELECT iduser, idteam FROM user_has_team WHERE idteam = $teamid"; 
						if ($resultTeam = $link->query($teamTable)) {
							while ($rowTeamMember = $resultTeam->fetch_assoc()) {
									$teamMember = $rowTeamMember['iduser'];
									$currentTeamMember = mysqli_query($link, "SELECT username FROM user WHERE iduser = $teamMember");
									$rowTeamMember = mysqli_fetch_assoc($currentTeamMember);
									$teamMemberName = $rowTeamMember['username'];
									echo '<tr> 
										<td><a href = "">'.$teamMemberName.'</a></td> 
									</tr>';
							}
						}
						echo "<br><a id=\"teamdisband\" title=\"Disband Team\"
								href=\"#\" onclick=\"disbandTeam();return false;\">Disband Team</a>";
					}
					else {
						echo 'Not registered in a team, please find a team <a href="..\loggedteams.php" style= "text-decoration: none; color: black; font-weight: bold;">here</a>.';
					}
				}
			}
			?>
        </table>
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
	<script>
		function disbandTeam() {
			window.location.href = 'disbandTeam.php';
		}
	</script>
</body>
</html>
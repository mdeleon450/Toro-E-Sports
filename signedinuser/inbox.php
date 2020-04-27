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
    <title>	Inbox</title>
</head>
<body>
    <aside>
        <figure>
            <div id = "avatar"></div>
            <figcaption><?php echo $_SESSION["username"]?></figcaption>
        </figure>
        <img class = "imenu" src = "images/menu.svg">
        <img src = "images/toro.jpeg">
        <nav>
            <div id="mtabs">
                <ul>
					<li><a href="..\index.php">Home</a></li>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="myteam.php">My Team</a></li>
                    <li><a href="myladders.php">My Ladders</a></li>
                    <li><a href="inbox.php">Inbox</a></li>
                </ul>
            </div>
        </nav>
    </aside>
    <main>
        <h1 id = "mainContent">
            Messages
        </h1><br>
        <input type="submit" class="button" value="Compose">
        <div class = "hiddenLayer"><br>
            <table>
                <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                <?php
                    $id = $_SESSION["id"];
                    $table = "SELECT * FROM messages WHERE player_iduser= $id";
                    if($result = $link->query($table)){
                        while($row = $result->fetch_assoc()){
                            $from = $row["player_iduser1"];
                            $subject = $row["subject"];
                            $message = $row["message"];
                            $date = $row["receive_date"];
                            echo ' <tr>
                                    <td>'.$from.'</td>
                                    <td>'.$subject.'</td>
                                    <td>'.$message.'</td>
                                    <td>'.$date.'</td>
                                </tr>';
                        }
                        $link->close();
                    }
                ?>
            </table>
        </div>
    </main>
    <script>
        (function() {
            var menu = document.querySelector('ul'),
            menulink = document.querySelector('img');

            menulink.addEventListener('click',function(e) {
                menu.classList.toggle('active');
                e.preventDefault();
            });
        })();
        
        (function(){
            var compose = document.querySelector('')
        })
    </script>
</body>
</html>
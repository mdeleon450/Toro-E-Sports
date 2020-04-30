<?php

// Include config file
require "../config.php";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
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
            <img class = "toro" src = "images/toro.jpeg">
            <figcaption><?php echo $_SESSION["username"]?></figcaption>
        </figure>
        <img class = "imenu" src = "images/menu.svg">
        <nav>
            <div id="mtabs">
                <ul>
					<li><a href="../index.php">Home</a></li>
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
            Messages
        </h1><br>
        <a href="#" style="text-decoration: none;" class="button" id="button">Compose</a>
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
                    $table = "SELECT * FROM messages WHERE to_iduser1= $id ORDER BY receive_date DESC";
                    if($result = $link->query($table)){
                        while($row = $result->fetch_assoc()){
							$fromID = $row["from_iduser"];
							$userSendingTo = mysqli_query($link, "SELECT username FROM user WHERE iduser = '$fromID' LIMIT 1");
							$row1 = mysqli_fetch_assoc($userSendingTo);
							$from = $row1["username"];
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
                    }
                ?>
            </table>
        </div>
        
           <div class = "popup">
               <div class = "popup-content">
                        <img src = "images/close.png" class = "close">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
                            <input class = "sendinfo" type = "text" name = "To" placeholder = "To"><br>
                            <input class = "sendinfo" type = "text" name = "Subject" placeholder = "Subject"><br>
                            <textarea class = "msgContents" type = "text" name = "Contents" placeholder = "Contents"></textarea><br>
                            <input style = "right: 1em; bottom: 1em; position: absolute;" class = "button" type = "submit" value = "Send">
                        </form>
                </div>
            </div>
			<?php 
			// Define variables
			$currentUserID = $_SESSION["id"];
			$receiver = $subject = $message = "";
			$receiver_err = $subject_err = $message_err = "";
			 
			// Form that was submitted
			if($_SERVER["REQUEST_METHOD"] == "POST"){
			 
				// Check if receiver is empty
				if(empty(trim($_POST["To"]))){
					$receiver_err = "Please enter who to send.";
				} else{
					$receiver = trim($_POST["To"]);
				}
				
				// Check if receiver is empty
				if(empty(trim($_POST["Subject"]))){
					$subject_err = "Please enter a subject.";
				} else{
					$subject = trim($_POST["Subject"]);
				}
				
				// Check if message is empty
				if(empty(trim($_POST["Contents"]))){
					$message_err = "Please your message.";
				} else{
					$message = trim($_POST["Contents"]);
				}
				
				$sendTo = $receiver;
			
				$userSendingTo = mysqli_query($link, "SELECT iduser FROM user WHERE username = '$sendTo' LIMIT 1");
				$row = mysqli_fetch_assoc($userSendingTo);
				$receiver = $row["iduser"];
				
				// Validate 
				if(empty($receiver_err) && empty($subject_err) && empty($message_err)){
					// Prepare an insert statement
					$sql = "INSERT INTO messages (from_iduser, to_iduser1, subject, message) VALUES (?, ?, ?, ?)";
					 
					if($stmt = mysqli_prepare($link, $sql)){
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt, "iiss", $param_from, $param_to, $param_subject, $param_message);
						// Set parameters
						$param_from = $currentUserID;
						$param_to = $receiver;
						$param_subject = $subject;
						$param_message = $message;
						
						// Attempt to execute the prepared statement
						if(mysqli_stmt_execute($stmt)){
							// Redirect to login page
							header("location: inbox.php");
						} else{
							echo "Something went wrong. Please try again later.";
						}

						// Close statement
						mysqli_stmt_close($stmt);
					}
				}
				
				// Close connection
				mysqli_close($link);
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
        document.getElementById("button").addEventListener("click",function(){
           document.querySelector(".popup").style.display = "flex";
        })
        document.querySelector(".close").addEventListener("click", function(){
           document.querySelector(".popup").style.display = "none";
       })
    </script>
</body>
</html>
<?php

// Include config file
require_once "config.php";

// Initialize the session
session_start();

$title = $author = $contents = "";
 
// Form that was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST['title']) || empty($_POST['author']) || empty($_POST['contents']) ){
        echo "Please enter the neccessary data";
    }
    else{
		
        $title = $_POST['title'];
        $author = $_POST['author'];
        $contents =  nl2br(htmlentities($_POST['contents'], ENT_QUOTES, 'UTF-8'));
        $sql = "INSERT INTO news (title, author, contents) VALUES (?, ?, ?)";
		
		if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_title, $param_author, $param_contents);
            
            // Set parameters
            $param_title = $title;
            $param_author = $author; 
			$param_contents = $contents;
            echo 'test';
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
 mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/main.css">
    <title>Add News</title>
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
                    <li><a href = "teams.php">Teams</a></li>
                    <?php 	// Check if the user is already logged in
								if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
									echo "<li><a href = 'signedinuser\profile.php'>Profile</a></li>";
									echo "<li><a href = 'signout.php'>Sign Out</a></li>";
								}
								else echo "<li><a href = 'signin.php'>Sign In</a></li>";
					?>
                </ul>
            </div>
        </nav>
        <img class = "esport" src= "images/esportstoro.png" style="max-width:100%;height:auto;">
    </div>
    
	<div class = "content">
	    <div class = "hiddenLayer">
	    <div class = "form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
			
                <label>   &nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Title:</label><br>
                <input type="text" name="title" ><br>
				
                <label>Author:</label><br>	
                <input type ="text" name="author" ><br>
				
                <label>Contents:</label><br>
				<textarea rows="20" cols="100" type="text" name="contents" ></textarea><br>
				
				<div class = "form">
					<input type="submit" class="button" value="Submit">
				</div>
            </form>
        </div>
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
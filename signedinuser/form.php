<?php
include_once('processForm.php');
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Image Preview and Upload PHP</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-4 offset-md-4 form-div">
        <form action="form.php" method="post" enctype="multipart/form-data">
          <h2 class="text-center mb-3 mt-3" style="color:white">Update profile</h2>
          <?php if (!empty($msg)): ?>
            <div class="alert <?php echo $msg_class ?>" role="alert">
              <?php echo $msg; ?>
            </div>
          <?php endif; ?>
		  
		  
          <div class="form-group text-center" style="position: relative;" >
            <span class="img-div">
              <div class="text-center img-placeholder"  onClick="triggerClick()">
                <h4>Update image</h4>
              </div>
			  <?php
                $userid = $_SESSION['id'];
                $table = "SELECT image_dir FROM user_image JOIN user USING (iduser) WHERE iduser = '$userid'";
                if($result = $link->query($table)){
                    $row = $result->fetch_assoc();
                    $imagelocation = "userpics/".$row['image_dir'];
                    echo '<img src="'.$imagelocation.'" onClick="triggerClick()" id="profileDisplay">';
                }
                ?>
              
            </span>
            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
            <label style="color:white">Profile Image</label>
          </div>
		  
		  
          <div class="form-group">
            <label style="color:white">Bio</label>
            <textarea name="bio" class="form-control"></textarea>
          </div>
          <div class="form-group" align = "center">
            <button type="submit" name="save_profile" class="button">Save User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<script src="scripts.js"></script>
<?php
require_once('helpers.php');
include('html_templates.php');
start_page_side_bar();
if(!isset($_SESSION['user_id'])){

  ?>
<script>
window.location.replace("index.php");
</script>

<?php
}
$user_id = (int) $_SESSION['user_id'];
$user_details = db_fetch_assoc($conn, "SELECT * FROM user WHERE user_id=?", "i", [$user_id]);
?>

<div class="accountcontainer">
  <h2>Account Details</h2><br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']  ?> ">
  <?php echo csrf_input(); ?>
  <span>Username </span><br><input class="accountinputs" type="text" name="username" value="<?php echo h($user_details['username'])  ?> "><br>
  <span>New Password </span><br><input class="accountinputs" type="password" name="password" value=""><br>
  <span>Confirm Password </span><br><input class="accountinputs" type="password" name="password2" value=""><br>
  <span>Address </span><br> <input  class="accountinputs" type="text" name="address" value="<?php echo h($user_details['address'])  ?> "><br>
  <span>Phone Number </span><br><input class="accountinputs" type="text" name="phonenumber" value="<?php echo h($user_details['phone_number'] ?? '')  ?> "><br>
  <input type="submit" class="savebutton" name="save" value="Save"><br>
  </form>
  <form action="<?php echo $_SERVER['PHP_SELF']  ?> " method="post" enctype="multipart/form-data">
    <?php echo csrf_input(); ?>
    Select Logo to upload:
    <input type="file" name="fileToUpload" style="width: 100%;" class="accountinputs" required id="fileToUpload">
    <input type="text" name="logo_name" id="logo_name" class="accountinputs" required placeholder="LOGO Name">
    <input type="submit" value="Upload Logo" style="width: 100%" name="submit_image">
  </form>
  <a href="adduser.php" class="newuser">Add New Account</a>
</div>



<?php
if(isset($_POST['save'])){
if(!verify_csrf($_POST)){
  echo 'Invalid request';
  end_page_side_bar();
  exit;
}
$username=request_value($_POST, 'username');
$password=request_value($_POST, 'password');
$password2=request_value($_POST, 'password2');
$address=request_value($_POST, 'address');
$phone__number=request_value($_POST, 'phonenumber');
if($password==""){
  db_execute($conn, "UPDATE user SET username=?, address=?, phone_number=? WHERE user_id=?", "sssi", [$username, $address, $phone__number, $user_id]);
?>

<script> 
location.replace("accountdetails.php"); 
</script>
<?php 
}
else {
  if($password!=$password2){
    echo 'Invalid input, passwords are not identical !';
  }
  else{
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    db_execute($conn, "UPDATE user SET username=?, password=?, address=?, phone_number=? WHERE user_id=?", "ssssi", [$username, $password_hash, $address, $phone__number, $user_id]);

  ?>
  
<script> 
location.replace("logout.php"); 
</script>
  <?php
  }

}

}



if(isset($_POST["submit_image"])){
  if(!verify_csrf($_POST)){
    echo 'Invalid request';
    end_page_side_bar();
    exit;
  }
  $logo_name=request_value($_POST, 'logo_name');
  $final_dir="";
  $target_dir = "images/logos/";
  if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
  }
  $safe_name = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES["fileToUpload"]["name"]));
  $target_file = $target_dir . $safe_name;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }
  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file ". h($safe_name). " has been uploaded.";
          $final_dir="images/logos/" .$safe_name;
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
  if ($final_dir !== '') {
    db_execute($conn, "INSERT INTO logo VALUES (NULL, ?, ?)", "ss", [$logo_name, $final_dir]);
  }
  }
  
end_page_side_bar();
 ?> 

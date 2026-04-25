<?php
include('connection.php');
include('html_templates.php');
start_page_side_bar();
if(!isset($_SESSION['user_id'])){

  ?>
<script>
window.location.replace("index.php");
</script>
<?php
}
?>

<div class="accountcontainer">
  <h2>Add New Account</h2><br>
  <form method="post" action="<?PHP echo $_SERVER['PHP_SELF']?>">
  <span>Username </span><br><input class="accountinputs" type="text" name="username" required value=""><br>
  <span>New Password </span><br><input class="accountinputs" type="password" name="password" required value=""><br>
  <span>Confirm Password </span><br><input class="accountinputs" type="password" name="password1" required value=""><br>
  <span>Address </span><br><input  class="accountinputs" type="text" name="address" required value=""><br>
  <span>Phone Number </span><br><input class="accountinputs" type="number" name="phonenumber" required value=""><br>
    <span>Type of User</span><br><select class="userselection" name="typeofuser">
      <option value="0">Admin</option>
      <option value="1">Employee</option>
    </select><br>
  <input type="submit" class="savebutton" name="save" value="Save"><br>
  </form>

</div>


<?php
if(isset($_POST['save'])){
  $username=request_value($_POST, 'username');
  $password=request_value($_POST, 'password');
  $password1=request_value($_POST, 'password1');
  $address=request_value($_POST, 'address');
  $phone__number=request_value($_POST, 'phonenumber');
  $role_id=request_int($_POST, 'typeofuser');
  if($password==""){
    echo 'Please Enter A password for the new user';
  }
  elseif($password!=$password1){
    echo 'The passwords should be identical';

  }
  else {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    db_execute($conn, "INSERT INTO user VALUES (NULL,?,?,?,?,?)", "ssssi", [$username, $password_hash, $address, $phone__number, $role_id]);
    $last_id = $conn->insert_id;
    db_execute($conn, "INSERT INTO purchase_cart VALUES (NULL, ?)", "i", [$last_id]);
    db_execute($conn, "INSERT INTO sell_cart VALUES (NULL, ?)", "i", [$last_id]);
    echo 'New User Added Successfully';
  }
}


end_page_side_bar();
?>

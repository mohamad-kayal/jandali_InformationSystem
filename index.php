<!DOCTYPE html>
<html lang="en">
<?php 
require_once('functions.php');
check_login();

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/login.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <title>Login Page</title>
</head>

<body>
    <img src="Images/shapes.svg" class="shapes" alt="Shapes">
    <div class="container">
        <h1>Login to Continue</h1>
        <h2>Welcome Back! Login to access your account.</h2>
        <form method="post" action="index.php">
        <?php echo csrf_input(); ?>
            
        <input class="username" type="text" placeholder="Username" name="username">
        <input class="password" type="password" placeholder="Password" name="password">
        <br><br>
                <input type="submit" name="login" value="Sign in" class="signinbutton">

<!--         <button class="signinbutton" type="submit" name="submit">Sign In</button>
 -->        </form>
    </div>
    <div>
        <img src="Images/Shape5.svg" class="shape2" alt="Shape 2">
    </div>
</body>

</html>

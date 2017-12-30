<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>hmdb Login</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login to hmdb</h1>
      <form action="login.php" method="post">
        <p><input type="text" name="username" value="" placeholder="Username"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <?php
        if (isset($_GET['login'])){
          echo "username or password is incorrect\n";     
          echo "<br/>";
             }
        ?>
         
        <p class="submit"><input type="submit" name="Login" value="Login"></p>
      </form>
    </div>
    <div class="login-help">
      <p>Forgot your password? <a href="forgot_password.php">Click here to reset it</a>.</p>
      <form action="signup.php" method="post">
      <p id="yolo" class="signup"><input type="submit" name="Login" value="Or Sign Up now">
      </p>
      </form>
</html>

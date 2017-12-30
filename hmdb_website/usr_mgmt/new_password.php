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
      <h1>CHANGE PASSWORD</h1>

      <?php if (isset($_POST['pass_success'])){
        ?>
        <form action="loginpage.php" method="post">

        <label>Password Reset Successfully!</label>
        <p class="submit"><input type="submit" name="Login" value="Return to Login"></p>
        </form>
        
        <?php exit; }



       if (!isset($_POST["new_pass"])){
      	?>

      <form action="new_password.php" method="post">
      	
      	<label>
      	  		Change Password For User <?php echo $_POST['username']; ?>
      	</label>
      	
        <p><input type="password" name="new_pass" value="" placeholder="New Password"></p>
        <p><input type="password" name="verify_new_pass" value="" placeholder="Verify New Password"></p>  
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?> " >
        
        <?php if (isset($_POST['password_mismatch'])){
          ?>
          <label><?php echo $_POST['password_mismatch'];?></label> 
          <?php } ?>

        <p class="submit"><input type="submit" name="Login" value="Submit"></p>
      </form>
   <?php }

   else {

  $new_password= $_POST['new_pass'];
  
  $lusername=$_POST['username'];
  $verify_new_password=$_POST['verify_new_pass'];

  if ($verify_new_password == $new_password){



  include_once 'conn_DB.php';

  $hashedpass=password_hash($new_password, PASSWORD_DEFAULT);

    	$query4 = "UPDATE users SET password='$hashedpass' WHERE username='$lusername'";
        $security_passed= mysql_query($query4);

      if ($security_passed) {
        ?>
        <form action="new_password.php" method="post" id="success">
        <input type="hidden" name="pass_success" value="<?php echo $lusername; ?>">
        </form>

         <script type="text/javascript">
        document.getElementById('success').submit();
        </script>
      <?php }

      
      else{
        echo "Failed to Alter Password. Try Again Later!";
      }   
}
else {

?>
<form action="new_password.php"  method="post" id="pass_mis">
        <input type="hidden" name="password_mismatch" value="<?php echo "Password Mismatch. Try Again!"; ?>"> 
        <input type="hidden" name="username" value="<?php echo $lusername; ?>">
        </form>

        <script type="text/javascript">
        document.getElementById('pass_mis').submit();
        </script>
  <?php }
  } ?>


  </section>
 </body>
</html>

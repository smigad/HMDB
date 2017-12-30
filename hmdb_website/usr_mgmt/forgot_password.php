<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>FORGOT PASSWORD?</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<!-- <pre>
<?php 
print_r($_POST);
?> -->
<body>
  <section class="container">
    <div class="login">
      <h1>Password Reset</h1>
      <form action="reset_password.php" method="post">
      	<?php
        if (isset($_POST['security_question'])){         
        ?>

         <label>
            <?php echo $_POST['security_question']; ?>
          </label>
          <p><input type="hidden" name="security_quest" value="<?php echo $_POST['security_question']; ?>">

          <p><input type="text" name="answer" value="" placeholder="ANSWER"></p>
         	
         <?php
        	if (isset($_POST['wrong_answer'])){         
        	?>
          <label>
          	 <?php echo $_POST['wrong_answer']; ?>
          </label>
          
          <?php } ?>

          <p><input type="hidden" name="lusername" value="<?php echo $_POST['lusername']; ?>">
          <p class="submit"><input type="submit" name="" value="Submit"></p>

          <?php } 

          else{
          ?>

        <p><input type="text" name="username" value="" placeholder="INSERT USERNAME"></p>
        <?php
        if (isset($_POST['invalid_user'])){         
        ?>
         <label>
            <?php echo $_POST['invalid_user']; ?>
          </label>
          <?php } ?>
          
        <p class="submit"><input type="submit" name="" value="Reset Password"></p>

        <?php } 
        ?>

      </form>
    </div>
      </section>
 </body>
</html>

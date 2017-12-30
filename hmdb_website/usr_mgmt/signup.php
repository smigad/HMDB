<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Sign Up to hmdb</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Sign Up </h1>

      <?php if (isset($_POST['success'])) {  ?>

        <form action="loginpage.php" method="post">

        <label><?php echo $_POST['success']; ?></label>
        <p class="submit"><input type="submit" name="Login" value="Return to Login"></p>
        </form>
        <?php exit; }


      if (!isset($_POST['submit'])){ ?>

      <form action="signup.php" method="post">
        <form >
        <p>Username: <input type="text" name="username" required></p>
        <p>Password: <input type="password" name="password" required> </p>
        <p>Verify Password: <input type="password" name="verify_password" required> </p>
        
        <p>Gender: <select name='gender'>
          <option value="F" selected>Female</option>
          <option value="M">Male</option>
        </select> </p>

        <p>Date of Birth:<input type="date" name="date" id="datepicker"></p>
        <p>Insert your personal question for security:<textarea id="area" type="textarea" name="question" maxlength="50" required ></textarea> </p>
        <p>Answer:</p><textarea id="area" type="textarea" name="answer" maxlength="50" required></textarea>
        
        <?php if(isset($_POST['taken'])){
          ?>
          <p><label><?php echo $_POST['taken']; ?></label></p>
          <?php } ?>



        <p>
      </div>
      <div class="login-help">
       <p id="yolo" class="signup"><input type="submit" name="submit" value="Sign Up"></p>      
      </form>
      <?php }

      else {

         $lusername=isset($_POST['username']) ? $_POST['username'] : "";

         $lpassword=isset($_POST['password']) ? $_POST['password'] : "";

         $lverify_password=isset($_POST['verify_password']) ? $_POST['verify_password'] : "";

         $gender=isset($_POST['gender']) ? $_POST['gender'] : "";

         $dob=isset($_POST['date']) ? $_POST['date'] : "";

         $question=isset($_POST['question']) ? $_POST['question'] : "";

         $answer=isset($_POST['answer']) ? $_POST['answer'] : "";


          include_once 'conn_DB.php';

          $query3= "select username from users where username='$lusername'";

          $istaken= mysql_fetch_array(mysql_query($query3));

          if (!empty($istaken[0])){ 
            ?>
             <form action="signup.php" method="post" id="takenusername">
              <input type="hidden" name="taken" value="Username is already taken!">

             <script type="text/javascript">
            document.getElementById('takenusername').submit();
            </script>
          <?php exit; }
         
         else {

          if ($lverify_password == $lpassword){


          $hashedpass=password_hash($lpassword, PASSWORD_DEFAULT);
          $hasedanswer=password_hash($answer, PASSWORD_DEFAULT);

          $question = sanitize($question);
          

        
          $query2= "INSERT INTO users (username,password,gender,date_of_birth,security_question,answer) VALUES ('$lusername','$hashedpass','$gender','$dob','$question','$hasedanswer')" ;
          
          $result=mysql_query($query2);
          
            if ($result){

          ?>
            <form action="signup.php" method="post" id="success">
            <input type="hidden" name="success" value="Sign Up Successful. Welcome to hMDB!">

             <script type="text/javascript">
            document.getElementById('success').submit();
            </script>
          <?php exit; }

          else {
          echo "<p>params are </p>";
          echo "<p>user = $lusername</p>";
          echo "<p>password = $hashedpass</p>";
          echo "<p>gender = $gender</p>";
          echo "<p>dob = $dob</p>";
          echo "<p>question = $question</p>";
          echo "<p>answer = $hasedanswer</p>";
          ?>
            <form action="signup.php" method="post" id="success">
            <input type="hidden" name="success" value="Sorry, Sign Up Failed. Try Again Later!">
            </form>

             <script type="text/javascript">
            document.getElementById('success').submit();
            </script>
          <?php exit; }
        }
        
        else { ?>

        <form action="signup.php"  method="post" id="pass_mis">
        <input type="hidden" name="taken" value="Password Mismatch. Try Again!"> 
        </form>

        <script type="text/javascript">
        document.getElementById('pass_mis').submit();
        </script>

        <?php exit;}
      }




    

      } 
      ?>

</html>

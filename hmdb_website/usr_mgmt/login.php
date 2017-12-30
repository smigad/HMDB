<html>
<head>
<title> Login info </title>
</head>
<body>
<pre>
<?php

include_once 'conn_DB.php';


$lusername=isset($_POST['username']) ? $_POST['username'] : "";

$lpassword=isset($_POST['password']) ? $_POST['password'] : "";

$query5="select password from users where username='$lusername'";

$pass=mysql_fetch_row(mysql_query($query5));

if (password_verify($lpassword, $pass[0])) {

  $query2 = "select level from users where username='$lusername'";

  $level= mysql_fetch_array(mysql_query($query2));

  if ($level[0] == '0'){
    $user=urlencode($lusername);
      header("Location: user.php?level=0&user=$user");
      exit;
    }
    
elseif ($level[0]== '1') {
      $admin=urlencode($lusername);
      header("Location: user.php?level=1&user=$admin");
      exit;
    }
  
} else {
      header("Location: loginpage.php?login=0");
      exit;
    
}


?>


</pre>
</body>
</html>


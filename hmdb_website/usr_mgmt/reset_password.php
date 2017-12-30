<html>
<head>
<title> Login info </title>
</head>
<body>
<pre>

<?php

include_once 'conn_DB.php';

print_r($_POST);


$answer=isset($_POST['answer']) ? $_POST['answer'] : "";


if (!isset($_POST['answer'])) {

    $lusername=isset($_POST['username']) ? $_POST['username'] : "";
    
   
   	$query2 = "select security_question from users where username='$lusername'";

   	$security_question= mysql_fetch_array(mysql_query($query2));
        
        if (empty($security_question)){
         ?>
        <form action="forgot_password.php"  method="post" id="invalid_user">
        <input type="hidden" name="invalid_user" value="<?php echo "Username doesn't exist. Try Again!"; ?>"> 
        </form>

        <script type="text/javascript">
        document.getElementById('invalid_user').submit();
        </script>
        <?php exit; }
        
        else{

            ?>
        <form action="forgot_password.php"  method="post" id="valid_user">
        <input type="hidden" name="security_question" value="<?php echo $security_question[0]; ?>"> 
        <input type="hidden" name="lusername" value="<?php echo $lusername; ?>">
        </form>

        <script type="text/javascript">
        document.getElementById('valid_user').submit();
        </script>

        <?php exit; }

        

?>



        <input type="hidden" name="lusername" value="<?php echo $lusername; ?>">    
        <?php $wrong_answer= isset($_POST['wrong_answer']) ? $_POST['wrong_answer'] : "";?>
        <input type="hidden" name="wrong_answer"  value="<?php echo $wrong_answer; ?>"> 
</form>

<script type="text/javascript">
    document.getElementById('security_quest').submit();
</script>

<?php } 

else {
    $user=isset($_POST['lusername']) ? $_POST['lusername'] : "";

    include_once 'conn_DB.php';
        $query3 = "select answer from users where username='$user'";
        $security_answer= mysql_fetch_array(mysql_query($query3));
        echo $security_answer[0];

      if (password_verify($answer, $security_answer[0])) {
            ?>

        <form action="new_password.php"  method="post" id="right_ans">
        <input type="hidden" name="username" value="<?php echo $user; ?>">       
        </form>
        <script type="text/javascript">
    document.getElementById('right_ans').submit();
        </script>

        <?php } 

        else {
            echo "this is not working";
        ?>

        <form action="forgot_password.php"  method="post" id="wrong_ans">
        <input type="hidden" name="wrong_answer" value="<?php echo "Sorry, incorrect Answer. Try Again!"  ?>"> 
        <input type="hidden" name="lusername" value="<?php echo $user; ?>"> 
        <input type="hidden" name="security_question" value="<?php echo $_POST['security_quest']; ?>"  >
        </form>

        <script type="text/javascript">
    document.getElementById('wrong_ans').submit();
        </script>

        <?php } 

        

}

    ?>

</pre>
</body>
</html>


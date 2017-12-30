<?php
    include("conn_DB.php");
    $award_name = $_POST["award_name"];
    $agency = $_POST["agency"];
    
    $award_name = sanitize($award_name);
    $agency = sanitize($agency);
    echo "<p>award name = $award_name</p>";
    echo "<p>agency = $agency</p>";
   
    
    $query = "INSERT INTO award(award_name, agency) VALUES ('$award_name','$agency')";
    mysql_query($query);
    
    $query2 = "SELECT award_id FROM award ORDER BY award_id DESC LIMIT 1";
    $result = mysql_query($query2);
    $awardid = mysql_result($result, 0);
    echo "<p>last award_id = $awardid</p>";
    mysql_close();
    header("Location: movie_view.php");
?> 


<?php
include_once 'conn_DB.php';
 //if(isset($_POST["add_award"])){
            $awarded_person = $_POST["awarded_person"];//no sanitization needed here cuz it's from the people_awarded_id array
            $award_type = $_POST["award_type"];
            $a_day = $_POST["a_day"];
            $a_month = $_POST["a_month"];
            $a_year = $_POST["a_year"];
            $a_date = $a_year . "-" . $a_month . "-" . $a_day;
            $f_id = $_POST["filmid"];
            $award_insert = "INSERT INTO award_given(award_id, person_id, year_given, film_id) VALUES('$award_type', '$awarded_person', '$a_date', '$f_id')";
            
            echo "<p>person = $awarded_person</p>";
            echo "<p>type = $award_type</p>";
            echo "<p>date = $a_date</p>";
            echo "<p>film = $f_id</p>";
            
            
            $okay = mysql_query($award_insert);
            echo "<p>INSERTION = $okay</p>";
            mysql_close();
   //             }
                
?>

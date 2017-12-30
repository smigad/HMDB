<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add new Movie Data</title>
        <?php
        $gl_op;
        $done = false;
        $begin = true;
        $sel_month = 1;
        function mont(){
            global $sel_month;
           // $sel_month = $arg_mon;
            echo "<script type='text/javascript'>alert('afadfffffffffffff')</script>";
        } 
        ?>

        <style type="text/css">
</style>
    <link href="style/main-index.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        
        
        
        <div class="login" id="add_movie">
            <h2>Add New Movie</h2>
            <form action="insert_movie.php" method="post" enctype="multipart/form-data">
                Title: <input type="text" name="title" maxlength="30"><br>
            Studio: <input type="text" name="studio"><br>
            Genre: <input type="text" name="genre"><br>
            Running Time(minutes): <input type="number" name="running_time" min="1"><br>
            Release Date: <!input type="date" name="release_date"><br>
            Month<select name="month" id="month_selector">
                                <?php
                                $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    for($da = 1; $da <= 12; $da++){
                                        echo "<option value=\"$da\"";
                                        if($da == 1)
                                            echo " selected";
                                        $d = $da-1;
                                        echo ">$months[$d]</option>";
                                    }
                                ?>
                            </select>
                            Day<select name="day" id="day_selector">
                                <?php
                                    for($da = 1; $da < 32; $da++){
                                        echo "<option value=\"$da\"";
                                        if($da == 1)
                                            echo " selected";
                                        echo ">$da</option>";
                                    }
                                ?>
                            </select>
                            
                            Year<select name="year">
                                <?php
                                    for($da = date("Y"); $da >= 1900; $da--){
                                        echo "<option value=\"$da\"";
                                        if($da == 2016)
                                            echo " selected";
                                        echo ">$da</option>";
                                    }
                                ?>
                            </select>
                            <br>         
            
            
            Rating: <select name="rating">
                <option value="1" selected>G</option>
                <option value="2">PG</option>
                <option value="3">PG-13</option>
                <option value="4">R</option>
                <option value="5">NC-17</option>
            </select><br>
            Plot: <textarea type="text" name="plot"></textarea><br>
            Poster: <input type="file" name="poster" accept="image/*"><br>
            Trailer: <input type="text" name="trailer"><br>
            <input type="submit" value="Add Movie">
            </form>
        </div>
       

        <div class="login" id="add_person">
            <h2>Add Person</h2>
            <?php
                   
                   if(isset($_POST['search_stuff'])){
                        $found = true;
                        include_once 'conn_DB.php';
                       // include_once 'conn_DB.php';
                       // $conn = @mysql_connect($hostname, $username, $password);
                        $title = $_POST["Title"];
                        $query = "SELECT film_id, released_date FROM movie WHERE title = '$title'";
                        $result = mysql_query($query);
                        $values = [];
                        $value_ids = [];
                        $num_rows = mysql_num_rows($result);
                        //$vaal = mysql_result($result, 0);
                         echo "<p>heyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy number of rows ---  $num_rows</p>";
                        if($num_rows == 0){//not found
                            //do something
                            //unset($vaal);
                            //$vaal[0] = "Searched Movie Title Not Found";
                            $found = false;
                        }
                        else{
                            for($j = 0; $j < $num_rows; $j++){
                                $values[$j] = mysql_result($result, $j, 'released_date');
                                $values[$j] = $title . " - " . $values[$j];
                                $value_ids[$j] = mysql_result($result, $j, 'film_id');
                            }
                            // echo "<script type='text/javascript'>alert('$vaal')</script>";
                        }

                        //after searching for the movie the person has worked on is finshed
                        //proceed to displaying the form for the person info
                        if($found){
                            $begin = false;
                            ///////////////////////////////////////////////////////////////////////////
                            ?>
                            <form action="insert_person.php" method="post" enctype="multipart/form-data">
                            First Name: <input type="text" name="first" maxlength="30"><br>
                            Last Name: <input type="text" name="last" maxlength="30"><br>
                            Gender: <input type="radio" name="gender" value="F" checked>Female
                                    <input type="radio" name="gende" value="M">Male
                                    <br>
                            Date of Birth: <!br<input type="date" name="dob"><br>
                            Month<select name="month" id="month_selector">
                                <?php
                                $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    for($da = 1; $da <= 12; $da++){
                                        echo "<option value=\"$da\"";
                                        if($da == 1)
                                            echo " selected";
                                        $d = $da-1;
                                        echo ">$months[$d]</option>";
                                    }
                                ?>
                            </select>
                            Day<select name="day">
                                <?php
                                    for($da = 1; $da < 32; $da++){
                                        echo "<option value=\"$da\"";
                                        if($da == 1)
                                            echo " selected";
                                        echo ">$da</option>";
                                    }
                                ?>
                            </select>
                            
                            Year<select name="year">
                                <?php
                                    for($da = date("Y"); $da >= 1900; $da--){
                                        echo "<option value=\"$da\"";
                                        if($da == 2016)
                                            echo " selected";
                                        echo ">$da</option>";
                                    }
                                ?>
                            </select>
                            <br>
                            Country: <input type="text" name="country" maxlength="30"><br>
                            Photo: <input type="file" name="photo" accept="image/*"><br>
                            Bio: <textarea type="text" name="bio"></textarea><br>
                            Film ID: <select name="film_id">
                            <?php ///////////////////////////////////////////////////////////////////////
                                for($k = 0; $k < $num_rows; $k++){
                                    echo "<option value=\"$value_ids[$k]\" ";
                                    if($k == 0)
                                        echo " selected ";
                                    echo ">$values[$k]</option>";
                                }
                                ////////////////////////////////////////////////////////////////////////
                            ?>
                            </select><br>
                            Role in Movie: <select name="role">
                            <?php ///////////////////////////////////////////////////////////////////////
                            $get_roles = "SELECT role_id, role_name FROM role";
                            $rol_result = mysql_query($get_roles);
                            $num_of_rows = mysql_num_rows($rol_result);
                            $role_ids[0] = mysql_result($rol_result, 0, 'role_id');
                            $op_val[0] = mysql_result($rol_result, 0, 'role_name');
                           // echo "<option value=\"$op_val\" selected> $op_val</option>";

                            echo "<option value=\"$role_ids[0]\" selected>$op_val[0]</option>";
                            $i = 1;
                            while($i < $num_of_rows)
                            {
                                $tmp_op = mysql_result($rol_result, $i, 'role_name');
                                $op_val[$i] = $tmp_op;
                                $tmp_op = mysql_result($rol_result, $i, 'role_id');
                                $role_ids[$i] = $tmp_op;
                                
                                echo "<option value=\"$role_ids[$i]\">$op_val[$i]</option>";
                                //echo "<p>+++++++++++ $tmp_op -- $op_val[$i] ***** $i </p>";
                                $i = $i + 1;
                            }/////////////////////////////////////////////////////////////////////////////
                            ?>
                            </select><br>
                            ifQuote: <input type="checkbox" name="chk_quote"><br>
                            ifAward: <input type="checkbox" name="chk_award"><br>
                            Quote: <input type="text" name="quote"><br>
                            Award: <select name="award">
                            <?php /////////////////////////////////////////////////////////////////////
                                $get_awards = "SELECT * FROM award";
                                $award_result = mysql_query($get_awards);
                                $num_award_rows = mysql_num_rows($award_result);
                                for($i = 0; $i < $num_award_rows; $i++)
                                {
                                    $tmp_op = mysql_result($award_result, $i, "award_name");
                                    $awards_val[$i] = $tmp_op;
                                    $tmp_op = mysql_result($award_result, $i, "award_id");
                                    $award_ids[$i] = $tmp_op;
                                    $tmp_op = mysql_result($award_result, $i, "agency");
                                    $award_agency[$i] = $tmp_op;
                                    
                                    echo "<option value=\"$award_ids[$i]\"";
                                            if($i == 0)
                                                    echo " selected";
                                    $award_and_agency = $awards_val[$i] . " - " . $award_agency[$i];
                                    echo ">$award_and_agency</option>";
                                }
                                /////////////////////////////////////////////////////////////////////////
                            ?>
                            </select><br>
                            Award Given Date: <br>
                            Month<select name="a_month" id="month_selector">
                                <?php
                                $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    for($da = 1; $da <= 12; $da++){
                                        echo "<option value=\"$da\"";
                                        if($da == 1)
                                            echo " selected";
                                        $d = $da-1;
                                        echo ">$months[$d]</option>";
                                    }
                                ?>
                            </select>
                            Day<select name="a_day">
                                <?php
                                    for($da = 1; $da < 32; $da++){
                                        echo "<option value=\"$da\"";
                                        if($da == 1)
                                            echo " selected";
                                        echo ">$da</option>";
                                    }
                                ?>
                            </select>
                            
                            Year<select name="a_year">
                                <?php
                                    for($da = date("Y"); $da >= 1900; $da--){
                                        echo "<option value=\"$da\"";
                                        if($da == 2016)
                                            echo " selected";
                                        echo ">$da</option>";
                                    }
                                ?>
                            </select>
                            <br>
                            <input type="Submit" value="Add Person">
                            </form>
                   <?php ////////////////////////////////////////////////////////////////////////////////
                        }
                        else{
                        
                            echo "<p style=\"color:red\"><b>YOUR SEARCH RETURNED NO RESULTS</b></p>";
                            echo "<p style=\"color:red\"><b>TRY AGAIN</b></p>";
                        }


                        mysql_close();
                    } 
                    /////////to////////////////////////////////////////////////////////////////////////
                    if($begin){
                    ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <p>Search for Movie the Person Worked on</p><br>
                Title: <input type="search" name="Title"><br>
                <input type="submit" name="search_stuff" value="Search"><br>
            </form>
            <?php
                }
            ?>

        </div>
        
        
        <div class="award_form" id="add_award">
            <h2>Add Award</h2>
            
            <form action="insert_award.php" method="post">
                Award Name: <input type="text" name="award_name"><br>
                Agency: <input type="text" name="agency"><br>
                <input type="submit" value="Add Award">
            </form>
        </div>
                
 

    </body>
</html>

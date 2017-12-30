<html>
    <head id="head">
        <?php
            
        ?>
    </head>    
    <body id="body">
        <div id="add_award">
            <h1>Add Award</h1>
            <p>To add an award a person won on a certain movie, please first search for the movie by Title
                then select the Actor from the drop down list</p><br>
            <form action="award.php" method="post">
                Title: <input type="search" name="title"><br>
                <input type="submit" value="Search Movie" name="movie_search"><br>
            </form>
            
            <?php
            include_once 'conn_DB.php';
                    
                $mv_found = false;
                if(isset($_POST["movie_search"])){
                    $title = $_POST["title"];
                    $title = sanitize($title);
                    /*
                     * can use this query instead...
                     * ......................................................
                     * SELECT first_name FROM people WHERE person_id IN (
                       SELECT person_id FROM works_on WHERE film_id IN (
                       SELECT film_id FROM movie WHERE title='aedf'));
                     * ......................................................
                     * using the above only the title is necessary to find the list of people who wortked
                     */
                    $movie_id_query = "SELECT film_id FROM movie WHERE title='$title'";
                    $r = mysql_query($movie_id_query);
                    $f_id = mysql_result($r, 0);//get the movie id
                    $peopleinmovie_search_query = "SELECT person_id, first_name, last_name, Date_of_birth FROM people WHERE person_id IN (
                       SELECT person_id FROM works_on WHERE film_id IN (
                       SELECT film_id FROM movie WHERE title='$title'))";
                    $res = mysql_query($peopleinmovie_search_query);
                    $num_rows = mysql_num_rows($res);
                    $people_inmovie = [];
                    $people_inmovie_id = [];
                    echo "<p>NUMBER OF ROWS = $num_rows</p>";
                    if($num_rows == 0){
                        echo "<p style=\"color:red\"><b>THE TITLE YOU SEARCHED FOR RETURNED NO RESULTS</p>";
                        $mv_found  = false;
                    }
                    else{
                        for($i = 0; $i <$num_rows; $i++){
                        $people_inmovie[$i] = mysql_result($res, $i, 'first_name') . " " . mysql_result($res, $i, 'last_name');
                        $people_inmovie_id[$i] = mysql_result($res, $i, 'person_id');
                        echo "<p>Name = $people_inmovie[$i]</p>";
                        $mv_found = true;
                        }
                    }
                }
                
                if($mv_found){
                ?>
                <br><form action="award-add.php" method="post" name="add_award">
                    film: <input name="filmid" type="hidden" value="<?php echo "$f_id";  ?>"><br>
                    Name: <select name="awarded_person">
                        <?php
                            for($i = 0; $i < $num_rows; $i++){
                                echo "<option value=\"$people_inmovie_id[$i]\"";
                                if($i == 0)
                                    echo " selected";
                                echo ">$people_inmovie[$i]</option>";
                            }
                        ?>
                    </select><br>

                    Award: <select name="award_type">
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
                    <input type="Submit" value="Add Award">
            </form>
            <?php
            }
            mysql_close();
            ?>
            
        </div>
    </body>
</html>

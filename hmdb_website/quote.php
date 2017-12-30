<html>
    <head id="head">
        <?php
            
        ?>
    </head>    
    <body id="body">
        <div id="add_award">
            <h1>Add Quote</h1>
            <p>To add a quote a person said on a certain movie, please first search for the movie by Title
                then select the Actor from the drop down list</p><br>
            <form action="quote.php" method="post">
                Title: <input type="search" name="title"><br>
                <input type="submit" value="Search Movie" name="movie_search"><br>
            </form>
            
            <?php
            include_once 'conn_DB.php';
                    
                $mv_found = false;
                if(isset($_POST["movie_search"])){
                    $title = $_POST["title"];
                    $title = sanitize($title);
                    
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
                <br><form action="quote-add.php" method="post" name="add_quote">
                    Film ID: <input name="filmid" type="text" value="<?php echo "$f_id";  ?>" readonly><br>
                    Name: <select name="quoted_person">
                        <?php
                            for($i = 0; $i < $num_rows; $i++){
                                echo "<option value=\"$people_inmovie_id[$i]\"";
                                if($i == 0)
                                    echo " selected";
                                echo ">$people_inmovie[$i]</option>";
                            }
                        ?>
                    </select><br>
                    Quote: <input type="text" name="quote" ><br>
                    <input type="Submit" value="Add Quote">
            </form>
            <?php
            }
            mysql_close();
            ?>
            
        </div>
    </body>
</html>

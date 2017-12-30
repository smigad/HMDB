<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include 'conn_DB.php';
            $found = false;
            $titles = [];
            $mv_ids = [];
            $mv_dates = [];
            if(isset($_POST["search_title"])){
                
                $title = sanitize($_POST["title"]);
                $Utitle = ucfirst($title);
                $mv_search_query = "SELECT film_id, title, released_date FROM movie WHERE title = '$title' OR title = '$Utitle'";
                $result = mysql_query($mv_search_query);
                $num_rows = mysql_num_rows($result);
                if($num_rows == 0){//not found
                    $found = false;
                }
                else{
                    $found = true;
                    for($i = 0; $i < $num_rows; $i++){
                        $titles[$i] = mysql_result($result, $i, 'film_id');
                        $mv_ids[$i] = mysql_result($result, $i, 'fitle');
                        $mv_dates[$i] = mysql_result($result, $i, 'released_date');
                    }
                }
            }
        ?>
        <form action="update_info.php" method="post">
            Title: <input type="text" name="title"><br>
            <input type="search" name="search_title" value="Search Movie"><br>
        </form>
    </body>
</html>

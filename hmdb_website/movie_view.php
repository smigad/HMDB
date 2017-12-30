<!DOCTYPE html>
<!--
HMDB - Habesha Movie Database

movie_view.php
    this page is responsible for the movie view which
    shows the movie posters in
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="style/prod-index.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style/movies-style.css">
        <link rel="stylesheet" href="style/popup.css">
        <style type="text/css">.tk-minion-pro{font-family:"minion-pro-1","minion-pro-2",sans-serif;}
        </style>
        
    <style type="text/css">

    </style>
                
    </head>
    <body>
        <header id="top">
    <?php
        $usr_id = 0;
        $usr_name = "";
        $level = 0;
        if(isset($_COOKIE["user"]) || isset($_COOKIE["admin"])){
            $usr_name = isset($_COOKIE["user"]) ? $_COOKIE["user"] : $_COOKIE["admin"];
            $usr_level = isset($_COOKIE["user"]) ? 0 : 1;
            $u_init = strtoupper($usr_name[0]);
            //<div style=\"background-color: red; color: white; font-size:18px;\">$u_init</div>
            echo "<a href=\"usr_mgmt/logout.php?user=$usr_name&level=$usr_level\" style=\"float: right; font-size:14px;\">$usr_name (logout)</a>";      
        }
        else{
    ?>
            <a href="usr_mgmt/index.php?current_page=movie_view.php"><button class="loginbtn" style="font-size: 12px; align-content: center">Login</button></a>
    <?php
        }
    ?>
    <h1>HMDB</h1>

    <h5 style="text-align: center">The Habesha Movie Database</h5>

    	<nav id="mainNav">
      		<ul class="centered">
                <li><a href="index.php">Home</a></li>
                <li><a href="#" class="thispage">Movies</a></li>
                <li><a href="actors_view.php">Actors</a></li>
                <li><a href="directors_view.php">Directors</a></li>
                <?php 
                    if(isset($_COOKIE["admin"])){
                        echo "<li><a href=\"admin.php\" style=\"color:red\">Admin</a></li>";
                    }
                ?>
                <li><a href="about.php">About</a></li>
      		</ul>
   	  </nav>
	
</header>

        <div id="thumbs-holder" style="display: block;"> 
            <br><br>
        <?php
            include 'conn_DB.php';
            //////////////////////////////////////////////////////////////////////
           if (isset($_COOKIE["user"])){ 
            $usr_id = $_COOKIE["user"];
            $getuserid = "SELECT user_id FROM users WHERE username = '$usr_id'";
            $usr_id_res = mysql_query($getuserid);
            $usr_id = mysql_result($usr_id_res, 0);//get user id number 
           }   
            /////////////////////////////////////////////////////////////////////

            $ids = [];
            $titles = [];
            $release_date = [];
            $film_rating = [];
            $user_rating = [];
            $studio = [];
            $poster = [];
            $plot = [];
            $movies = "";
            $has_rated = false;
//            $tmp = explode(" ", $which_order);
  //          echo "<p>-------------------------- $tmp   ---  $tmp[0] ---- $tmp[1]</p>";
            
            if(isset($_POST["submit_comment"])){
                
                $f_id = $_POST["film__id"];
                $usr_comment = sanitize($_POST["usr_comment"]);
                
                //$usr_id = $GLOBALS["USER_ID"];////////////////////////////////////////////////////////////
                /*
                    below i'm using the username from the cookie to find the user_id of the account 
                    for comment submission.
                    the result: user_id is stored on $usr_id and is used in the query to insert the 
                    new comment into the database
                */
                //////////////////////////////////////////////////////////
                    //i know this is redundant but i couldn't figure it out so whatever...
                    $chk_if_rated = "SELECT user_id, film_id, user_rating FROM users_data WHERE user_id = $usr_id AND film_id = $f_id";
                    $chk_res = mysql_query($chk_if_rated);
                    $nrow_chk = mysql_num_rows($chk_res);
                    if($nrow_chk != 0)
                        $has_rated = true;
					if(!$has_rated)
						$usr_rate = $_POST["usr_rate"];
                /////////////////////////////////////////////////////////
                $insert_for_usr = "";
                if($has_rated)//replace the query to not include user_rating if user has already rated this movie thereby nulling the value for which avg isn't calculated
                    $insert_for_usr = "INSERT INTO users_data(user_id, film_id, review) VALUES('$usr_id', '$f_id', '$usr_comment')";
                else
					$insert_for_usr = "INSERT INTO users_data(user_id, film_id, user_rating, review) VALUES('$usr_id', '$f_id', '$usr_rate', '$usr_comment')";
                
				$r_insert = mysql_query($insert_for_usr);
                echo "<p>INSERTION = $r_insert AND COND = $has_rated";
            }

            //another somethin somethin continued
                if(isset($_GET["delete_movie"])){
                    $delete_movie = $_GET["delete_movie"];
                    $delete_movie_query = "DELETE FROM movie WHERE film_id = $delete_movie";
                    $resd = mysql_query($delete_movie_query);
                    echo "<p>DELETEION OF MOVIE = $resd</p>";
                }
            
            if(isset($_GET["mv_info"])){
                $editing_movie  = false;
                /////////////////////////////////////////////////
                //continued from the "little somethin somethin" below
                if(isset($_GET["delete_cmnt"])){
                    $delete_cmnt = $_GET["delete_cmnt"];
                    $delete_cmnt_query = "DELETE FROM users_data WHERE user_data_id = $delete_cmnt";
                    $resd = mysql_query($delete_cmnt_query);
                    echo "<p>DELETION = $resd";
                    //abo jeles yimechish barifu yiseral!!
                }
                

                //another another somethin somethin continued
                if(isset($_GET["edit_movie"]))
                    $editing_movie = true;
                /////////////////////////////////////////////////

                $mv_info_id = $_GET["mv_info"];
                //checking if user has already rated this movie
                    $chk_if_rated = "SELECT user_id, film_id, user_rating FROM users_data WHERE user_id = $usr_id AND film_id = $mv_info_id";
                    $chk_res = mysql_query($chk_if_rated);
                    $nrow_chk = mysql_num_rows($chk_res);
                    if($nrow_chk != 0)
                        $has_rated = true;
                    echo "<p>THE USER'S RATING COND = $has_rated -- $usr_id ---- $mv_info_id</p>";



                if(isset($_POST["submit_update"])){
                    //submitting the new update
                    $updated_title = sanitize($_POST["updated_title"]);
                    $updated_genre = sanitize($_POST["updated_genre"]);
                    $updated_studio = sanitize($_POST["updated_studio"]);
                    $updated_trailer = sanitize($_POST["updated_trailer"]);
                    $updated_running_time = sanitize($_POST["updated_running_time"]);
                    $updated_plot = sanitize($_POST["updated_plot"]);

                    /*ONLY FOR DEBUGGING... SITCHERIS ATFAW
                    echo "<p>NEW TITLE = $updated_title</p>";
                    echo "<p>NEW GENRE = $updated_genre</p>";
                    echo "<p>NEW STUDIO = $updated_studio</p>";
                    echo "<p>NEW TRAILER = $updated_trailer</p>";
                    echo "<p>NEW RUNNING TIME = $updated_running_time</p>";
                    echo "<p>NEW PLOT = $updated_plot</p>";
                    echo "<p>THE MOVIE ID = $mv_info_id</p>";
                    */
                    $update_mv_query = "UPDATE movie SET title = '$updated_title', genre = '$updated_genre', studio = '$updated_studio', trailer = '$updated_trailer', running_time = '$updated_running_time', plot = '$updated_plot' WHERE film_id = $mv_info_id";
                    $ures = mysql_query($update_mv_query);
                    echo "<p>UPDATE OP ON MOVIE = $ures</p>";
                }



                if($mv_info_id != "false")
                    {
                    $cur_movie = "SELECT * FROM movie WHERE film_id = '$mv_info_id'";
                    $mv_info_result = mysql_query($cur_movie);
                    //it's only gonna be oone row cuz queried using primary key
                    $info_title = mysql_result($mv_info_result, 0, 'title');
                    $info_release_date = mysql_result($mv_info_result, 0, 'released_date');
                    $info_plot = mysql_result($mv_info_result, 0, 'plot');
                    $info_film_rating = mysql_result($mv_info_result, 0, 'film_rating');
                    $info_user_rating = mysql_result($mv_info_result, 0, 'users_rating');
                    $info_studio = mysql_result($mv_info_result, 0, 'studio');
                    $info_genre = mysql_result($mv_info_result, 0, 'genre');
                    $info_trailer = mysql_result($mv_info_result, 0, 'trailer');
                    $info_poster = mysql_result($mv_info_result, 0, 'film_poster');
                    $info_running_time = mysql_result($mv_info_result, 0, 'running_time');
                    
                    ?>
			<div id="modal-container" class="modal-container center-popup-cont open">
				<div class="shade"></div>
			  		<div style="margin-top: 151px;" class="popup-content">
			    		<div class="modal-top">
			      			<b><?php 
                                if(!$editing_movie){
                                    echo $info_title;
                                }
                                else{
                                        echo "<form method=\"post\" action=\"movie_view.php?mv_info=$mv_info_id\">";
                                        echo "<input type=\"text\" name=\"updated_title\" value=\"$info_title\">";
                                    } 
                                ?></b>
			    		</div>
                        
			    		<div class="modal-text-cont-for-js">
						<div class="popup-content-install2">
			  				<div class="popup-left-img" style="background-image: url('<?php echo $info_poster; ?>')">
                            </div>
                                                    
			  				<div class="modal-text-cont">
                                                            
                                        <?php
                                            if(isset($_COOKIE["admin"]) && !$editing_movie){//allowing the admin to edit or delete a movie
                                                echo "<a href=\"movie_view.php?delete_movie=$mv_info_id\" style=\"color: red;\">Delete</a>";
                                                echo " | ";
                                                echo "<a href=\"movie_view.php?mv_info=$mv_info_id&edit_movie=$mv_info_id\" style=\"color: blue;\">Edit</a>";
                                            }
                                        ?>
                                        
                                        <p><b>Genre:</b> <?php 
                                                                if(!$editing_movie)
                                                                    echo $info_genre;
                                                                else
                                                                    echo "<input type=\"text\" name=\"updated_genre\" value=\"$info_genre\">"; 
                                                        ?></p>
                                        <p><b>Running Time:</b> <?php 
                                                                if(!$editing_movie)    
                                                                    echo $info_running_time . " minutes";
                                                                else
                                                                    echo "<input type=\"text\" name=\"updated_running_time\" value=\"$info_running_time\">"; 
                                                                ?></p>
                                        <p><b>Studio:</b> <?php 
                                                                    if(!$editing_movie)
                                                                        echo $info_studio;
                                                                    else
                                                                        echo "<input type=\"text\" name=\"updated_studio\" value=\"$info_studio\">";  
                                                                ?></p>
                                        <p><b>Trailer:</b> <?php 
                                                                    if(!$editing_movie)
                                                                        echo "<a href=\"$info_trailer\">$info_trailer</a>"; 
                                                                    else
                                                                        echo "<input type=\"text\" name=\"updated_trailer\" value=\"$info_trailer\">"; 
                                                            ?></p>
                                          
                                        <p style="font-size:14px;font-weight:normal;margin:0 0 30px;line-height:30px;"><?php 
                                                                    if(!$editing_movie)    
                                                                        echo $info_plot; 
                                                                    else{
                                                                        echo "<textarea type=\"text\" name=\"updated_plot\">$info_plot</textarea>"; 
                                                                        echo "<input type=\"submit\" name=\"submit_update\" value=\"Submit Update\">";
                                                                        echo "</form>";
                                                                    }

                                                                    ?></p>
                   
                                            <p>User Rating: <?php echo $info_user_rating; ?>/10</p>
                                            <br>
                                            <h2>Comments</h2>
                                            <?php
                                                $get_comments = "SELECT user_data_id, username, review, user_rating FROM users, users_data WHERE users_data.film_id = $mv_info_id AND users_data.user_id = users.user_id ORDER BY users_data.user_data_id DESC LIMIT 10";
                                                $cmmnts = mysql_query($get_comments);
                                                $n_rows = mysql_num_rows($cmmnts);
                                                for($ku = 0; $ku < $n_rows; $ku++){
                                                    $tmp_d = mysql_result($cmmnts, $ku, 'username');
                                                    echo "<h4><b>$tmp_d</b></h4>";
                                                        //////////////////////////////////////////////////
                                                        //just trying out a little somethin somthin
                                                        if(isset($_COOKIE["admin"])){//allowing the admin to delete certain comments
                                                            $tmp_d = mysql_result($cmmnts, $ku, 'user_data_id');
                                                            echo "<a href=\"movie_view.php?mv_info=$mv_info_id&delete_cmnt=$tmp_d\" style=\"color: red\">(delete)</a>";
                                                        }
                                                        //////////////////////////////////////////////////
                                                    $tmp_d = mysql_result($cmmnts, $ku, 'user_rating');
                                                    if($tmp_d != '')//if rating is not null the print user's rating for this movie
                                                        echo "<rat style=\"color: green\">Rating $tmp_d/10</rat>";
                                                    $tmp_d = mysql_result($cmmnts, $ku, 'review');
                                                    echo "<p>    $tmp_d</p><br>";
                                                }
                                            ?>

                                            <div class="btn-dwn-cont">
                                                <?php
                                                if(isset($_COOKIE["user"])){
                                            ?>
                                                <p>Leave your Comment Below.</p>
                                                <form method="post" action="movie_view.php" oninput="x.value = parseFloat(usr_rate.value)">
                                                    Comment:<textarea name="usr_comment" maxlength="500"></textarea><br>
                                                    
                                                    <?php
                                                        if (!$has_rated){
                                                    ?>
                                                    Rating: <input type="range" min="0" max="10" step="0.1" name="usr_rate"><output name="x" for="usr_rate"></output><br>
                                                    <?php
                                                        }
                                                        else{
                                                            ?>
                                                                <p>You have already rated this movie.</p>
                                                            <?php
                                                        }
                                                    ?>

                                                    <input type="hidden" name="film__id" value="<?php echo $mv_info_id; ?>"><br>
                                                    <input class="btn-dwn close-modal" type="submit" name="submit_comment" value="Submit" style="font-size: 12px; align-content: center">
                                                </form>
                                               <?php
                                                    }
                                                    else{
                                                        echo "<p style=\"color: #f00\"><b>Please Login to Rate and Comment on this Movie</b></p>";
                                                    }
                                               ?> 

				  					<!span class="browser-icon browser-icon-big" style="background-image:url('/img/browser/firefox.png')"><!/span>
								</div>
							</div>
						</div>
					</div>
			   		
                                            <a href="movie_view.php"><div class="close-modal close-modal-icon"></div></a>
			   		
			   		
			   		
			 	</div>
			</div>
		
                    <?php
                }
            }
            
            
            if(isset($_GET["mv_title"])){
                //if movie title search
//                $mv_title = sanitize($tmp[1]);
                $mv_title = sanitize($_GET["mv_title"]);
                //echo "<p>////////////////////////  $mv_title</p>";
                $movies = "SELECT * FROM movie WHERE title like '%$mv_title%' ORDER BY film_id LIMIT 25";
            }
            else if(isset($_GET["genre"])){
                //order by genre
                $movies = "SELECT * FROM movie ORDER BY genre LIMIT 25";
                $genre_order = false;
            }
            else if(isset ($_GET["title"])){
                //order by title
                $movies = "SELECT * FROM movie ORDER BY title LIMIT 25";
                $title_order = false;
            }
            else if(isset($_GET["date"])){
                //order by released date
                $movies = "SELECT * FROM movie ORDER BY released_date DESC LIMIT 25";
                $date_order = false;
            }
            else if(isset ($_GET["rating"])){
                //order by rating
                $movies = "SELECT * FROM movie ORDER BY users_rating DESC LIMIT 25";
                $rating_order = false;
            }
            else{
                //just all the movies -- order by film_id
                $movies = "SELECT * FROM movie ORDER BY film_id LIMIT 25";
            }
            
            
            
            $mv_results = mysql_query($movies);
            $num_movies = mysql_num_rows($mv_results);
            if($num_movies == 0 && isset($_GET["mv_title"])){
                $mv_title = sanitize($_GET["mv_title"]);
                echo "<br><br><p style=\"color: red; font-size: 16px;\" >Search for the movie \"$mv_title\" Returned No Result";
            }
            if($num_movies == 0 && !isset($_GET["mv_title"]))
                echo "<br><br><p>There are NO movies in the database.</p>";

            for($i = 0; $i < $num_movies; $i++){
                $ids[$i] = mysql_result($mv_results, $i, 'film_id');
                $titles[$i] = mysql_result($mv_results, $i, 'title');
                $release_date[$i] = mysql_result($mv_results, $i, 'released_date');
                $user_rating[$i] = mysql_result($mv_results, $i, 'users_rating');
                $film_rating[$i] = mysql_result($mv_results, $i, 'film_rating');
                $studio[$i] = mysql_result($mv_results, $i, 'studio');
                $plot[$i] = mysql_result($mv_results, $i, 'plot');
                $n = strlen($plot[$i]);
                $tmp_str = substr($plot[$i], 0, 150);
                if($n > 150){
                    $tmp_str = $tmp_str . "...";
                }
                $plot[$i] = $tmp_str;
                //$temp_str = $plot[$i]
                $poster[$i] = mysql_result($mv_results, $i, 'film_poster');
            }
            mysql_close();
            
            for($i = 0; $i < $num_movies; $i++){//params used here are $num_movies and all the arrays
        ?>
       
        <div class="pic-thumb" >
        
        <img src="<?php echo $poster[$i]; ?>" style="display: inline;"> 
        <a href="movie_view.php?mv_info=<?php echo $ids[$i]; ?>">
            <p id="tit"><?php echo $titles[$i]; ?></p>
        <br>
        <span><?php 
            echo "<p>$studio[$i]</p>"; 
            echo "<p>$release_date[$i]</p>";
            echo "<p>$film_rating[$i]</p>";
            echo "<p>$plot[$i]</p>";
//            echo "<br><br><p><b>RATING: $user_rating[$i]/10</b></p>";
        ?>
            <br><br><p id="rat"><b>RATING: <?php echo $user_rating[$i]; ?></b></p>
        </span>
        </a> 
        </div>  
            <?php
            }
            ?>
    </div>

        
        
        <ul id="subnav" style="display: block;">
		<h4>Search for Movie
		</h4>
		<li>
                    <form action="movie_view.php" method="get">
                        <input type="search" autocomplete="" name="mv_title"><br>
                        <!input  type="button" name="mov_search" value=""><br>
                    </form>
                    <a href="movie_view.php" data-category="all" id="active-category">Order By Category 
		</a>
		</li>
		<li>
                    <a href="movie_view.php?bytitle=true" data-category="title">Title
		</a>
		</li>
		<li>
                    <a href="movie_view.php?genre=true" data-category="genre">Genre
		</a>
		</li>
		<li>
                    <a href="movie_view.php?date=true"  data-category="date">Release Date
		</a>
		</li>
		<li>
                    <a href="movie_view.php?rating=true" data-category="rating">Most Rated
		</a>
		</li>
		</ul>
		

        
        
    </body>
</html>

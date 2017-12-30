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
        <link href="style/prod-index.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style/movies-style.css">
        <link rel="stylesheet" href="style/popup.css">
       
        <style type="text/css">.tk-minion-pro{font-family:"minion-pro-1","minion-pro-2",sans-serif;}
        </style>
        

   
        

<!user.php?level=0&user=dagiopia>
                
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
                <li><a href="movie_view.php">Movies</a></li>
                <li><a href="actors_view.php">Actors</a></li>
                <li><a href="#" class="thispage">Directors</a></li>
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
        <?php
            include 'conn_DB.php';
            $director_ids = [];
            $director_names = [];
            $birth_date = [];
            $country = [];
            $gender = [];
            $photo = [];
            $bio = [];
            $mvs_wored = [];
            $directors = "";
//            $tmp = explode(" ", $which_order);
  //          echo "<p>-------------------------- $tmp   ---  $tmp[0] ---- $tmp[1]</p>";
            
            if(isset($_GET["delete_person"])){
                $delete_person = $_GET["delete_person"];
                $delete_person_query = "DELETE FROM people WHERE person_id = $delete_person";
                $dres = mysql_query($delete_person_query);
                echo "<p>DELETION OF PERSON = $dres</p>";
            }


            if(isset($_GET["person_info"])){
                $editing_director = false;
                $person_info_id = $_GET["person_info"];

                if(isset($_GET["edit_person"]))
                    $editing_director = true;

                if(isset($_POST["submit_update"])){
                        $updated_firstname = sanitize($_POST["updated_firstname"]);
                        $updated_lastname = sanitize($_POST["updated_lastname"]);
                        $updated_gender = sanitize($_POST["updated_gender"]);
                        $updated_bdate = sanitize($_POST["updated_bdate"]);
                        $updated_country = sanitize($_POST["updated_country"]);
                        $updated_bio = sanitize($_POST["updated_bio"]);

                        $update_person_query = "UPDATE people SET first_name = '$updated_firstname', last_name = '$updated_lastname', gender = '$updated_gender', Date_of_birth = '$updated_bdate', country = '$updated_country', bio = '$updated_bio' WHERE person_id = $person_info_id";
                        $ures = mysql_query($update_person_query);
                        echo "<p>UPDATE OP RESULT = $ures</p>";
                }

                if($person_info_id != "false"){
                    $cur_person = "SELECT * FROM people WHERE person_id = '$person_info_id'";
                    $person_info_result = mysql_query($cur_person);
                    //it's only gonna be oone row cuz queried using primary key
                    $info_fname = mysql_result($person_info_result, 0, 'first_name');
                    $info_lname = mysql_result($person_info_result, 0, 'last_name');
                    $info_gender = mysql_result($person_info_result, 0, 'gender');
                    $info_birthday = mysql_result($person_info_result, 0, 'Date_of_birth');
                    $info_country = mysql_result($person_info_result, 0, 'country');
                    $info_photo = mysql_result($person_info_result, 0, 'photo');
                    $info_bio = mysql_result($person_info_result, 0, 'bio');
                    //from here on out, it's data from other tables
                    $cur_person_movies = "SELECT title, role_name FROM ((movie JOIN works_on ON movie.film_id=works_on.film_id) JOIN role ON role.role_id = works_on.role_id) WHERE person_id = '$person_info_id'";
                    $person_info_movies = mysql_query($cur_person_movies);
                    //ITERATE ON NUMBER OF ROWS NOW
                    $info_mv_title = [];
                    $info_mv_role = [];
                    $n_mv_info = mysql_num_rows($person_info_movies);
                    for($o = 0; $o < $n_mv_info; $o++){
                        $info_mv_title[$o] = mysql_result($person_info_movies, $o, 'title');
                        $info_mv_role[$o] = mysql_result($person_info_movies, $o, 'role_name');
                    }



                    $cur_person_awards = "SELECT award.award_name, award.agency, award_given.year_given FROM award, award_given WHERE award.award_id = award_given.award_id AND award_given.person_id = $person_info_id";
                    $person_info_awards = mysql_query($cur_person_awards);
                    $info_award_name = [];
                    $info_award_agency = [];
                    $info_award_given_date = [];
                    $n_award_info = mysql_num_rows($person_info_awards);
                    for($o = 0; $o < $n_award_info; $o++){
                        $info_award_name[$o] = mysql_result($person_info_awards, $o, 'award_name');
                        $info_award_agency[$o] = mysql_result($person_info_awards, $o, 'agency');
                        $info_award_given_date[$o] = mysql_result($person_info_awards, $o, 'year_given');
                    }

                    $cur_person_quotes = "SELECT movie.title, movie.released_date, quote.quote FROM movie, quote WHERE movie.film_id = quote.film_id AND quote.person_id = $person_info_id";
                    $person_info_quotes = mysql_query($cur_person_quotes);
                    $info_quote_movie_title = [];
                    $info_quote_movie_release_date = [];
                    $info_quote = [];
                    $n_quotes_info = mysql_num_rows($person_info_quotes);
                    for($o = 0; $o < $n_quotes_info; $o++){
                        $info_quote[$o] = mysql_result($person_info_quotes, $o, 'quote');
                        $info_quote_movie_title[$o] = mysql_result($person_info_quotes, $o, 'title');
                        $info_quote_movie_release_date[$o] = mysql_result($person_info_quotes, $o, 'released_date');
                    }
                    

                    ?>
			<div id="modal-container" class="modal-container center-popup-cont open">
				<div class="shade"></div>
			  		<div style="margin-top: 151px;" class="popup-content">
			    		<div class="modal-top">
			      			<b><?php 
                                    if(!$editing_director)
                                        echo $info_fname . " " . $info_lname; 
                                    else{
                                        echo "<form method=\"post\" action=\"directors_view.php?person_info=$person_info_id\">";
                                        echo "<input type=\"text\" name=\"updated_firstname\" value=\"$info_fname\">";
                                        echo "<input type=\"text\" name=\"updated_lastname\" value=\"$info_lname\">";
                                    }

                                ?></b>
			    		</div>
			    		<div class="modal-text-cont-for-js">
						<div class="popup-content-install2">
			  				<div class="popup-left-img" style="background-image: url('<?php echo $info_photo; ?>')">
			  				</div>
			  				<div class="modal-text-cont">
                                
                                <?php
                                    if(isset($_COOKIE["admin"]) && !$editing_director){//allowing the admin to edit or delete a director
                                        echo "<a href=\"directors_view.php?delete_person=$person_info_id\" style=\"color: red;\">Delete</a>";
                                        echo " | ";
                                        echo "<a href=\"directors_view.php?person_info=$person_info_id&edit_person=$person_info_id\" style=\"color: blue;\">Edit</a>";
                                    }
                                ?>


                                <p><b>Gender:</b> <?php 
                                                        if(!$editing_director)
                                                            if($info_gender == "F") 
                                                                echo "Female"; 
                                                            else 
                                                                echo "Male"; 
                                                        else
                                                            echo "<input type=\"text\" name=\"updated_gender\" value=\"$info_gender\">";
                                                    ?></p>
                                <p><b>Born:</b> <?php 
                                                    if(!$editing_director)
                                                        echo $info_birthday;
                                                    else
                                                         echo "<input type=\"text\" name=\"updated_bdate\" value=\"$info_birthday\">";
                                                ?></p>
                                <p><b>Country:</b> <?php 
                                                        if(!$editing_director)
                                                            echo $info_country;
                                                        else
                                                            echo "<input type=\"text\" name=\"updated_country\" value=\"$info_country\">"; 
                                                    ?></p>
                                <p><b>Bio:</b> <?php 
                                                    if(!$editing_director)
                                                        echo $info_bio;
                                                    else{
                                                        echo "<textarea type=\"text\" name=\"updated_bio\">$info_bio</textarea>"; 
                                                        echo "<input type=\"submit\" name=\"submit_update\" value=\"Submit Update\">";
                                                        echo "</form>";
                                                    }
                                                ?></p>
                                <br><p><b>Movies Worked on:</b> 
                                    <?php
                                    for($o = 0; $o < $n_mv_info; $o++){
                                        echo "<br>";
                                        echo $info_mv_title[$o] . " (" . $info_mv_role[$o] . ")";
                                        
                                    }
                                    ?>
                                    
                                    </p>
                                   

                                <br><p><b>Awards Won:</b> 
                                    <?php
                                    if($n_award_info == 0)
                                        echo "<p>No Awards Won.</p>";

                                    for($o = 0; $o < $n_award_info; $o++){
                                        echo "<br>";
                                        echo $info_award_name[$o] . " from " . $info_award_agency[$o] . " (" . $info_award_given_date[$o] . ")";
                                        
                                    }
                                    ?>
                                    </p>

                                <br><p><b>Quotes:</b> 
                                    <?php
                                    if($n_quotes_info == 0)
                                        echo "<p>No Quotes.</p>";

                                    for($o = 0; $o < $n_quotes_info; $o++){
                                        echo "<br>";
                                        echo "\" " . $info_quote[$o] . " \" :<b>" . $info_quote_movie_title[$o] . " (" . $info_quote_movie_release_date[$o] . ")</b>";
                                        
                                    }
                                    ?>
                                    </p>


                                <!there was an h2 here>    
                                <p style="font-size:14px;font-weight:normal;margin:0 0 30px;line-height:30px;"></p>
           
                                    
                                    <div class="btn-dwn-cont">
                                     <?php ?>
				  					<span><span class="browser-icon browser-icon-big" style="background-image:url('/img/browser/firefox.png')"></span></span>
								</div>
							</div>
						</div>
					</div>
			   		
                                            <a href="directors_view.php"><div class="close-modal close-modal-icon"></div></a>
			   		
			   		
			   		
			 	</div>
			</div>
		
                    <?php
                }
            }
            
            
            if(isset($_GET["f_name"])){
                //if movie title search
//                $mv_title = sanitize($tmp[1]);
                $fname = sanitize($_GET["f_name"]);
                echo "<p>////////////////////////  $fname</p>";
                $directors = "SELECT * FROM people WHERE first_name like '%$fname%' or last_name like '%$fname%' AND person_id IN (SELECT person_id FROM works_on WHERE role_id = 1) ORDER BY person_id LIMIT 25";
            }
            else if(isset($_GET["country"])){
                //order by country
                $directors = "SELECT * FROM people WHERE person_id IN (SELECT person_id FROM works_on WHERE role_id = 1) ORDER BY country LIMIT 25";
            }
            else if(isset ($_GET["first"])){
                //order by title
                $directors = "SELECT * FROM people WHERE person_id IN (SELECT person_id FROM works_on WHERE role_id = 1) ORDER BY first_name LIMIT 25";
            }
            else if(isset($_GET["last"])){
                //order by released date
                $directors = "SELECT * FROM people WHERE person_id IN (SELECT person_id FROM works_on WHERE role_id = 1) ORDER BY last_name DESC LIMIT 25";
            }
            else if(isset ($_GET["birthday"])){
                //order by rating
                $directors = "SELECT * FROM people WHERE person_id IN (SELECT person_id FROM works_on WHERE role_id = 1) ORDER BY Date_of_birth DESC LIMIT 25";
            }
            else{
                //just all the movies -- order by film_id
                $directors = "SELECT * FROM people  WHERE person_id IN (SELECT person_id FROM works_on WHERE role_id = 1) ORDER BY person_id LIMIT 25";
            }

            
            
            $ac_results = mysql_query($directors);
            $num_directors = mysql_num_rows($ac_results);
            for($i = 0; $i < $num_directors; $i++){
                /////////////////////////////////
                $director_ids[$i] = $p_id = mysql_result($ac_results, $i, 'person_id');
                $movies_worked_on = "SELECT title FROM movie WHERE movie.film_id IN (SELECT works_on.film_id FROM works_on WHERE works_on.person_id = '$p_id' AND works_on.role_id = 1)";
                $mvs = mysql_query($movies_worked_on);
                $n_mvs = mysql_num_rows($mvs);
                $tmp_mvs = "";
                for($ii = 0; $ii < $n_mvs; $ii++){
                    $tmp_mvs = mysql_result($mvs, $ii, 0) . ", " . $tmp_mvs;
                }
                /////////////////////////////////
                $mvs_wored[$i] = $tmp_mvs;
                $tmp_name = mysql_result($ac_results, $i, 'first_name') . " " . mysql_result($ac_results, $i, 'last_name');
                
                $director_names[$i] = $tmp_name;
                //echo "<p>;;;;;;;;;;;;;;;;;;;;$tmp_name ----- $actor_names[$i]</p>";
                $birth_date[$i] = mysql_result($ac_results, $i, 'Date_of_birth');
                $country[$i] = mysql_result($ac_results, $i, 'country');
                $gender[$i] = mysql_result($ac_results, $i, 'gender');
                if($gender[$i] == 'F')
                    $gender[$i] = "Female";
                else
                    $gender[$i] = "Male";
                $bio[$i] = mysql_result($ac_results, $i, 'bio');
                $n = strlen($bio[$i]);
                $tmp_str = substr($bio[$i], 0, 150);
                if($n > 150){
                    $tmp_str = $tmp_str . "...";
                }
                $bio[$i] = $tmp_str;
                //$temp_str = $plot[$i]
                $photo[$i] = mysql_result($ac_results, $i, 'photo');
            }
            mysql_close();
            
            for($i = 0; $i < $num_directors; $i++){//params used here are $num_movies and all the arrays
        ?>
       
        <div class="pic-thumb" >
        <img src="<?php echo $photo[$i]; ?>" style="display: inline;"> 
        <a href="directors_view.php?person_info=<?php echo $director_ids[$i]; ?>" >
            <p id="tit"><?php echo $director_names[$i]; ?></p>
        <br>
        <span><?php 
            echo "<p>$gender[$i]</p><br>"; 
            echo "<p>$birth_date[$i]</p>";
           
            echo "<p>$bio[$i]</p>";
        ?>
            <br><br><p id="rat"><b><?php echo $country[$i]; ?></b></p>
            <br><p style="font-size:12px"><b><?php echo $mvs_wored[$i]; ?></b></p>
        </span>
        </a> 
        </div>  
            <?php
            }
            ?>
    </div>

        
        
        <ul id="subnav" style="display: block;">
		<h4>Search Actor
		</h4>
		<li>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="get">
                        <input type="search" autocomplete="" name="f_name"><br><br>
                    </form>
                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>" data-category="all" id="active-category">Order By Category 
		</a>
		</li>
		<li>
                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>?first=true" data-category="firstname">First Name
		</a>
		</li>
		<li>
                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>?last=true" data-category="lastname">Last Name
		</a>
		</li>
		<li>
                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>?birthday=true"  data-category="birthd">Birthday
		</a>
		</li>
		<li>
                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>?country=true" data-category="countr">Country
		</a>
		</li>
		</ul>
		

        
        
    </body>
</html>

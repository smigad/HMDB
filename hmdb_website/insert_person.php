<?php

  include("conn_DB.php");
  
    echo "<meta charset=\"utf-8\"/>";
    $first = $_POST["first"];
    $last = $_POST["last"];
    $gender = $_POST["gender"];
    $day = $_POST["day"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $country = $_POST["country"];
    $bio = $_POST["bio"];
    $role = $_POST["role"];
    $chk_quote = $_POST["chk_quote"];
    $chk_award = $_POST["chk_award"];
    $quote = $_POST["quote"];
    $award = $_POST["award"];
    $a_year = $_POST["a_year"];
    $a_month = $_POST["a_month"];
    $a_day = $_POST["a_day"];
//$award_date = $_POST["award_date"];
    $film_id = $_POST["film_id"];
    
    $award_date = $a_year . "-" . $a_month . "-" . $a_day;
    $dob = $year . "-" . $month . "-" . $day;
    $name_photo = rm_key($first) . "_" . rm_key($last) . "_" . rm_key($dob);
    
    $first = sanitize($first);
    $last = sanitize($last);
    $gender = sanitize($gender);
    $dob = sanitize($dob);
    $country = sanitize($country);
    $bio = sanitize($bio);
    $role = sanitize($role);
    $quote = sanitize($quote);
    $award = sanitize($award);
    $award_date = sanitize($award_date);
    $film_id = sanitize($film_id);

    echo "<p>launching the file upload script</p>";
    $target_dir = "people_photo/";
//    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    //uploadded file name changed to "first_last_dob_filename.extension"
    $target_file = $target_dir . $name_photo . "_" . basename($_FILES["photo"]["name"] );
    echo "<p>$target_dir ---- $target_file</p>";
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or not
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            echo "<p>File is an image - " . $check["mime"] . ".</p>";
            $uploadOk = 1;
        } else {
            echo "<p>File is not an image.</p>";
            $uploadOk = 0;
        }
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<p>Sorry, your file was not uploaded.</p>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
        } else {
            echo "<p>Sorry, there was an error uploading your file.</p>";
        }
    }

    echo "<br><br><p>afterall is said and not done... image name = $target_file";
    //set image name of the 
    
  

    ///////////////////////////////////////////////////
    //only for testing 
    //removce when done
    echo "<p>first name = $first</p>";
    echo "<p>last name = $last</p>";
    echo "<p>gender = $gender</p>";
    echo "<p>dob = $dob</p>";
    echo "<p>country = $country</p>";
    echo "<p>photo = $target_file</p>";
    echo "<p>bio = $bio</p>";
    echo "<p>film id = $film_id</p>";
    echo "<p>role = $role</p>";
    echo "<p>quote = $quote</p>";
    echo "<p>award = $award</p>";
    echo "<p>award date = $award_date</p>";
    echo "<p>value of chk_quote = $chk_quote </p>";
    echo "<p>value of chk_award = $chk_award </p>";
    
    echo "<p> before sanitization = $quote</p>";
        
    
    

    echo "<p> after sanitization = $quote</p>";
    
    $dirty_q = make_dirty($quote);
    echo "<p> after being in the dirt = $dirty_q</p>";
    
    
    
    //imma need to filter this query incase the string values
    //accepted from the form contain some attack characters
    //like aposthrophes or semicolons
    $query = "INSERT INTO people(first_name, last_name, gender, Date_of_birth, country, photo, bio) VALUES ('$first','$last','$gender','$dob','$country','$target_file','$bio')";
        
    echo "<br><p>query = $query</p>";

    mysql_query($query);
    
    
    $getlastid_query = "SELECT person_id FROM people ORDER BY person_id DESC LIMIT 1";
    $result = mysql_query($getlastid_query);
    $p_id = mysql_result($result, 0, "person_id");
       
    //inserting the person's role in a movie
    $insert_roleinmovie = "INSERT INTO works_on(person_id, film_id, role_id) VALUES('$p_id', '$film_id', '$role')";
    echo "<p>query to insert into works_on = $insert_roleinmovie</p>";
    $r = mysql_query($insert_roleinmovie);
    echo "<p>insertion into works_on = $r</p>";
    
    if($chk_quote == 'on'){//here, add the quote from the textbox into db

       echo "<p>the fucking check box is on!!!</p>";
       //////////////////////////////////////////////////////////////////////////////////////////////////<
       $name = $first . " " . $last;
       //note here that the speaker attrib is redundant because there's speaker_id and the name could 
       //easily be fetched from the people table using the id.... talk with elias ena remove it
       //////////////////////////////////////////////////////////////////////////////////////////////////>
       $add_quote_query = "INSERT INTO quote(film_id, person_id, quote) VALUES('$film_id', '$p_id', '$quote')";
       mysql_query($add_quote_query);
    }
    
    if($chk_award == 'on'){
        echo "<p>The damn award check box is on</p>";
        $add_award_query = "INSERT INTO award_given(award_id, person_id, date_given, film_id) VALUES('$award', '$p_id', '$award_date', '$film_id')";
        echo "<p>the query for the award ====== $add_award_query</p>";
        $r = mysql_query($add_award_query);
        echo "<p>inserting award data = $r";
    }
    
    

    mysql_close();

    echo "<br><br><p>the selected id is equal to = $p_id</p>";
    header("Location: actors_view.php?person_info=$p_id");
//use the id value in result to insert into award and quote

?> 
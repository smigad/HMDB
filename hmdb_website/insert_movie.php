<?php
    include("conn_DB.php");

    $title = sanitize($_POST["title"]);
    $studio = sanitize($_POST["studio"]);
    $genre = sanitize($_POST["genre"]);
    $running_time = sanitize($_POST["running_time"]);
    $day = $_POST["day"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $release_date = $year . "-" . $month . "-" . $day;
    //$release_date = sanitize($_POST["release_date"]);
    $rating = sanitize($_POST["rating"]);
    $plot = sanitize($_POST["plot"]);
    //$poster = sanitize($_POST["poster"]);
    $trailer = sanitize($_POST["trailer"]);
    $usr_rating = 0;
    
    $name_poster = rm_key($title) . "_" . rm_key($studio) . "_" . rm_key($running_time);
    
        echo "<p>launching the file upload script</p>";
    $target_dir = "movie_posters/";
//    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    //uploadded file name changed to "first_last_dob_filename.extension"
    $target_file = $target_dir . $name_poster . "_" . basename($_FILES["poster"]["name"] );
    echo "<p>$target_dir ---- image file name ========== $target_file</p>";
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or not
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["poster"]["tmp_name"]);
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
        if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["poster"]["name"]). " has been uploaded.";
        } else {
            echo "<p>Sorry, there was an error uploading your file.</p>";
        }
    }

    echo "<br><br><p>afterall is said and not done... image name = $target_file</p>";

    
    
    
    /*
    ///////////////////////////////////////////
    //only for testing
    //remove when done
    echo "<p>title = $title</p>";
    echo "<p>studio = $studio</p>";
    echo "<p>genre = $genre</p>";
    echo "<p>running time = $running_time</p>";
    echo "<p>release date = $release_date</p>";
    echo "<p>rating = $rating</p>";
    echo "<p>user rating = $usr_rating</p>";
    echo "<p>plot = $plot</p>";
    echo "<p>poster = $target_file</p>";
    echo "<p>trailer = $trailer</p>";
    //////////////////////////////////////////
    */


    
    $query = "INSERT INTO movie(title, released_date, plot, film_rating, users_rating, studio, genre, trailer, film_poster, running_time) VALUES ('$title','$release_date','$plot','$rating','$usr_rating','$studio','$genre', '$trailer', '$target_file', '$running_time')";
    $res = mysql_query($query);
    echo "<p>after executing the query -> $res</p>";
    mysql_close();
    header("Location: movie_view.php");
?> 

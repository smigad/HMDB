<?php

    include 'conn_DB.php';
    
    $film_id = $_POST["filmid"];
    $quoted_person = $_POST["quoted_person"];
    $quote = sanitize($_POST["quote"]);
    
    $insert_quote_query = "INSERT INTO quote(film_id, speaker_id, quote) VALUES('$film_id', '$quoted_person', '$quote')";
    echo "<p>FILM ID = $film_id</p>";
    echo "<p>Person = $quoted_person</p>";
    echo "<p>quote = $quote</p>";
    echo "<p>query = $insert_quote_query</p>";
    
    $r = mysql_query($insert_quote_query);
    echo "<p>INSERTION = $r</p>";
?>
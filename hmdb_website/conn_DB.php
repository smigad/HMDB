<?php

    $hostname = 'localhost';
    $username = 'root';
    $password = 'toor';

    $conn = @mysql_connect($hostname, $username, $password);
    
    if (is_resource($conn))
        {
        //echo "<p>Connected To the Database<p>"; 
        $query1 = 'USE hmdb';
        if (mysql_query($query1, $conn)) {
           // echo "<p>connected to HMDB</p>"; 
        }
        else{
                echo "<p>THERE WAS A PROBLEM CONNECTING TO THE DATABASE</p>";
        }
    }

    function sanitize($arg_1)
    {
        $res = str_replace(chr(39),"\\'", $arg_1);
        $res = str_replace(chr(34), "\\\"", $res);
        return $res;
    }
    
    function make_dirty($arg_1){
        $res = str_replace("\\'", "'", $arg_1);
        $res = str_replace("\\\"", "\"", $res);
        return $res;
    }
    
    function rm_key($arg_1){
        $res = str_replace(chr(39), "", $arg_1);
        $res = str_replace(chr(34), "", $res);
        $res = str_replace(chr(92), "", $res);
        $res = str_replace(chr(47), "", $res);
        
        return $res;
    }
?>


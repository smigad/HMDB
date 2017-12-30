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
                    <li><a href="movie_view.php">Movies</a></li>
                    <li><a href="actors_view.php">Actors</a></li>
                    <li><a href="movie_view.php">Directors</a></li>
                    <?php 
                        if(isset($_COOKIE["admin"])){
                            echo "<li><a href=\"admin.php\" style=\"color:red\">Admin</a></li>";
                        }
                    ?>
                    <li><a href="#" class="thispage">About</a></li>
          		</ul>
       	  </nav>





    </body>
    <img src="HMDB_intro.jpg" style="width: 100%; height: 100%; z-index: 0;">
</html>
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
                    <li><a href="#" class="thispage">Home</a></li>
                    <li><a href="movie_view.php">Movies</a></li>
                    <li><a href="actors_view.php">Actors</a></li>
                    <li><a href="movie_view.php">Directors</a></li>
                    <?php 
                        if(isset($_COOKIE["admin"])){
                            echo "<li><a href=\"admin.php\" style=\"color:red\">Admin</a></li>";
                        }
                    ?>
                    <li><a href="about.php">About</a></li>
          		</ul>
       	  </nav>





    </body>
    <img src="hmdb_bicha.jpg" style="width: 40%; height: 50%; margin-right: 20%; margin-left: 30%;" >
<br><br><p style="font-size: 14px; margin-right: 20%; margin-left: 20%; z-index: 0;">
Ethiopia's cinematic scene is growing. From the visualy stunning movies like Professor Haile Gerima's “Teza” to “Lamb” getting nominated for the Cannes movie festival, 
our cinematic universe has come a long way since its beginning days. This ever expanding form of art has been well supported by the growing number of cinemas and the ease of 
digital distributions. This has brought about with it a large pool of audience within society. Now, more than ever, we have an unprecedented number of people watching and buying 
Ethiopian movies. With such a growth being seen, it is very easy to get lost in deciding what to watch, how good it is and if the critical and viewer reception of a movie is that good! 
That is where Habesha Movie Database comes in.
<br><br>
Habesha Movie Database aims to create a single place where people can come to browse through movies that are already available and those that are upcoming, effectively divided into 
genres. Individuals can easily access basic information about the movies such as the running time, actors involved, plot, ratings by critics and people's reviews therefore making it 
incredibly easy to find something that you are interested in.  While doing this, HMDB also hopes to raise the quality of Habesha movies being made by providing a platform where the 
movie makers, movie watchers and critics openly share the good and the bad in the movies being made. It also aims to create an atmosphere of competition among Directors, Producers, 
movie distributors and studios, with which it wishes to breed a thriving for excellence within all individuals that are involved in making movies.
</p>
</html>
<!DOCTYPE html>
<?php
    
    function imageRetrieve($img) {

       // Connect to the DB
       require_once 'awsLogin.php';
       $db_server = mysqli_connect($db_host, $db_user, $db_password);
       mysqli_select_db($db_server, $db_database)
       or die("Unable to connect to Database." . mysqli_error());

       // Query to pull image from DB, then display result
       $query = "SELECT * FROM images WHERE image = '$img'";
       $result = mysqli_query($db_server, $query);
       $rows = mysqli_num_rows($result);
       $row = mysqli_fetch_row($result);
       echo $_SESSION['image'] = $row[2]; // ROW 2 IS THE IMAGE FILE
       echo '<center><img height = "150" width = "150" src="data:image;charset=utf8;base64,'. base64_encode($row[2]) . ' "/></center> '; 
    }

?>
<html lang="en">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bungee+Shade&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
    </style>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----><link rel="stylesheet" href="dist/css/main.css">
    <title>Tiny URL</title>
    <!-- OG Tags -->
    <meta property="og:title" content="Tiny URL"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content=""/>
    <meta property="og:description" content="Upload an image to be saved in a database.  Creates a shortened URL to the image"/>
</head>

<body>
    <div class="heading">
        <!--<p>tiny</p>-->
        <h1>tinyURL</h1>
        <!--<h5>it's the tiny things in life.</h5>-->
    </div>

    <div class="container">
    <!-- enctype parameter passes img to upload.php -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">

        <div class="container-title"><h3>Upload Your Image</h3></div>
        
        <div class="container-buttons">

            <div class="button-choose"><input type="file" name="file" class="input-button"></div>
            <button type="submit" name="submit">Upload!</button>
        </div> 
        <?php
        session_start();
        
        if (!empty($_SESSION['image'])) {
            // FOR TESTING
            // echo "SESSION STARTED";  IMAGE LINK URL
            $img = $_SESSION['image'];

            // function to retrieve image
            imageRetrieve($img);
            echo "<a href=\"logout.php\">All Done - Log Me Out!</a>";
        } else { // FOR TESTING
            //echo "session not active";
        }
    ?>

    </form>
    </div>
</body>
</html>
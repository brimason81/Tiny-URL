<!DOCTYPE html>
<?php
    
    function imageRetrieve($img) {

       // Connect to the DB
       require_once 'dbLogin.php';
       $db_server = mysqli_connect($db_host, $db_user, $db_password);
       mysqli_select_db($db_server, $db_database)
       or die("Unable to connect to Database." . mysqli_error());

       // Query to pull image from DB, then display result
       $query = "SELECT * FROM images WHERE image = '$img'";
       $result = mysqli_query($db_server, $query);
       $rows = mysqli_num_rows($result);
       $row = mysqli_fetch_row($result);
       $_SESSION['image'] = $row[0];
       echo '<center><img height = "300" width = "300" src="data:image;base64,'. base64_encode($row[0]) . ' "/></center> '; 
    }

?>
<html lang="en">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bungee+Shade&display=swap');
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/css/main.css">
    <title>Tiny URL</title>
    <!-- OG Tags -->
    <meta property="og:title" content="Tiny URL"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content=""/>
    <meta property="og:description" content="Upload an image to be saved in a database.  Creates a shortened URL to the image"/>
</head>

<body>

    <h1>tiny URL</h1>
    <h5>it's the tiny things in life.</h5>
    
    <center>
    <!-- enctype parameter passes img to upload.php -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">

        <h3>Upload Your Image</h3>
        
        <input type="file" name="file">

        <button type="submit" name="submit">Upload!</button>
         
        <?php
        session_start();
        
        if (!empty($_SESSION['image'])) {
            // FOR TESTING
            // echo "SESSION STARTED";  IMAGE LINK URL
            $img = $_SESSION['image'];

            // function to retrieve image
            imageRetrieve($img);
            echo "<a href=\"logout.php\">logout</a>";
        } else { // FOR TESTING
            //echo "session not active";
        }
    ?>

    </form>
    </center>
</body>
</html>
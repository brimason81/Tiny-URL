<?php
   
    // function to insert image into DB
    function insertIntoDB($img_dir, $img){
        
        // Connect to the DB
        require_once 'awsLogin.php';
        $db_server = mysqli_connect($db_host, $db_user, $db_password);
        mysqli_select_db($db_server, $db_database)
        or die("Unable to connect to Database." . mysqli_error());

        // query to insert image into db
        $query = "INSERT INTO images (name, image) VALUES ('$img_dir','$img')";
        $result = mysqli_query($db_server, $query);
    
        // checking results...
        if (!$result) {
            die("Database Access Failed");
        } else {
            session_start();
            $_SESSION['image'] = $img;
            $_SESSION['dir'] = $img_dir;
            header("location: index.php?success");
        }
    }

    // when button is pressed - get image from index.php
    if (isset($_POST['submit'])) {
        // info about image file into variable
        $file = $_FILES['file'];

        // store $_FILES elements into variables
        $fileName = $file['name']; 
        $fileTempName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        
        // access file extension
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        // acceptable extensions, then check
        $allowedExts = array('png', 'jpeg','jpg','pdf', 'svg', 'gif', 'webp', 'heics' ); 
        if (in_array($fileActualExt, $allowedExts)) {
            if ($fileError === 0) {
                if ($fileSize < 10000000) {
                    $newName = uniqid('', true) . "." . $fileActualExt; // saves image as ms time upload - prevents deletion of duplicate file name
                    
                    // insert to DB 
                    insertIntoDB($fileTempName, $newName);
                    //imageRetrieve($newName);
                } else {
                    echo "File Too Big!!";
                }
            } else {
                echo 'Upload Error!';
            }
        } else {
            echo "File Type Not Accepted!";
        }
    }
?>
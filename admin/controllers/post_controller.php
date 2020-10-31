<?php
    include "../inc/db.php";
    if(isset($_POST['delete_id'])){
        $deleteID = $_POST['delete_id'];

        // Delete the Existing Image while Delete the user account
        $deleteImageSQL = "SELECT * FROM post WHERE post_id = '$deleteID'";
        $data = mysqli_query($db, $deleteImageSQL);
        while( $row = mysqli_fetch_assoc($data) ){
            $existingImage = $row['image'];
        }
        if ( !empty($existingImage) ){
            unlink('img/post/'. $existingImage);
        }                      

        // Delete the user data from db
        $sql = "DELETE FROM post WHERE post_id = '$deleteID'";
        $deletePostData = mysqli_query($db, $sql);

        if ( $deletePostData ){
            $_SESSION['deltestamp'] = time();
            echo "Done";
        }
        else{
            die("MySQLi Query Failed." . mysqli_error($db));
        }
    }
?>
<?php
    include "../inc/db.php";
    if(isset($_POST['cat_id'])){
        $cat_idGet = $_POST['cat_id'];
        $getSubCatSQL = "SELECT * FROM category where sub_category='$cat_idGet'";
        $result       = mysqli_query($db,$getSubCatSQL);
        $rowCount     = mysqli_num_rows($result);
        $printData    = "";
        if($rowCount > 0){
            while($rowSub = mysqli_fetch_assoc($result)){
            $cat_id = $rowSub['cat_id'];
            $cat_name = $rowSub['cat_name'];
            $printData .= "<option value='$cat_id'>$cat_name</option>";
            }
            echo $printData;
        } 
        else{
            echo "0";
        }
    }
    else if(isset($_POST['new_count'])){
        $updateSQL = "UPDATE comments set new_status = 0 WHERE new_status = 1";
        $resultUp  = mysqli_query($db,$getSubCatSQL);
        if($resultUp){
            echo "Done";
        }
        else {
            echo "";
        }
    }
?>
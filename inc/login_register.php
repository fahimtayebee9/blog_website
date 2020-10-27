<?php
    include "../admin/inc/db.php";
    session_start();
    if( isset($_GET['action']) && $_GET['action'] == "login"){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];
            $loginSql = "SELECT * FROM visitor WHERE email  = '$email' AND password = '$password' AND status=1";
            $resVisitor = mysqli_query($db,$loginSql);
            if(mysqli_num_rows($resVisitor) > 0){
                while($row = mysqli_fetch_assoc($resVisitor)){
                    
                    $_SESSION["visitorID"] = $row['visitor_id'];
                    $_SESSION['name']       = $row['name'];
                    $_SESSION['email']      = $row['email'];
                    $_SESSION['password']   = $row['password'];
                    $_SESSION['status']     = $row['status'];
                    $_SESSION['image']      = $row['image'];
                    $_SESSION['join_date']  = $row['join_date'];

                    setcookie("visitor_id", $row['visitor_id'], time() + (86400 * 30), "/");

                    $_SESSION['login_toast'] = "VISITOR NAME : ".$row['name'];
                    if(strpos($action,'_')){
                        $post_arr = explode('_',$action);
                        $post = $post_arr[1];
                        header("location: ../single.php?post=$post");
                    }
                    else{
                        header("location: ../index.php");
                    }
                }
            }
            else{
                $_SESSION['toastr'] = "NO USER FOUND";
                header("location: ../index.php");
            }
        }
    }
?>
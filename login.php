<?php
    include "inc/header.php";
    // include "ImageManipulator.php";

    $action = isset($_GET['action']) ? $_GET['action'] : "";
    $mainAction = explode('_',$action);
    if($action == "Login" || $mainAction[0] == "Login"){
    ?>
        <div class="container mt-3 mb-3" >
            <div class="row justify-content-center m-auto" style="height: 65vh;">
                <div class="col-md-6 m-auto">
                    <form action="login.php?action=login" method="POST" class="w-100" >
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-input" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-input" name="password" placeholder="Password">
                        </div>
                        <div class="btn-group  text-center d-block">
                            <input type="submit" class="btn btn-main text-uppercase toastrDefaultSuccess" value="sign in">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }
    else if($action == "Register" || $mainAction[0] == "Register"){
    ?>
        <div class="container mt-3 mb-3" >
            <div class="row justify-content-center m-auto" style="height: 65vh;">
                <div class="col-md-6 m-auto">
                    <form action="login.php?action=register" method="POST" class="w-100" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-input" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-input" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Profile Image</label>
                            <input type="file" class="form-control-file" name="image" accept="image/*" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0]);document.getElementById('image').style.border = 'none' ">
                        </div>
                        <div class="btn-group  text-center d-block">
                            <input type="submit" class="btn btn-main text-uppercase toastrDefaultSuccess" value="sign in">
                        </div>
                    </form>
                </div>
                <div class="col-md-4 m-auto">
                    <img src="admin/img/visitors/temp_image.jpg" alt="" id="image" style="border-radius: 50%; border: 1px solid #2f5888;">
                </div>
            </div>
        </div>
    <?php
    }
    if( isset($_GET['action']) && $_GET['action'] == "login"){
        unset($_SESSION['timeout']);
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];
            $loginSql = "SELECT * FROM visitor WHERE email  = '$email' AND password = '$password' AND status=1";
            $resVisitor = mysqli_query($db,$loginSql);
            if(mysqli_num_rows($resVisitor) > 0){
                while($row = mysqli_fetch_assoc($resVisitor)){
                    
                    $_SESSION["visitorID"]  = $row['visitor_id'];
                    $_SESSION['name']       = $row['name'];
                    $_SESSION['email']      = $row['email'];
                    $_SESSION['password']   = $row['password'];
                    $_SESSION['status']     = $row['status'];
                    $_SESSION['image']      = $row['image'];
                    $_SESSION['join_date']  = $row['join_date'];

                    $_SESSION['login_toast'] = "VISITOR NAME : ".$row['name'];
                    if(strpos($action,'_')){
                        $post_arr = explode('_',$action);
                        $post = $post_arr[1];
                        header("location: single.php?post=$post");
                    }
                    else{
                        $_SESSION['toastr'] = "Login Success.";
                        $_SESSION['toastr_type'] = "success";
                        header("location: index.php");
                    }
                }
            }
            else{
                $_SESSION['toastr'] = "Login Failed.";
                $_SESSION['toastr_type'] = "error";
                header("location: login.php?action=Login");
            }
        }
    }
    else if(isset($_GET['action']) && $_GET['action'] == "register"){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            $email      = $_REQUEST['email'];
            $password   = $_REQUEST['password'];
            $name       = $_REQUEST['name'];

            // PREPARE IMAGE
            $FILE_NAME = $_FILES['image']['name'];
            $FILE_HW   = getimagesize($_FILES['image']['tmp_name']);
            $FILE_SIZE = $_FILES["image"]["size"];
            $FILE_TYPE = $_FILES["image"]["type"];
            $FILE_TMP  = $_FILES['image']['tmp_name'];
            $HEIGHT    = $FILE_HW[0];
            $WIDTH     = $FILE_HW[1];

            if($HEIGHT <=1000 && $WIDTH <= 1000){
                $image = rand(10000,100000)."_".$FILE_NAME;
                $fileName = "admin/img/visitors/".$image;
                // $manipulator = new ImageManipulator($FILE_TMP);
                // resizing to 200x200
                // $newImage = $manipulator->resample(500, 500);
                move_uploaded_file($FILE_TMP,$fileName);
    
                $insertUser = "INSERT INTO `visitor`(`name`, `email`, `password`, `status`, `image`, `join_date`) 
                                VALUES ('$name','$email','$password','0','$image',now())";
                $adduser    = mysqli_query($db,$insertUser);
                if($adduser){
                    if(strpos($action,'_')){
                        $post_arr = explode('_',$action);
                        $post = $post_arr[1];
                        header("location: login.php?action=Login&post=$post");
                    }
                    else{
                        unset($_SESSION['toastr']);
                        $_SESSION['toastr'] = "Registration Success. Please Login To continue.";
                        $_SESSION['toastr_type'] = "success";
                        header("location: login.php?action=Login");
                    }
                }
                else{
                    unset($_SESSION['toastr']);
                    $_SESSION['toastr'] = "Registration Failed.".mysqli_error($db);
                    $_SESSION['toastr_type'] = "error";
                    header("location: login.php?action=Login");
                }
            }
            else{
                unset($_SESSION['toastr']);
                $_SESSION['toastr'] = "Image Size Error. Please Upload 500px*500px Image.";
                $_SESSION['toastr_type'] = "error";
                header("location: login.php?action=Login");
            }
        }
    }

    include "inc/footer.php";
?>    
<?php include "inc/header.php"; ?>

    <!-- Navbar -->
    <?php include "inc/topbar.php"; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "inc/menu.php"; ?>




    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">
            <?php
                $do = isset($_GET['do'] ) ? $_GET['do']  : "Manage"; 
                if($do == "Manage"){
            ?>
                <div class="row">
                    <?php
                        $getWebInfo = "SELECT web_id as web_Id, web_name as web_Name, web_fav as web_Fav, web_logo as web_Logo FROM web_info LIMIT 1";
                        $resultInfo = mysqli_query($db,$getWebInfo);
                        while($rowIn = mysqli_fetch_assoc($resultInfo)){
                            extract($rowIn);
                            $_SESSION['web_id'] = $web_Id;
                        }
                    ?>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Website Settings</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <form action="settings.php?do=Insert" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="name">Change Website Favicon</label>
                                        <div class="logo-view border border-info mb-3 w-50" style="display: flex;align-items: center;height: 120px;">
                                            <img src="img/settings/temp_fav.PNG" alt="" height="100px" width="200px" class="mr-auto" style="margin: auto;" name="web_fav_chn" id="web_fav_chn">
                                        </div>
                                        <input type="file" name="favicon" id="favicon" class="form-control-file" accept="image/*" onchange="document.getElementById('web_fav_chn').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Change Website Logo</label>
                                        <div class="logo-view border border-info mb-3 w-50" style="display: flex;align-items: center;height: 120px;">
                                            <img src="img/settings/temp_logo.PNG" alt="" height="100px" width="200px" class="mr-auto" style="margin: auto;" name="web_logo_chn" id="web_logo_chn">
                                        </div>
                                        <input type="file" name="logo_upload" id="logo" class="form-control-file" accept="image/*" onchange="document.getElementById('web_logo_chn').src = window.URL.createObjectURL(this.files[0])"> 
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Change Website Name</label>
                                        <input type="text" name="web_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="changeSettings" class="btn btn-block btn-primary btn-flat" value="Save Changes">
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Website Details</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="info mb-3">
                                    <label class="d-block">Current Name : <?=$web_Name;?></label>
                                </div>
                                <div class="info mb-3">
                                    <label class="d-block">Current Logo : </label>
                                    <img src="img/settings/<?=$web_Logo;?>" alt="" height="100px" width="240px">
                                </div>
                                <div class="info mb-3">
                                    <label class="d-block">Current Favicon : </label>
                                    <img src="img/settings/<?=$web_Fav;?>" alt="" height="150px" width="200px">
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            <?php
                }
                if($do == "Insert"){
                    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                        $web_name = $_POST['web_name'];
                        // Preapre the Logo
                        $logoName    = $_FILES['logo_upload']['name'];
                        $logoSize    = $_FILES['logo_upload']['size'];
                        $logoTmp     = $_FILES['logo_upload']['tmp_name'];
            
                        $imageAllowedExtension = array("jpg", "jpeg", "png");
                        $exp_arr = explode('.', $logoName);
                        $logoExtension = strtolower( end( $exp_arr ) );
                        
                        $formErrors = [];
            
                        if ( !empty($logoName) ){
                            if ( !empty($logoName) && !in_array($logoExtension, $imageAllowedExtension) ){
                                $formErrors[] = 'Invalid Logo Format. Please Upload a JPG, JPEG or PNG image';
                            }
                            if ( !empty($logoSize) && $logoSize > 2097152 ){
                                $formErrors[] = 'Logo Size is Too Large! Allowed Image size Max is 2 MB.';
                            }
                        }
            
                        // Preapre the Logo
                        $faviconName    = $_FILES['favicon']['name'];
                        $faviconSize    = $_FILES['favicon']['size'];
                        $faviconTmp     = $_FILES['favicon']['tmp_name']; 
            
                        $imageAllowedExtension = array("jpg", "jpeg", "png");
                        $favicon_arr = explode('.', $faviconName);
                        $faviconExtension = strtolower( end( $favicon_arr ) );
                        
                        $formErrors = [];
            
                        if ( !empty($faviconName) ){
                            if ( !empty($faviconName) && !in_array($faviconExtension, $imageAllowedExtension) ){
                                $formErrors[] = 'Invalid Favicon Format. Please Upload a JPG, JPEG or PNG image';
                            }
                            if ( !empty($faviconSize) && $faviconSize > 2097152 ){
                                $formErrors[] = 'Favicon Size is Too Large! Allowed Image size Max is 2 MB.';
                            }
                        }
            
                        // Print the Errors 
                        $countSize = sizeof($formErrors);
                        $count     = 0;
                        while($count < $countSize){
                            echo '<div class="alert alert-warning">' . $formErrors[$count] . '</div>';
                            $count++;
                        }
            
                        if ( empty($formErrors) ){
                            if ( !empty( $logoName ) && !empty( $faviconName )){
                                // Change the Image Name
                                $logo    = "web_logo.".$logoExtension;
                                $favicon = "web_fav.".$faviconExtension;

                                // Upload the Image to its own Folder Location
                                // Delete the Existing Image while update the new image
                                $deleteImageSQL = "SELECT * FROM web_info WHERE web_id = '{$_SESSION['web_id']}'";
                                $data = mysqli_query($db, $deleteImageSQL);
                                while( $row = mysqli_fetch_assoc($data) ){
                                    $existingILogo = $row['web_logo'];
                                    $existingIFav = $row['web_fav'];
                                }
                                unlink("img/settings/".$existingIFav);
                                unlink("img/settings/".$existingILogo);

                                move_uploaded_file($logoTmp, "img\settings\\" . $logo );
                                move_uploaded_file($faviconTmp, "img\settings\\" . $favicon );

                                $sql = "UPDATE `web_info` SET `web_name`='$web_name',`web_fav`='$favicon', `web_logo`='$logo' WHERE web_id = '{$_SESSION['web_id']}'";
                                // echo $logoName;
                                $updateInfo = mysqli_query($db, $sql);
            
                                if ( $updateInfo ){
                                    header("Location: settings.php");
                                }
                                else{
                                    die("MySQLi Query Failed.<br>" . mysqli_error($db));
                                }
                            }
                            else if ( empty( $logoName ) && !empty( $faviconName )){
                                // Upload the Image to its own Folder Location
                                // Delete the Existing Image while update the new image
                                $deleteImageSQL = "SELECT * FROM web_info WHERE web_id = '{$_SESSION['web_id']}'";
                                $data = mysqli_query($db, $deleteImageSQL);
                                while( $row = mysqli_fetch_assoc($data) ){
                                    $existingIFav = $row['web_fav'];
                                }
                                unlink("img/settings/".$existingIFav);
                                
                                move_uploaded_file($faviconTmp, "img\settings\\" . $favicon );
                                $sql = "UPDATE `web_info` SET `web_name`='$web_name',`web_fav`='$favicon' WHERE web_id = '{$_SESSION['web_id']}'";
                                // echo $sql;
                                $updateInfo = mysqli_query($db, $sql);
            
                                if ( $updateInfo ){
                                    header("Location: settings.php");
                                }
                                else{
                                    die("MySQLi Query Failed.<br>" . mysqli_error($db));
                                }
                            } 
                            else if ( !empty( $imageName ) && empty( $faviconName )){
                                // Upload the Image to its own Folder Location
                                // Delete the Existing Image while update the new image
                                $deleteImageSQL = "SELECT * FROM web_info WHERE web_id = '{$_SESSION['web_id']}'";
                                $data = mysqli_query($db, $deleteImageSQL);
                                while( $row = mysqli_fetch_assoc($data) ){
                                    $existingILogo = $row['web_logo'];
                                }
                                unlink("img/settings/".$existingILogo);
                                
                                move_uploaded_file($logoTmp, "img\settings\\" . $logo );

                                $sql = "UPDATE `web_info` SET `web_name`='$web_name',`web_logo`='$logo' WHERE web_id = '{$_SESSION['web_id']}'";
                                // echo $sql;
                                $updateInfo = mysqli_query($db, $sql);
            
                                if ( $updateInfo ){
                                    header("Location: settings.php");
                                }
                                else{
                                    die("MySQLi Query Failed.<br>" . mysqli_error($db));
                                }
                            } 
                            else if( empty( $logoName ) && empty( $faviconName )){
                                $sql = "UPDATE `web_info` SET `web_name`='$web_name' WHERE web_id = '{$_SESSION['web_id']}'";
                                // echo $sql;
                                $updateInfo = mysqli_query($db, $sql);
            
                                if ( $updateInfo ){
                                    header("Location: settings.php");
                                }
                                else{
                                    die("MySQLi Query Failed.<br>" . mysqli_error($db));
                                }
                            }
                        }
                    }
                }
                
                                        
            ?>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    

    <!-- Footer -->
    <?php include "inc/footer.php"; ?>

    <!-- Control Sidebar -->
    <?php include "inc/sidebar.php"; ?>
    <!-- /.control-sidebar -->
    </div>
<!-- ./wrapper -->
<?php include "inc/script.php"; ?>
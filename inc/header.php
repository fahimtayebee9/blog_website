<?php
    date_default_timezone_set('Asia/Dhaka');
    session_start();
    include "ImageManipulator.php";
    ob_start();
    include "admin/inc/db.php";
?>

<!doctype html>
<html lang="en">
<head>
<?php
    $getWebInfo = "SELECT web_id as web_Id, web_name as web_Name, web_fav as web_Fav, web_logo as web_Logo FROM web_info LIMIT 1";
    $resultInfo = mysqli_query($db,$getWebInfo);
    while($rowIn = mysqli_fetch_assoc($resultInfo)){
        extract($rowIn);
    ?>
        <link rel="shortcut icon" href="admin/img/settings/<?=$web_Fav;?>" type="image/x-icon">
    <?php
        
    }
?>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <!-- Website Description -->
    <meta name="description" content="Blue Chip: Corporate Multi Purpose Business Template" />
    <meta name="author" content="Blue Chip" />

    <!--  Favicons / Title Bar Icon  -->
    <link rel="shortcut icon" href="assets/images/favicon/favicon.png" />
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon/favicon.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon/favicon.png" />

    <title>Blue Chip | Blog Right Sidebar</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">

    <!-- Flat Icon CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/flaticon.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owl.theme.default.min.css">

    <!-- Fency Box CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.min.css">

    <!-- Theme Main Style CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/custom_style.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

    <!-- TOASTR CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/toastr.min.css">

    <!-- swiper CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/swiper.min.css">
</head>

<body>
    <header class="nav-style-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light  " >
                        <div class="collapse navbar-collapse justify-content-start w-50" id="navbarNavDropdown">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
                                        $posts_sql = "SELECT * FROM post ORDER BY post_id DESC LIMIT 2";
                                        $result_post = mysqli_query($db,$posts_sql);
                                        while($rowPostx = mysqli_fetch_assoc($result_post)){
                                    ?>
                                            <div class="swiper-slide w-100">
                                                <a href="single.php?post=<?=$rowPostx['post_id']?>" class="text-left"><?=substr($rowPostx['title'],0,50);?></a>
                                            </div>
                                            <span>|</span>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            if(isset($_SESSION["visitorID"])){
                        ?>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav justify-content-end w-15">
                                
                                <li>
                                    <a class="d-flex align-items-center justify-content-between" href="logout.php"> <i class="fa fa-sign-out mr-1"></i> <span>LOGOUT</span></a>
                                </li>
                                
                            </ul>
                        </div>
                        <?php
                            }
                            else{
                        ?>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                                <ul class="navbar-nav justify-content-between w-50">
                                    
                                    <li>
                                        <a class="d-flex align-items-center justify-content-between" href="login.php?action=Login<?php if ( isset( $_GET['post'] ) ){ echo "_".$_GET['post'];}?>"> <i class="fa fa-user mr-1"></i> Login</a>
                                    </li>
                                    <li>
                                        <div class="divider"></div>
                                    </li>
                                    <li>
                                        <a class="d-flex align-items-center justify-content-between" href="login.php?action=Register<?php if ( isset( $_GET['post'] ) ){ echo "_".$_GET['post'];}?>"> <i class="fa fa-user mr-1"></i> Registration</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        <?php
                            }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <!-- :::::::::: Header Section Start :::::::: -->
    <header class="nav-style">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand nav-logo" href="index.php"><img src="admin/img/settings/<?=$web_Logo;?>" class="nav_logo" alt=""></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <?php
                                    $sql = "SELECT * FROM category WHERE sub_category = 0 ORDER BY cat_name ASC";
                                    $allCat = mysqli_query($db, $sql);
                                    while ( $row = mysqli_fetch_assoc($allCat) ){
                                        $cat_id     = $row['cat_id'];
                                        $cat_name   = $row['cat_name'];
                                        $cat_desc   = $row['cat_desc'];
                                        $status     = $row['status'];

                                        $journalName = str_replace(' ', '_', $cat_name);
                                        $journalName = str_replace('&', '%', $journalName);

                                        $getSubCategorySql = "SELECT * FROM category where sub_category='$cat_id'";
                                        $result       = mysqli_query($db,$getSubCategorySql);
                                        $rowCount     = mysqli_num_rows($result);
                                            if($rowCount == 0){
                                        ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="category.php?category=<?php echo $journalName; ?>"><?php echo $cat_name; ?></a>
                                                </li>
                                <?php       }
                                            else{
                                            ?>
                                            <li class="nav-item">
                                                <div class="dropdown show">
                                                    <a class="nav-link dropdown-toggle" href="category.php?category=<?php echo $journalName; ?>" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?php echo $cat_name; ?>
                                                    </a>
                                                    <div class="dropdown-menu dropdown_menu" aria-labelledby="dropdownMenuLink">
                                            <?php
                                                while($rowSub = mysqli_fetch_assoc($result)){
                                                    $cat_id_sub = $rowSub['cat_id'];
                                                    $cat_name_sub = $rowSub['cat_name'];
                                                    $journalName_sub = str_replace(' ', '_', $cat_name_sub);
                                                    $journalName_sub = str_replace('&', '%', $journalName_sub);
                                            ?>
                                                    <a class="nav-link nav-link-sub dropdown-item" href="category.php?category=<?php echo $journalName_sub; ?>"><?php echo $cat_name_sub; ?></a>
                                            <?php
                                                }
                                            ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php
                                            }
                                        }
                                ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ::::::::::: Header Section End ::::::::: -->
<?php
  include "inc/db.php";
  ob_start();
  
  session_start();

  // To check the User if Session Data found
  if ( empty( $_SESSION['email'] ) || empty( $_SESSION['password'] ) ){
    header("Location: index.php");
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $getWebInfo = "SELECT web_id as web_Id, web_name as web_Name, web_fav as web_Fav, web_logo as web_Logo FROM web_info LIMIT 1";
    $resultInfo = mysqli_query($db,$getWebInfo);
    while($rowIn = mysqli_fetch_assoc($resultInfo)){
        extract($rowIn);
        $_SESSION['web_logo'] = $web_Logo;
        $_SESSION['web_fav']  = $web_Fav;
    }
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta http-equiv="refresh" content="30;url=logout.php?time=30&action=Logout" /> -->
  <link rel="shortcut icon" href="img/settings/<?=$web_Fav;?>" type="image/x-icon">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/style.css">
  <!-- SWEET ALERT 2 -->
  <script src="../assets/js/toastr.min.js"></script>
  <link rel="stylesheet" href="../assets/css/toastr.min.css">  

  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">  

  <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
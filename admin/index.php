<?php
  ob_start();
  session_start();
  include("inc/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- TOASTR -->
  <script src="../assets/js/toastr.min.js"></script>
  <link rel="stylesheet" href="../assets/css/toastr.min.css">
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- SWEET ALERT 2 -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">  
  <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="submit" name="login" class="btn btn-primary btn-block" value="Sign In" onclick="danger()">
          </div>
          <!-- /.col -->
        </div>
      </form>


      <?php

        if ( isset($_POST['login']) ){
          $email      = mysqli_real_escape_string($db, $_POST['email']);
          $password   = mysqli_real_escape_string($db, $_POST['password']);
          $hassed     = sha1($password);

          $sql = "SELECT * FROM users WHERE email = '$email'";
          $authUser = mysqli_query($db, $sql);
          while($row = mysqli_fetch_assoc($authUser)){
            $_SESSION['id']           = $row['id'];
            $_SESSION['name']         = $row['name'];
            $_SESSION['email']        = $row['email'];
            $_SESSION['password']     = $row['password'];
            $_SESSION['address']      = $row['address'];
            $_SESSION['phone']        = $row['phone'];
            $_SESSION['role']         = $row['role'];
            $_SESSION['status']       = $row['status'];
            $_SESSION['image']        = $row['image'];
            $_SESSION['join_date']    = $row['join_date'];
            $_SESSION['success']      = "";
            $_SESSION['danger']       = "";
            $_SESSION['warning']      = "";

            if ( $email == $_SESSION['email'] && $hassed == $_SESSION['password'] && $_SESSION['status'] == 1 ){
              $_SESSION['timestamp'] = time();
              header("Location: dashboard.php");
              exit();
            }
            else if ( $email != $_SESSION['email'] && $hassed != $_SESSION['password'] && $_SESSION['status'] != 1 ){
              $_SESSION['danger'] = "Incorrect Information";
              header("Location: index.php");
              exit();
            }
            else{
              $_SESSION['danger'] = "Incorrect Information";
              header("Location: index.php");
              exit();
            }
          }

        }

      ?>


      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="recover-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- sweetalert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    

<script>
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000
  });
  <?php
    if(isset($_SESSION['time']) && is_numeric($_SESSION['time']) && $_SESSION['time'] != 0){
  ?>
      Toast.fire({
        position: 'top-end',
        icon: 'error',
        title: 'You are logged out because there was no activity.\nPlease Login Again',
        showConfirmButton: false,
        timer: 4000
      })
  <?php
      unset($_SESSION['time']);
    }
  ?>
</script>

<?php
  ob_end_flush();
?>
</body>
</html>

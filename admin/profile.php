<?php include "inc/header.php"; ?>

  <!-- Navbar -->
  <?php include "inc/topbar.php"; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "inc/menu.php"; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
          <?php
            if(isset($_GET['do']) && isset($_GET['view'])){
              $getUserData = "SELECT * FROM users WHERE id = '{$_GET['view']}'";
            }
            else{
              $getUserData = "SELECT * FROM users WHERE id = '{$_SESSION['id']}'";
            }
            $resUser     = mysqli_query($db,$getUserData);
            while($row = mysqli_fetch_assoc($resUser)){
              $name       = $row['name'];
              $email      = $row['email'];
              $phone      = $row['phone'];
              $image      = $row['image'];
              $address    = $row['address'];
              $role       = $row['role'];
              $status     = $row['status'];
              $join_date  = $row['join_date'];
            }
          ?>
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <?php
                    if(!empty($image)){
                  ?>
                      <img class="profile-user-img img-fluid img-circle" src="img/users/<?=$image?>" alt="User profile picture">
                  <?php
                    }
                    else{
                  ?>
                      <img class="profile-user-img img-fluid img-circle" src="img/users/default.png" alt="User profile picture">
                  <?php
                    }
                  ?>
                  
                </div>

                <h3 class="profile-username text-center"><?=$name?></h3>

                <p class="text-muted text-center">
                  <?php
                    if($role == "1"){
                      echo "SUPER ADMIN";
                    }
                    else if($role == 2){
                      echo "EDITOR";
                    }
                  ?>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Phone</strong>

                <p class="text-muted">
                  <?=$phone?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?=$address?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    
                      <?php
                        if(isset($_GET['do']) && isset($_GET['view'])){
                          $getPostsSql = "SELECT * FROM post WHERE author_id = '{$_GET['view']}'";
                        }
                        else{
                          $getPostsSql = "SELECT * FROM post WHERE author_id = '{$_SESSION['id']}'";
                        }
                        $resPOSTS    = mysqli_query($db,$getPostsSql);
                        if(mysqli_num_rows($resPOSTS) == 0){
                      ?>
                          <div class="alert alert-warning">
                            No Posts Published.
                          </div>
                      <?php
                        }
                        while($rowPs = mysqli_fetch_assoc($resPOSTS)){
                      ?>
                        <div class="post border-0">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="img/post/<?=$rowPs['image']?>" alt="user image">
                            <span class="username">
                              <a href="post.php?do=Edit&edit=<?=$rowPs['post_id']?>"><?=$rowPs['title']?></a>
                              <!-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> -->
                            </span>
                            <?php
                              $dateArrMain = explode(' ',$rowPs['post_date']);
                              $datePart    = $dateArrMain[0];
                              $timePart    = $dateArrMain[1];
                              $am_array    = ["7","8","9","9:30","10","11"];
                              $timeArr     = explode(':',date("h:i:s",strtotime('+24 hour',strtotime($timePart))));
                              if(in_array($timeArr[0],$am_array)){
                                  $time =  date("h:i A",strtotime('+24 hour',strtotime($timeArr[0])));
                              }
                              else if(!in_array($timeArr[0],$am_array)){
                                  $time =  date("h:i A",strtotime('+12 hour',strtotime($timeArr[0])));
                              }
                              else{
                                  $time =  date("h:i A",strtotime('+24 hour',strtotime($timeArr[0])));
                              }
                              $date_arrPost = explode('-',$datePart);
                              $date = $date_arrPost[2] . " " . substr(date('F', mktime(0, 0, 0, $date_arrPost[1], 10)),0,3) .", " . $date_arrPost[0];
                            ?>
                            <span class="description">Posted On - <?=$time?> <?=$date?></span>
                          </div>
                          <!-- /.user-block -->
                          <p>
                            <?=substr($rowPs['description'],0,250)?>
                          </p>

                      <p>
                        <!-- <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a> -->
                        <!-- <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a> -->
                        <span class="float-right">
                          <a href="comments.php?do=Manage" class="link-black text-sm">
                            <?php
                              $total_comment = $db->query("SELECT * FROM comments WHERE post_id = '{$rowPs['post_id']}'")->num_rows;
                            ?>
                            <i class="far fa-comments mr-1"></i> Comments (<?=$total_comment?>)
                          </a>
                        </span>
                      </p>
                    </div>
                  <?php
                    }
                  ?>
                      <!-- <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> -->
                    
                    <!-- /.post -->

                    
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <?php
                        if(isset($_GET['do']) && isset($_GET['view'])){
                          $getComments = "SELECT comments.cmt_id, comments.comments,comments.post_id as cmt_postId,comments.visitor_id, comments.cmt_date,
                                        comments.is_parent,comments.status as cmt_status, comments.new_status as cmt_newStatus, post.title,
                                        post.description, post.category_id, post.post_date, post.meta, post.status, post.author_id FROM comments 
                                        inner join post on comments.post_id = post.post_id WHERE post.author_id = '{$_GET['view']}' 
                                        GROUP BY comments.cmt_date ORDER BY comments.cmt_date DESC";
                          // $getComments = "SELECT * FROM post WHERE author_id = '{$_GET['view']}' ORDER BY post_date DESC";  
                      }
                        else{
                          // $getComments = "SELECT * FROM post WHERE author_id = '{$_SESSION['id']}' ORDER BY post_date DESC";
                          $getComments = "SELECT comments.cmt_id, comments.comments,comments.post_id as cmt_postId,comments.visitor_id, comments.cmt_date,
                                          comments.is_parent,comments.status as cmt_status, comments.new_status as cmt_newStatus, post.title,
                                          post.description, post.category_id, post.post_date, post.meta, post.status, post.author_id FROM comments 
                                          inner join post on comments.post_id = post.post_id WHERE post.author_id = '{$_SESSION['id']}' 
                                          GROUP BY comments.cmt_date ORDER BY comments.cmt_date DESC";
                        }
                        
                        $resPost      = mysqli_query($db,$getComments);
                        
                        if(mysqli_num_rows($resPost) == 0){
                          ?>
                            <div class="alert alert-info">
                              Nothing to show.
                            </div>
                          <?php
                        }
                        else{
                          $ttl = 0;
                          $allPostDates = [];
                          while($rowPost = mysqli_fetch_assoc($resPost)){
                            // $post_idIn      = $rowPost['post_id'];
                            $title          = $rowPost['title'];
                            $description    = $rowPost['description'];
                            $category_id    = $rowPost['category_id'];
                            $author_id      = $rowPost['author_id'];
                            $status         = $rowPost['status'];
                            $meta           = $rowPost['meta'];
                            $post_date      = $rowPost['post_date'];
                            $cmt_id         = $rowPost['cmt_id'];
                            $comments       = $rowPost['comments'];
                            $visitor_id     = $rowPost['visitor_id'];
                            $is_parent      = $rowPost['is_parent'];
                            $cmt_date       = $rowPost['cmt_date'];
                            $cmt_newStatus  = $rowPost['cmt_newStatus'];
                            $cmt_status     = $rowPost['cmt_status'];
                            $allPostDates[] = $rowPost;
                            
                            // $allCommentDates[sizeof($allCommentDates)-1] != $next_cmtDate && 
                            $ttl++;
                          }

                          $count = 0;
                          $disticnt_date = [];
                          while($count < sizeof($allPostDates)){
                            $next = $count + 1;
                            if( $next == sizeof($allPostDates) ){
                              $disticnt_date[] = date("d M, Y", strtotime(explode(' ',$allPostDates[$count]['cmt_date'])[0]));
                            }
                            else{
                              if( date("d M, Y", strtotime(explode(' ',$allPostDates[$count]['cmt_date'])[0])) !=  date("d M, Y", strtotime(explode(' ',$allPostDates[$count + 1]['cmt_date'])[0]))){
                                $disticnt_date[] = date("d M, Y", strtotime(explode(' ',$allPostDates[$count]['cmt_date'])[0]));
                              }
                            }
                            $count++;
                          }

                          $count = 0;
                          while($count < sizeof($disticnt_date)){
                            $dateYMD = date("Y-m-d",strtotime($disticnt_date[$count]));
                            ?>
                              <div class="time-label">
                                <span class="bg-info">
                                  <?php 
                                      echo $disticnt_date[$count];
                                  ?>
                                </span>
                              </div>
                            <?php
                              $getDataByDate = "SELECT * FROM comments WHERE cmt_date LIKE '$dateYMD%' ORDER BY cmt_date DESC";
                              $resData       = mysqli_query($db,$getDataByDate);
                              
                              while($rowDate = mysqli_fetch_assoc($resData)){
                                $cmt_id_byDate         = $rowDate['cmt_id'];
                                $comments_byDate       = $rowDate['comments'];
                                $visitor_id_byDate     = $rowDate['visitor_id'];
                                $is_parent_byDate      = $rowDate['is_parent'];
                                $cmt_date_byDate       = $rowDate['cmt_date'];
                                $cmt_newStatus_byDate  = $rowDate['new_status'];
                                $cmt_status_byDate     = $rowDate['status'];
                                
                                $getVisitorInfoSql = "SELECT * FROM visitor WHERE visitor_id = '$visitor_id_byDate'";
                                $resVisitor        = mysqli_query($db,$getVisitorInfoSql);
                                while($rowVisitor = mysqli_fetch_assoc($resVisitor)){
                                  $vs_name = $rowVisitor['name'];
                                }
                                ?>
                                  <!-- timeline item -->
                                  <div>
                                    <i class="fas fa-comments bg-warning"></i>

                                    <div class="timeline-item">
                                      <span class="time"><i class="far fa-clock"></i>
                                        <?php
                                          $timeDiff = time() - strtotime($cmt_date_byDate) ;
                                          $hours    = floor($timeDiff / (60*60)); 
                                          $minutes  = floor($hours/60);
                                          if($minutes > 0 && $hours < 1){
                                              echo $minutes . " Mins ago";
                                          }
                                          else if($hours < 24 && $hours >= 1){
                                              echo $hours . " hours ago";
                                          }
                                          else if($hours > 24){
                                              echo floor($hours/24) . " Days ago"; 
                                          }
                                          // echo $prev_cmtDate;
                                        ?>
                                        
                                      </span>

                                      <h3 class="timeline-header"><a href="#"><?=$vs_name?></a> commented on your post</h3>

                                      <div class="timeline-body">
                                        <?=$comments_byDate?>
                                      </div>
                                      <div class="timeline-footer">
                                        <a href="comments.php?edit=<?=$cmt_id_byDate?>" class="btn btn-secondary btn-flat btn-sm">View comment</a>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- END timeline item -->
                                <?php
                              }
                              $count++;
                          }
                        }
                      ?>
                      
                      
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" action="profile.php?do=Insert" method="POST">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="name" class="form-control" name="name" id="inputName" placeholder="Name" value="<?=$name?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" value="<?=$email?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="password" id="inputName2" placeholder="Password" value="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="address" id="inputExperience" placeholder="Experience"><?=$address?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="phone" id="inputSkills" placeholder="Skills" value="<?=$phone?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Profile Image</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control-file" name="image" id="profileImage" placeholder="Profile Image">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="terms"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                            <?php
                              if(isset($_GET['view'])){
                            ?>
                                  <input type="hidden" name="userID" id="user_id" value="<?=$_GET['view']?>">
                            <?php
                              }else{
                            ?>
                                  <input type="hidden" name="userID" id="user_id" value="<?=$_SESSION['id']?>">
                            <?php
                              }
                            ?>
                            
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <input type="submit" class="btn btn-danger" value="Submit">
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <?php
    $do = isset($_GET['do']) ? $_GET['do'] : "";
    if($do == "Insert"){
      if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['terms'])){
          $updateUserID = $_POST['userID'];
          $name         = $_POST['name'];
          $email        = $_POST['email'];
          $password     = $_POST['password'];
          // $repassword   = $_POST['repassword'];
          $address      = $_POST['address'];
          $phone        = $_POST['phone'];
          $imageName    = $_FILES['image']['name'];

          if ( !empty($imageName) ){
            // $imageName    = $_FILES['image']['name'];
            $imageSize    = $_FILES['image']['size'];
            $imageTmp     = $_FILES['image']['tmp_name'];

            $imageAllowedExtension = array("jpg", "jpeg", "png");
            $imageExtension = strtolower( end( explode('.', $imageName) ) );
            
            $formErrors = array();

            if ( strlen($name) < 3 ){
              $formErrors = array('Username is too short!!!');
            }
            if ( $password != $repassword ){
              $formErrors = array('Password Doesn\'t match!!!');
            }
            if ( !empty($imageName) ){
              if ( !empty($imageName) && !in_array($imageExtension, $imageAllowedExtension) ){
                $formErrors = array('Invalid Image Format. Please Upload a JPG, JPEG or PNG image');
              }
              if ( !empty($imageSize) && $imageSize > 2097152 ){
                $formErrors = array('Image Size is Too Large! Allowed Image size Max is 2 MB.');
              }
            }
          }

          // Print the Errors 
          foreach( $formErrors as $error ){
            echo '<div class="alert alert-warning">' . $error . '</div>';
          }

          if ( empty($formErrors) ){

            // Upload Image and Change the Password
            if ( !empty($password) && !empty($imageName) ){
              // Encrypted Password
              $hassedPass = sha1($password);

              // Delete the Existing Image while update the new image
              $deleteImageSQL = "SELECT * FROM users WHERE id = '$updateUserID'";
              $data = mysqli_query($db, $deleteImageSQL);
              while( $row = mysqli_fetch_assoc($data) ){
                $existingImage = $row['image'];
              }
              unlink('img/users/'. $existingImage);
              
              // Change the Image Name
              $image = rand(0, 999999) . '_' .$imageName;
              // Upload the Image to its own Folder Location
              move_uploaded_file($imageTmp, "img\users\\" . $image );

              $sql = "UPDATE users SET name='$name', email='$email', password='$hassedPass', address='$address', phone='$phone', image='$image' WHERE id = '$updateUserID' ";

              $addUser = mysqli_query($db, $sql);

              if ( $addUser ){
                header("Location: users.php?do=Manage");
              }
              else{
                die("MySQLi Query Failed." . mysqli_error($db));
              }
            }

            // Change the Image Only
            else if ( !empty($imageName) && empty($password) ){
              // Delete the Existing Image while update the new image
              $deleteImageSQL = "SELECT * FROM users WHERE id = '$updateUserID'";
              $data = mysqli_query($db, $deleteImageSQL);
              while( $row = mysqli_fetch_assoc($data) ){
                $existingImage = $row['image'];
              }
              unlink('img/users/'. $existingImage);
              
              // Change the Image Name
              $image = rand(0, 999999) . '_' .$imageName;
              // Upload the Image to its own Folder Location
              move_uploaded_file($imageTmp, "img\users\\" . $image );

              $sql = "UPDATE users SET name='$name', email='$email', address='$address', phone='$phone', image='$image' WHERE id = '$updateUserID' ";

              $addUser = mysqli_query($db, $sql);

              if ( $addUser ){
                header("Location: users.php?do=Manage");
              }
              else{
                die("MySQLi Query Failed." . mysqli_error($db));
              }
            }
            // Change the Password Only
            else if ( !empty($password) && empty($imageName) ){
              // Encrypted Password
              $hassedPass = sha1($password);

              $sql = "UPDATE users SET name='$name', email='$email', password='$hassedPass', address='$address', phone='$phone' WHERE id = '$updateUserID' ";

              $addUser = mysqli_query($db, $sql);

              if ( $addUser ){
                header("Location: users.php?do=Manage");
              }
              else{
                die("MySQLi Query Failed." . mysqli_error($db));
              }
            }
            // No Password and Image Update
            else{
              $sql = "UPDATE users SET name='$name', email='$email', address='$address', phone='$phone' WHERE id = '$updateUserID' ";

              $addUser = mysqli_query($db, $sql);

              if ( $addUser ){

                header("Location: profile.php");
              }
              else{
                die("MySQLi Query Failed." . mysqli_error($db));
              }
            }
            
          }
        }
        else{
          echo "<script>alert('Terms NOT Accepted')</script>";
        }
      }
    }
  ?>

  <!-- /.content-wrapper -->

  <!-- Footer -->
  <?php include "inc/footer.php"; ?>

  <!-- Control Sidebar -->
  <?php include "inc/sidebar.php"; ?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include "inc/script.php"; ?>
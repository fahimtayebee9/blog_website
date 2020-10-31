<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="contact.php" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" action="search.php?action=Search" method="POST">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" name="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" onclick="removeCount()">
          <?php
            $newComments = "SELECT * FROM comments WHERE new_status = 1";
            $res_newCmt  = mysqli_query($db,$newComments);
            $count_newCmt = mysqli_num_rows($res_newCmt);
          ?>
          <i class="far fa-comments"></i>
          <?php
            if($count_newCmt > 0){
          ?>
            <span class="badge badge-danger navbar-badge" id="new_count"><?=$count_newCmt?></span>
          <?php
            }
          ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <?php
            $cmt_i = 0;
            while($rowCmt = mysqli_fetch_assoc($res_newCmt)){
          ?>
                <a href="#" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                  <?php
                      if(!empty($visitor_image_rep)){
                  ?>
                          <img src="img/visitors/<?=$visitor_image_rep;?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                  <?php
                      }
                      else{
                  ?>
                          <img src="img/visitors/temp_image.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                  <?php
                      }
                  ?>
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      <?php
                        $getVs = "SELECT * FROM visitor WHERE visitor_id = '{$rowCmt['visitor_id']}'";
                        $resVs = mysqli_query($db,$getVs);
                        while($rowVs = mysqli_fetch_assoc($resVs)){
                          $name = $rowVs['name'];
                        }
                        echo $name;
                      ?>
                      <!-- <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span> -->
                    </h3>
                    <p class="text-sm"><?=substr($rowCmt['comments'],0,30)?></p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                          <?php
                            $timeDiff = time() - strtotime($rowCmt['cmt_date']) ;
                            $hours    = floor($timeDiff / (60*60)); 
                            $minutes  = floor($hours/60);
                            if($minutes > 0 && $hours < 1){
                                echo $minutes . " Minutes ago";
                            }
                            else if($hours < 24 && $hours >= 1){
                                echo $hours . " hours ago";
                            }
                            else if($hours > 24){
                                echo floor($hours/24) . " Days ago"; 
                            }
                        ?>
                    </p>
                  </div>
                </div>
                <!-- Message End -->
              </a>
              <div class="dropdown-divider"></div>
          <?php
              if($cmt_i < 4){
                $cmt_i++;
              }
              else{
                break;
              }
            }
          ?>
          <a href="comments.php?do=Manage" class="dropdown-item dropdown-footer">See All Comments</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <?php
          $new_posts = $db->query("SELECT * FROM post WHERE newPost = 1")->num_rows;
          $new_users = $db->query("SELECT * FROM users WHERE new_user = 1")->num_rows;
          $new_visitor = $db->query("SELECT * FROM visitor WHERE id_status = 1")->num_rows;
          $total_newItem = $new_posts + $new_users + $new_visitor;
        ?>
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">
            <?php
              if($total_newItem != 0){
                echo $total_newItem;
              }    
              else {
                echo 0;
              }
            ?>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            <?php
              if($total_newItem != 0){
                echo $total_newItem;
              }    
              else {
                echo 0;
              }
            ?> New Notifications</span>
          <div class="dropdown-divider"></div>
          <?php
            $lastuserSQL = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
            $resUser     = mysqli_query($db,$lastuserSQL);
            while($rowUser = mysqli_fetch_assoc($resUser)){
              $join_date = $rowUser['join_date'];
            }
            $time_hr = floor( ( time() - strtotime( $join_date ) ) / (60 * 60) );
            // $hours    = floor($timeDiff / (60*60)); 
            $minutes  = floor($time_hr/60);
            $seconds  = floor($minutes / 60);
            $time_str = "";
            if($minutes > 0 && $time_hr < 1){
              $time_str =  $minutes . " Minutes";
            }
            else if($time_hr < 24 && $time_hr >= 1){
              $time_str =  $time_hr . " hours";
            }
            else if($time_hr > 24){
              $time_str =  floor($time_hr/24) . " Days"; 
            }
          ?>
          <a href="users.php?do=Manage" class="dropdown-item">
            <i class="fas fa-user-plus mr-2"></i> 
            <?php
              if($new_users != 0){
                echo $new_users;
              }    
              else {
                echo 0;
              }
            ?> new users
            <!-- <span class="float-right text-muted text-sm"><?//=$time_str?></span> -->
          </a>
          <div class="dropdown-divider"></div>
          <?php
            $lastPostSQL = "SELECT * FROM post ORDER BY post_id DESC LIMIT 1";
            $resPost     = mysqli_query($db,$lastPostSQL);
            while($rowPost = mysqli_fetch_assoc($resPost)){
              $post_date = $rowPost['post_date'];
            }
            $time_hr_post = floor( ( time() - strtotime( $post_date ) ) / (60 * 60) );
            // $hours    = floor($timeDiff / (60*60)); 
            $minutes_post  = floor($time_hr_post /60);
            $seconds_post  = floor($minutes_post / 60);
            $time_str_post = "";
            if($minutes_post > 0 && $time_hr_post < 1){
              $time_str_post =  $minutes_post . " Minutes";
            }
            else if($time_hr < 24 && $time_hr_post >= 1){
              $time_str_post =  $time_hr_post . " hours";
            }
            else if($time_hr_post > 24){
              $time_str_post =  floor($time_hr_post/24) . " Days"; 
            }
          ?>
          <a href="post.php?do=Manage" class="dropdown-item">
            <i class="fas fa-clone mr-2"></i> 
            <?php
              if($new_posts != 0){
                echo $new_posts;
              }    
              else {
                echo 0;
              }
            ?> new posts
            <!-- <span class="float-right text-muted text-sm"><?//=$time_str_post?></span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="visitor.php?do=Manage" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> 
            <?php
              if($new_visitor != 0){
                echo $new_visitor;
              }    
              else {
                echo 0;
              }
            ?> new visitors
            <!-- <span class="float-right text-muted text-sm"><?=$time_str_vs?></span> -->
          </a>
          <div class="dropdown-divider"></div>
          <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
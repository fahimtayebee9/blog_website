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
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
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
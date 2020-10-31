<?php
    include "inc/header.php";

    $action = isset($_GET['action']) ? $_GET['action'] : "";
    $mainAction = explode('_',$action);
    if($action == "Login" || $mainAction[0] == "Login"){
    ?>
        <div class="container mt-3 mb-3" >
            <div class="row justify-content-center m-auto" style="height: 65vh;">
                <div class="col-md-6 m-auto">
                    <form action="inc/login_register.php?action=LoginCheck" method="POST" class="w-100" >
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control form-input" name="email" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control form-input" name="password" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="btn-group  text-center d-block">
                            <input type="submit" class="btn btn-main text-uppercase" value="sign in">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }

    if ( isset( $_GET['post'] ) ){
        $thePost = $_GET['post'];

        $sql = "SELECT * FROM post WHERE post_id = '$thePost'";
        $allPost = mysqli_query($db, $sql);
        while ( $row = mysqli_fetch_assoc($allPost) ){
            $post_id             = $row['post_id'];
            $title          = $row['title'];
            $description    = $row['description'];
            $image          = $row['image'];
            $category_id    = $row['category_id'];
            $author_id      = $row['author_id'];
            $status         = $row['status'];
            $meta           = $row['meta'];
            $post_date      = $row['post_date'];

            $catsql = "SELECT * FROM category WHERE cat_id = '$category_id'";
            $readCat = mysqli_query($db, $catsql);
            while( $row = mysqli_fetch_assoc($readCat) ){
                $cat_id   = $row['cat_id'];
                $cat_name = $row['cat_name'];
?>
    <!-- :::::::::: Page Banner Section Start :::::::: -->
    <section class="blog-bg background-img">
        <div class="container">
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title"><?=$title;?></h2>
                    <!-- Page Heading Breadcrumb Start -->
                    <nav class="page-breadcrumb-item">
                        <ol>
                            <li><a href="index.html">Home <i class="fa fa-angle-double-right"></i></a></li>
                            <li><a href="index.php">Blog <i class="fa fa-angle-double-right"></i></a></li>
                            <!-- Active Breadcrumb -->
                            <li class="active"><?=$cat_name;?></li>
                        </ol>
                    </nav>
                    <!-- Page Heading Breadcrumb End -->
                </div>
                
            </div>
            <!-- Row End -->
        </div>
    </section>
    <!-- ::::::::::: Page Banner Section End ::::::::: -->



    <!-- :::::::::: Blog With Right Sidebar Start :::::::: -->
    <section>
        <div class="container">
            <div class="row">
                <!-- Blog Single Posts -->
                <div class="col-md-8">

                    <!-- Single Item Blog Post Start -->
                    <div class="blog-post">
                        <!-- Blog Banner Image -->
                        <div class="blog-banner">
                            <a href="single.php?post=<?php echo $post_id; ?>">
                                <img src="admin/img/post/<?php echo $image; ?>">
                                <!-- Post Category Names -->
                                <div class="blog-category-name">
                                    
                                    <h6><?php echo $cat_name; ?></h6>
    <?php  
            }
    ?>
                                </div>
                            </a>
                        </div>
                        <!-- Blog Title and Description -->
                        <div class="blog-description">
                            <a href="single.php?post=<?php echo $post_id; ?>">
                                <h3 class="post-title"><?php echo $title; ?></h3>
                            </a>
                            <p><?php  echo $description; ?></p>
                            <!-- Blog Info, Date and Author -->
                            <div class="row" style="margin-top: 25px;">
                                <div class="col-md-8">
                                    <div class="blog-info">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i>
                                                <?php 
                                                    $am_array = ["7","8","9","9:30","10","11"];
                                                    $postDateArr = explode(' ', $post_date);
                                                    $datePart_post = explode('-',$postDateArr[0]);
                                                    $date_         = $datePart_post[2] . " " . substr(date('F', mktime(0, 0, 0, $datePart_post[1], 10)),0,3) . " ," . $datePart_post[0];
                                                    // echo $date_;
                                                    $postTime      = explode(':',date("h:i:s",strtotime('+24 hour',strtotime($postDateArr[1]))));
                                                    if(in_array($postTime[0],$am_array)){
                                                        $date_ .= " ".date("h:i A",strtotime('+24 hour',strtotime($postDateArr[1])));
                                                    }
                                                    else if(!in_array($postTime[0],$am_array)){
                                                        $date_ .= " ".date("h:i A",strtotime('+12 hour',strtotime($postDateArr[1])));
                                                    }
                                                    else{
                                                        $date_ .= " ".date("h:i A",strtotime('+24 hour',strtotime($postDateArr[1])));
                                                    }
                                                    echo $date_;
                                                ?>
                                            </li>
                                            <li>
                                                <?php
                                                    $sql = "SELECT * FROM users WHERE id = '$author_id'";
                                                    $readUser = mysqli_query($db, $sql);
                                                    while( $row = mysqli_fetch_assoc($readUser) ){
                                                        $id   = $row['id'];
                                                        $name = $row['name'];
                                                    }
                                                ?>
                                                <i class="fa fa-user"></i>Posted By - <?php echo $name; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="col-md-8 meta-tags">
                                    <h3 class="">Related Tags</h3>
                                        <ul class="mt-3 d-flex align-items-center">
                                            <?php
                                                $metaARR = explode(',',$meta);

                                                foreach($metaARR as $mt){
                                            ?>
                                                    <li class="mr-3">
                                                        <!-- <span> -->
                                                            <a class="text-light text-decoration-none btn-main" href="category.php?meta=<?php echo $mt; ?>"><?php echo strtoupper($mt); ?></a>
                                                        <!-- </span> -->
                                                    </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Item Blog Post End -->

    
                    <?php
                        $do = isset($_GET['do']) ? $_GET['do'] : "Manage";
                        if($do == "Manage"){
                    ?>
                            <!-- Single Comment Section Start -->
                            <div class="single-comments">
                                <?php
                                    $getAllComments = "SELECT `cmt_id` as cmt_ID, `comments` as comment_desc, `post_id` as post_ID, 
                                                        `visitor_id` as visitor_ID, `is_parent` as parent, `status` as status_cmt, `cmt_date` as cmt_Date 
                                                        FROM comments WHERE post_id = $thePost AND is_parent = 0 AND status = 1 ORDER BY cmt_id DESC LIMIT 3";
                                    $resComment     = mysqli_query($db,$getAllComments);
                                    $total_comment  = $db->query("SELECT `cmt_id` as cmt_ID, `comments` as comment_desc, `post_id` as post_ID, 
                                                    `visitor_id` as visitor_ID, `is_parent` as parent, `status` as status_cmt, `cmt_date` as cmt_Date 
                                                    FROM comments WHERE post_id = $thePost AND status = 1 ORDER BY cmt_id DESC")->num_rows;//mysqli_num_rows($resComment);
                                ?>
                                        <!-- Comment Heading Start -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>All Latest Comments (<?=$total_comment;?>)</h4>
                                                <div class="title-border"></div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                            </div>
                                        </div>
                                        <!-- Comment Heading End -->
                                <?php
                                    while($rowComment = mysqli_fetch_assoc($resComment)){
                                        extract($rowComment);

                                        $getVisitorInfoSQL = "SELECT `visitor_id` as visitor_idMain , `name` as visitor_name, `email` as visitor_email, 
                                                            `status` as visitor_status, `image` as visitor_image FROM `visitor` WHERE visitor_id = $visitor_ID";
                                        $resVisitor        = mysqli_query($db,$getVisitorInfoSQL);
                                        while($rowVisitor = mysqli_fetch_assoc($resVisitor)){
                                            extract($rowVisitor);
                                    ?>
                                            <!-- Single Comment Post Start -->
                                            <div class="row each-comments">
                                                <div class="col-md-2">
                                                    <!-- Commented Person Thumbnail -->
                                                    <div class="comments-person">
                                                        <?php
                                                            if(!empty($visitor_image)){
                                                        ?>
                                                                <img src="admin/img/visitors/<?=$visitor_image;?>">
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                                <img src="admin/img/visitors/temp_image.jpg">
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-10 no-padding">
                                                    <!-- Comment Box Start -->
                                                    <div class="comment-box">
                                                        <div class="comment-box-header">
                                                            <ul>
                                                                <li class="post-by-name"><?=$visitor_name;?></li>
                                                                <li class="post-by-hour">
                                                                    <?php
                                                                        $timeDiff = time() - strtotime($cmt_Date) ;
                                                                        $hours    = floor($timeDiff / (60*60)); 
                                                                        $minutes  = floor($hours/60);
                                                                        if($minutes > 0 && $hours < 1){
                                                                            echo $minutes . " Minutes ago";
                                                                        }
                                                                        else if($hours < 24 && $hours >= 1){
                                                                            echo $hours . " hours ago";
                                                                        }
                                                                        else if($hours < 24 && $hours >= 1){
                                                                            echo $hours . " hours ago";
                                                                        }
                                                                        else if($hours > 24){
                                                                            echo floor($hours/24) . " Days ago"; 
                                                                        }
                                                                    ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <p><?=$comment_desc;?></p>
                                                    </div>
                                                    <!-- Comment Box End -->
                                                    <?php
                                                        if(isset($_SESSION['visitorID'])){
                                                    ?>
                                                        <div class="btn w-25 justify-content-between">
                                                            <a class="reply-btn" href="#post_comment" type="" onclick="setCommentId(<?=$cmt_ID;?>)" value="">Reply</a>
                                                            <a class="reply-btn" href="#post_comment" type="" onclick="setCommentId(<?=$cmt_ID;?>)" value="">Edit</a>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <!-- Single Comment Post End -->
                                    <?php
                                            $getCommentreplySQl = "SELECT `cmt_id` as cmt_ID_rep, `comments` as comment_desc_rep, `post_id` as post_ID_rep, 
                                                                    `visitor_id` as visitor_ID_rep, `is_parent` as parent_rep, `status` as status_cmt_rep, `cmt_date` as cmt_Date_rep 
                                                                    FROM comments WHERE post_id = $thePost AND is_parent = $cmt_ID AND status = 1";
                                            $resCommentReply    = mysqli_query($db,$getCommentreplySQl);
                                            $reply_count        = mysqli_num_rows($resCommentReply);
                                            if($reply_count > 0){
                                                while($rowReply = mysqli_fetch_assoc($resCommentReply)){
                                                    extract($rowReply);
                                                    $getVisitorInfoReplySQL = "SELECT `visitor_id` as visitor_id_repMain , `name` as visitor_name_rep, `email` as visitor_email_rep, 
                                                                `status` as visitor_status_rep, `image` as visitor_image_rep FROM `visitor` WHERE visitor_id = $visitor_ID_rep";
                                                    $resVisitorRep        = mysqli_query($db,$getVisitorInfoReplySQL);
                                                    while($rowRepVisitor = mysqli_fetch_assoc($resVisitorRep)){
                                                        extract($rowRepVisitor);
                                    ?>
                                                        <!-- Comment Reply Post Start -->
                                                        <div class="row each-comments">
                                                            <div class="col-md-2 offset-md-2">
                                                                <!-- Commented Person Thumbnail -->
                                                                <div class="comments-person">
                                                                    <?php
                                                                        if(!empty($visitor_image_rep)){
                                                                    ?>
                                                                            <img src="admin/img/visitors/<?=$visitor_image_rep;?>">
                                                                    <?php
                                                                        }
                                                                        else{
                                                                    ?>
                                                                            <img src="admin/img/visitors/temp_image.jpg">
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8 no-padding">
                                                                <!-- Comment Box Start -->
                                                                <div class="comment-box">
                                                                    <div class="comment-box-header">
                                                                        <ul>
                                                                            <li class="post-by-name"><?=$visitor_name_rep;?></li>
                                                                            <li class="post-by-hour">
                                                                                <?php
                                                                                    $timeDiff = time() - strtotime($cmt_Date_rep) ;
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
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <p><?=$comment_desc_rep;?></p>
                                                                </div>
                                                                <!-- Comment Box End -->
                                                                <?php
                                                                    if(isset($_SESSION['visitorID'])){
                                                                ?>
                                                                    <div class="btn">
                                                                        <a class="reply-btn" href="#post_comment" onclick="setCommentId(<?=$cmt_ID;?>)" value="">Reply</a>
                                                                        <a class="reply-btn" href="#post_comment" onclick="setCommentId(<?=$cmt_ID;?>)" value="">Edit</a>
                                                                    </div>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- Comment Reply Post End -->
                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                            
                                ?>
                                
                            </div>
                            <!-- Single Comment Section End -->
                            

                            <?php
                                if(isset($_SESSION["visitorID"])){
                            ?>
                                    <!-- Post New Comment Section Start -->
                                    <div class="post-comments" id="post_comment">
                                        <h4>Post Your Comments</h4>
                                        <div class="title-border"></div>
                                        <!-- Form Start -->
                                        <form action="single.php?post=<?=$thePost;?>&do=Insert<?php if(isset($_GET['comment'])){ echo "&comment={$_GET['comment']}";}?>" autocomplete="off" method="POST" class="contact-form">
                                        
                                            <!-- Right Side Start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- Comments Textarea Field -->
                                                    <input type="hidden" name="cmt_idreply" id="cmt_idreply" value="">
                                                    <div class="form-group">
                                                        <textarea name="comments" class="form-input" placeholder="Your Comments Here..." style="resize: none;"></textarea>
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </div>
                                                    <button type="submit" class="btn-main"><i class="fa fa-paper-plane-o"></i> Post Your Comments</button>
                                                </div>
                                            </div>
                                            <!-- Right Side End -->

                                        </form>
                                        <!-- Form End -->
                                    </div>
                                    <!-- Post New Comment Section End -->
                            <?php
                                }
                                else{
                            ?>
                                <div class="alert alert-info">
                                    <p class="text-info font-weight-bold">Please Login or Register to post a comment.</p>
                                </div>
                            <?php
                                }
                        }
                        else if($do == "Insert"){
                            if($_SERVER['REQUEST_METHOD'] == "POST"){
                                $comments  = mysqli_real_escape_string( $db, $_POST['comments'] );
                                $parent    = $_POST['cmt_idreply'];
                                if(isset($parent)){
                                    $insertComment = "INSERT INTO `comments`(`comments`, `post_id`, `visitor_id`, `is_parent`, `status`, `cmt_date`) 
                                                        VALUES ('$comments','$thePost','{$_SESSION['visitorID']}','$parent',0,now())";
                                    $addComment    = mysqli_query($db,$insertComment);
                                    if($addComment){
                                        $_SESSION['update_status'] = "Comment Posted Successfully. Waiting for Admin Approval.";
                                        $_SESSION['type']          = "info";
                                        header("location: single.php?post=$thePost&do=Manage");
                                        exit();
                                    }
                                    else{
                                        echo "<div class='alert alert-danger'>". mysqli_error($db) . "</div>";
                                    }
                                }
                                else{
                                    $insertComment = "INSERT INTO `comments`(`comments`, `post_id`, `visitor_id`, `is_parent`, `status`, `cmt_date`) 
                                                        VALUES ('$comments','$thePost','{$_SESSION['visitorID']}',0,0,now())";
                                    $addComment    = mysqli_query($db,$insertComment);
                                    if($addComment){
                                        header("location: single.php?post=$thePost&do=Manage");
                                    }
                                    else{
                                        echo "<div class='alert alert-danger'>". mysqli_error($db) . "</div>";
                                    }
                                }
                            }
                        }
                    ?>  
                </div>
    <?php
            }
    ?>
                <!-- Blog Right Sidebar -->
                <?php
                    include "inc/sidebar.php";
                ?>
                <!-- Sidebar End -->
            </div>
        </div>
    </section>
    <?php
        }
    ?>

    <!-- ::::::::::: Blog With Right Sidebar End ::::::::: -->
    <script>
        function setCommentId(cmt_Id){
            document.getElementById('cmt_idreply').value = cmt_Id;
        }
    </script>

<?php
    include "inc/footer.php";
?>    
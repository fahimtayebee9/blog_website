<div class="col-md-4">

                    <!-- Latest News -->
                    <div class="widget">
                        <h4>Latest News</h4>
                        <div class="title-border"></div>
                        
                        <!-- Sidebar Latest News Slider Start -->
                        <div class="sidebar-latest-news owl-carousel owl-theme">
                            <?php
                                $sql = "SELECT * FROM post WHERE status = 1 ORDER BY post_id DESC LIMIT 3";
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
                            ?>
                                <!-- First Latest News Start -->
                                <div class="item">
                                    <div class="latest-news">
                                        <!-- Latest News Slider Image -->
                                        <div class="latest-news-image">
                                            <a href="#">
                                                <img src="admin/img/post/<?php echo $image; ?>">
                                            </a>
                                        </div>
                                        <!-- Latest News Slider Heading -->
                                        <h5><a class="recent-title latest-post" href="single.php?post=<?php echo $post_id; ?>"><?=$title;?></a></h5>
                                        <!-- Latest News Slider Paragraph -->
                                        <p><?php  echo substr($description, 0, 180) . "..." ; ?></p>
                                    </div>
                                </div>
                                <!-- First Latest News End -->
                                
                            <?php    
                                }
                            ?>
                        </div>
                        <!-- Sidebar Latest News Slider End -->
                    </div>


                    <!-- Search Bar Start -->
                    <div class="widget"> 
                            <!-- Search Bar -->
                            <h4>Blog Search</h4>
                            <div class="title-border"></div>
                            <div class="search-bar">
                                <!-- Search Form Start -->
                                <form action="search.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="search" placeholder="Search Here" autocomplete="off" class="form-input" required="required">
                                        <input type="submit" name="searchbtn" class="btn-main w-100 mt-3" value="Search">
                                    </div>
                                </form>
                                <!-- Search Form End -->
                            </div>
                    </div>
                    <!-- Search Bar End -->

                    <!-- Recent Post -->
                    <div class="widget">
                        <h4>Recent Posts</h4>
                        <div class="title-border"></div>
                        <div class="recent-post">
                            <?php
                                $sql = "SELECT * FROM post WHERE status = 1 ORDER BY post_id DESC LIMIT 4";
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

                                    $qsql = "select * from users where id='$author_id'";
                                    $userRes = mysqli_query($db, $qsql);
                                    while ( $row = mysqli_fetch_assoc($userRes) ){
                                        $author_name = $row['name'];
                                        $author_image = $row['image'];
                                    }
                            ?>
                                <!-- Recent Post Item Content Start -->
                                <div class="recent-post-item">
                                    <div class="row">
                                        <!-- Item Image -->
                                        <div class="col-md-4">
                                            <img src="admin/img/users/<?php echo $author_image; ?>">
                                        </div>
                                        <!-- Item Tite -->
                                        <div class="col-md-8 no-padding">
                                            <h5><a class="recent-title" href="single.php?post=<?php echo $post_id; ?>"><?=$title;?></a></h5>
                                            <ul>
                                                <li><i class="fa fa-clock-o"></i><?=$post_date;?></li>
                                                <li><i class="fa fa-comment-o"></i>15</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Recent Post Item Content End -->
                            <?php    
                                }
                            ?>
                        </div>
                    </div>

                    <!-- All Category -->
                    <div class="widget">
                        <h4>Blog Categories</h4>
                        <div class="title-border"></div>
                        <!-- Blog Category Start -->
                        <div class="blog-categories">
                            <ul>
                                <!-- Category Item -->
                                <?php
                                    $sql = "SELECT * FROM category WHERE status = 1 AND sub_category = 0 ORDER BY cat_name ASC";
                                    $allCat = mysqli_query($db, $sql);
                                    while ( $row = mysqli_fetch_assoc($allCat) ){
                                        $cat_id     = $row['cat_id'];
                                        $cat_name   = $row['cat_name'];
                                        $cat_desc   = $row['cat_desc'];
                                        $status     = $row['status'];

                                        $qsql = "select * from post where category_id='$cat_id' and status='1'";
                                        $postCountRes = mysqli_query($db, $qsql);
                                        $post_count = mysqli_num_rows($postCountRes);

                                        $journalName = str_replace(' ', '_', $cat_name);
                                        $journalName = str_replace('&', '%', $journalName);

                                        $getSubCategorySql = "SELECT * FROM category where sub_category='$cat_id'";
                                        $result       = mysqli_query($db,$getSubCategorySql);
                                        $rowCount     = mysqli_num_rows($result);
                                        if($rowCount == 0){
                                ?>
                                            <li>
                                                <i class="fa fa-check"></i>
                                                <a class="" href="category.php?category=<?php echo $journalName; ?>"><?php echo $cat_name; ?></a>
                                                <span>[<?=$post_count;?>]</span>
                                            </li>
                                <?php   
                                        }
                                        else{
                                            $total_post =0;
                                            while($rowSub = mysqli_fetch_assoc($result)){
                                                $cat_id_sub = $rowSub['cat_id'];
                                                $cat_name_sub = $rowSub['cat_name'];
                                                $journalName_sub = str_replace(' ', '_', $cat_name_sub);
                                                $journalName_sub = str_replace('&', '%', $journalName_sub);

                                                $qsql_sub = "select * from post where category_id='$cat_id_sub' and status='1'";
                                                $postCountRes_sub = mysqli_query($db, $qsql_sub);
                                                $post_count_sub = mysqli_num_rows($postCountRes_sub);
                                                $total_post += $post_count_sub; 
                                            }
                                ?>
                                            <li>
                                                <i class="fa fa-check"></i>
                                                <a class="" href="category.php?category=<?php echo $journalName; ?>"><?php echo $cat_name; ?></a>
                                                <span>[<?=$total_post;?>]</span>
                                                
                                            </li>
                                <?php
                                        }
                                    }
                                ?>

                            </ul>
                        </div>
                        <!-- Blog Category End -->
                    </div>

                    <!-- Recent Comments -->
                    <div class="widget">
                        <h4>Recent Comments</h4>
                        <div class="title-border">

                        </div>
                        <div class="recent-comments">
                            <?php
                                $getComments = "SELECT * FROM comments ORDER BY cmt_id DESC LIMIT 4";
                                $resultSet   = mysqli_query($db,$getComments);
                                while($rowCmt = mysqli_fetch_assoc($resultSet)){
                            ?>
                                    <!-- Recent Comments Item Start -->
                                    <div class="recent-comments-item">
                                        <div class="row">
                                            <!-- Comments Thumbnails -->
                                            <div class="col-md-4">
                                                <i class="fa fa-comments-o"></i>
                                            </div>
                                            <!-- Comments Content -->
                                            <div class="col-md-8 no-padding">
                                                <?php
                                                    $getVisitorSQl = "SELECT * FROM visitor WHERE visitor_id = '{$rowCmt['visitor_id']}'";
                                                    $resultVisitor = mysqli_query($db,$getVisitorSQl);
                                                    while($rowV = mysqli_fetch_assoc($resultVisitor)){
                                                        $visitorName = $rowV['name'];
                                                    }
                                                ?>
                                                <h5><?=$visitorName;?> on blog posts</h5>
                                                <!-- Comments Date -->
                                                <ul>
                                                    <li>
                                                        <?php
                                                            $upTime_arr = explode(' ',$rowCmt['cmt_date']);
                                                            $upDate_arr = explode('-',$upTime_arr[0]);
                                                            $monthName  = date("F", mktime(0, 0, 0, $upDate_arr[1], 10));
                                                        ?>
                                                        <i class="fa fa-clock-o"></i> <?=substr($monthName,0,3) . " " . $upDate_arr[2] . " , " . $upDate_arr[0];?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Recent Comments Item End -->
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                    <!-- Meta Tag -->
                    <div class="widget">
                        <h4>Tags</h4>
                        <div class="title-border"></div>
                        <!-- Meta Tag List Start -->
                        <div class="meta-tags">
                            <?php
                                $getMetaSql = "SELECT meta FROM post";
                                $resultMeta = mysqli_query($db,$getMetaSql);
                                while($rowMetas = mysqli_fetch_assoc($resultMeta)){
                                    $meta = $rowMetas['meta'];
                                    if(strpos($meta,',')){
                                        $meta_arr = explode(',',$meta);
                                        foreach($meta_arr as $mt){
                            ?>
                                    <span>
                                        <a class="text-light text-decoration-none" href="category.php?meta=<?php echo $mt; ?>"><?php echo strtoupper($mt); ?></a>
                                    </span>
                            <?php
                                        }
                                    }
                                    else{
                            ?>
                                    <span>
                                        <a class="text-light text-decoration-none" href="category.php?meta=<?php echo $meta; ?>"><?php echo strtoupper($meta); ?></a>
                                    </span>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <!-- Meta Tag List End -->
                    </div>

                </div>
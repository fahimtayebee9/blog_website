<?php
    include "inc/header.php";
    
?>

    
    <!-- :::::::::: Page Banner Section Start :::::::: -->
    <section class="blog-bg background-img">
        <div class="container">
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Blog Page</h2>
                    <!-- Page Heading Breadcrumb Start -->
                    <nav class="page-breadcrumb-item">
                        <ol>
                            <li><a href="index.html">Home <i class="fa fa-angle-double-right"></i></a></li>
                            <!-- Active Breadcrumb -->
                            <li class="active">Blog</li>
                        </ol>
                    </nav>
                    <!-- Page Heading Breadcrumb End -->
                </div>
                
            </div>
            <!-- Row End -->
        </div>
    </section>
    <!-- ::::::::::: Page Banner Section End ::::::::: -->

    <?php
        $total_rows = $db->query("SELECT * FROM post WHERE status = 1 ORDER BY post_id DESC")->num_rows;

        $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        $rows_per_page = 4;

        if($statement = $db->prepare("SELECT * FROM post WHERE status = 1 ORDER BY post_id DESC LIMIT ?,?") ){
            $cal_page = ($current_page - 1) * $rows_per_page;
            $statement->bind_param("ii",$cal_page,$rows_per_page);
            $statement->execute();
            $posts_result = $statement->get_result();
        }
    ?>

    <!-- :::::::::: Blog With Right Sidebar Start :::::::: -->
    <section>
        <div class="container">
            <div class="row">
                <!-- Blog Posts Start -->
                <div class="col-md-8">

                    <?php
                        // $sql = "SELECT * FROM post WHERE status = 1 ORDER BY post_id DESC";
                        // $allPost = mysqli_query($db, $sql);
                        while ( $row = mysqli_fetch_assoc($posts_result) ){
                            $post_id        = $row['post_id'];
                            $title          = $row['title'];
                            $description    = $row['description'];
                            $image          = $row['image'];
                            $category_id    = $row['category_id'];
                            $author_id      = $row['author_id'];
                            $status         = $row['status'];
                            $meta           = $row['meta'];
                            $post_date      = $row['post_date'];
                    ?>

                            <!-- Single Item Blog Post Start -->
                            <div class="blog-post">
                                <!-- Blog Banner Image -->
                                <div class="blog-banner">
                                    <a href="single.php?post=<?php echo $post_id; ?>">
                                        <img class="w-100 img-fluid" src="admin/img/post/<?php echo $image; ?>">
                                        <!-- Post Category Names -->
                                        <div class="blog-category-name">
                                            <?php
                                                $sql = "SELECT * FROM category WHERE cat_id = '$category_id'";
                                                $readCat = mysqli_query($db, $sql);
                                                while( $row = mysqli_fetch_assoc($readCat) ){
                                                    $cat_id   = $row['cat_id'];
                                                    $cat_name = $row['cat_name'];
                                                    ?>
                                                    <h6><?php echo $cat_name; ?></h6>
                                            <?php  }
                                            ?>
                                        </div>
                                    </a>
                                </div>
                                <!-- Blog Title and Description -->
                                <div class="blog-description">
                                    <a href="single.php?post=<?php echo $post_id; ?>">
                                        <h3 class="post-title"><?php echo $title; ?></h3>
                                    </a>
                                    <p><?php  echo substr($description, 0, 250) . "..." ; ?></p>
                                    <!-- Blog Info, Date and Author -->
                                    <div class="row" style="margin-top: 25px;">
                                        <div class="col-md-8">
                                            <div class="blog-info">
                                                <ul>
                                                    <li><i class="fa fa-calendar"></i>
                                                    <?php 
                                                        $am_array = ["6","7","8","9","9:30","10","11"];
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
                                                    <!-- <li><i class="fa fa-heart"></i>(50)</li> -->
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-md-4 read-more-btn">
                                            <a href="single.php?post=<?php echo $post_id; ?>" class="btn-main">Read More <i class="fa fa-angle-double-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Item Blog Post End -->



                    <?php    
                        }
                        
                    ?>

                    <?php if( ceil($total_rows / $rows_per_page) > 0) : ?>
                    <nav aria-label="Page navigation example vertical-align-bottom">
                        <ul class="pagination justify-content-center">

                            <!-- PREVIOUS BUTTON -->
                            <?php if($current_page > 1) : ?>
                                <li class="page-item ">
                                    <a class="page-link" href="index.php?page=<?=($current_page-1)?>" tabindex="-1" aria-disabled="true">&laquo;</a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="" tabindex="-1" aria-disabled="true">&laquo;</a>
                                </li>
                            <?php endif;?>

                            <?php if($current_page - 2 > 0) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=<?=($current_page - 2 )?>"><?=($current_page - 2 )?></a></li>
                            <?php endif;?>

                            <?php if($current_page - 1 > 0) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=<?=($current_page - 1 )?>"><?=($current_page - 1 )?></a></li>
                            <?php endif;?>

                            <li class="page-item active"><a class="page-link" href="index.php?page=<?=$current_page?>"><?=$current_page?></a></li>

                            <?php if($current_page + 1 < ceil($total_rows / $rows_per_page) + 1 ) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=<?=($current_page + 1 )?>"><?=($current_page + 1 )?></a></li>
                            <?php endif;?>

                            <?php if($current_page + 2 < ceil($total_rows / $rows_per_page) + 1 ) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=<?=($current_page + 2 )?>"><?=($current_page + 2 )?></a></li>
                            <?php endif;?>
                            
                            <!-- NEXT BUTTON -->
                            <?php if($current_page < ceil($total_rows / $rows_per_page)) : ?>
                                <li class="page-item ">
                                    <a class="page-link" href="index.php?page=<?=($current_page + 1 )?>" tabindex="-1" aria-disabled="true">&raquo;</a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="" tabindex="-1" aria-disabled="true">&raquo;</a>
                                </li>
                            <?php endif;?>
                        </ul>
                    </nav>
                    <?php endif;?>
        
                </div>



                <!-- Blog Right Sidebar -->
                <?php
                    include "inc/sidebar.php";
                ?>
                <!-- Right Sidebar End -->
            </div>
        </div>
    </section>
    <!-- ::::::::::: Blog With Right Sidebar End ::::::::: -->

<?php
    include "inc/footer.php";
?>    
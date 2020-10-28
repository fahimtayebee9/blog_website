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
            <h1 class="m-0 text-dark">Dashboard</h1>
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
        <div class="row">
            <?php
                if (isset( $_GET['edit'] )){ 
                    $editID = $_GET['edit'];
                    
                    $sql = "SELECT * FROM comments WHERE cmt_id = '$editID'";
                    $editCat = mysqli_query($db, $sql);
                    while ( $row = mysqli_fetch_assoc($editCat) ) {
                        $cmt_id     = $row['cmt_id'];
                        $comments   = $row['comments'];
                        $post_id   = $row['post_id'];
                        $status     = $row['status'];
                        $visitor_id     = $row['visitor_id'];
                        $cmt_date     = $row['cmt_date'];
                        $is_parent    = $row['is_parent'];

                        $getVisitorName = "SELECT * FROM visitor WHERE visitor_id = '$visitor_id'";
                        $resVsIn        = mysqli_query($db,$getVisitorName);
                        while($rw = mysqli_fetch_assoc($resVsIn)){
                            $visitor_name = $rw['name'];
                        }

                        $getPost = "SELECT * FROM post WHERE post_id = '$post_id'";
                        $getPostRes = mysqli_query($db,$getPost);
                        while($rwPost = mysqli_fetch_assoc($getPostRes)){
                            $post_title = $rwPost['title'];
                        }
            ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Comments Information</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">
                            <div class="col-md-12">
                                <form action="comments.php?do=Update" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="name">Visitor Name</label>
                                        <input type="text" name="name" class="form-control" disabled autocomplete="off" required="required" id="name" value="<?php echo $visitor_name; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" rows="5" style="resize: none;" disabled name="desc"><?php echo $comments; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Post Title</label>
                                        <input type="text" name="title" class="form-control" disabled autocomplete="off" required="required" id="title" value="<?php echo $post_title; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Comment Date</label>
                                        <?php 
                                            $cmtdate  = $row['cmt_date']; 
                                            $dateArea = explode(' ',$cmtdate);
                                            $date_arr = explode('-',$dateArea[0]);
                                            $cmt_date = $date_arr[2] . " " . substr(date('F', mktime(0, 0, 0, $date_arr[1], 10)),0,3) .", " . $date_arr[0];
                                        ?>
                                        <input type="text" name="cmt_date" class="form-control" disabled autocomplete="off" required="required" id="cmt_date" value="<?php echo $cmt_date; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1">Please Select the Category Status</option>
                                            <option value="1" <?php if ( $status == 1 ){ echo 'selected'; } ?> >Visible</option>
                                            <option value="0" <?php if ( $status == 0 ){ echo 'selected'; } ?> >Hide</option>
                                        </select> 
                                    </div>
                            </div>
                            <div class="col-md-4 m-auto">
                                    <div class="form-group">
                                        <input type="hidden" name="updateID" value="<?php echo $cmt_id; ?>">
                                        <input type="submit" name="updateCategory" class="btn btn-block btn-primary btn-flat" onclick="updateComment(<?=$cmt_id;?>,<?=$is_parent?>)" value="Save Changes">
                                    </div>
                                </form>
                            </div>
                                
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
        <?php
                }                
            }

            $do = isset($_GET['do']) ? $_GET['do'] : "Manage";
            if($do = "Manage"){
        ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage All Comments</h3>
                    </div>
                    <div class="card-body" style="display: block;">
                        
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#Sl.</th>
                                <th scope="col">Image</th>
                                <th scope="col">Visitor Name</th>                                
                                <th scope="col">Comment</th>
                                <th scope="col">Post Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Comment Date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $total_rows = $db->query("SELECT * FROM comments")->num_rows;

                                $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

                                $rows_per_page = 10;

                                if($statement = $db->prepare("SELECT * FROM comments LIMIT ?,?") ){
                                    $cal_page = ($current_page - 1) * $rows_per_page;
                                    $statement->bind_param("ii",$cal_page,$rows_per_page);
                                    $statement->execute();
                                    $allComments = $statement->get_result();
                                }

                                $comment_count = 0;
                                while($comment_count < $total_rows){
                                    
                                    $comment_count++;
                                }
                                if(isset($_SESSION['role']) && $_SESSION['role'] == 1){
                                    $sql = "SELECT * FROM post ORDER BY post_id DESC";
                                }
                                else{
                                    $sql = "SELECT * FROM post WHERE author_id = '{$_SESSION['id']}' ORDER BY post_id DESC";
                                }
                                $allPosts = mysqli_query($db, $sql);
                                $i = 0;
                                while( $row = mysqli_fetch_assoc($allPosts) ){
                                    
                                    $commentsSql    = "SELECT * FROM comments where post_id = '{$row['post_id']}' AND is_parent = 0";
                                    $resComments    = mysqli_query($db,$commentsSql);
                                    while($rowCmt   = mysqli_fetch_assoc($resComments)){
                                        $visitorSql = "SELECT * FROM visitor where visitor_id = {$rowCmt['visitor_id']}";
                                        $resVisitor = mysqli_query($db,$visitorSql);
                                        while($rowVs = mysqli_fetch_assoc($resVisitor)){
                                            $image   = $rowVs['image'];
                                            $name    = $rowVs['name'];
                                        }
                            ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td>
                                                <?php
                                                if ( !empty($image) ){ ?>
                                                    <img src="img/visitors/<?php echo $image; ?>" class="table-img">
                                                <?php }
                                                else{ ?>
                                                    <img src="img/visitors/temp_image.jpg" class="table-img">
                                                <?php }
                                                ?>
                                            </td>
                                            <td><?php echo $name; ?></td>
                                            <td>
                                                <?php
                                                    echo substr($rowCmt['comments'],0,50);
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo substr($row['title'],0,50);
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $rowCmt['status'] == 0 ){ 
                                                ?>
                                                        <span class="badge badge-danger">Hidden</span>
                                                <?php 
                                                    }
                                                    else if ( $rowCmt['status'] == 1 ){ ?>
                                                        <span class="badge badge-success">Visible</span>
                                                <?php 
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $cmtdate = $rowCmt['cmt_date']; 
                                                    $dateArea = explode(' ',$cmtdate);
                                                    $date_arr = explode('-',$dateArea[0]);
                                                    echo $date_arr[2] . " " . substr(date('F', mktime(0, 0, 0, $date_arr[1], 10)),0,3) .", " . $date_arr[0];
                                                ?>
                                            </td>

                                            <td>
                                                <a class="btn btn-info btn-sm" href="comments.php?edit=<?php echo $rowCmt['cmt_id']; ?>" >
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#delete<?php echo $rowCmt['cmt_id']; ?>">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Delete
                                                </a>


                                            </td>
                                        </tr>
                            <?php       
                                        $replySql   = "SELECT * FROM comments WHERE is_parent = {$rowCmt['cmt_id']}";
                                        $resultReply= mysqli_query($db,$replySql);
                                        if(mysqli_num_rows($resultReply) > 0){
                                            while($rowRep = mysqli_fetch_assoc($resultReply)){
                                                $repVisitorSql = "SELECT * FROM visitor where visitor_id = {$rowRep['visitor_id']}";
                                                $repResVisitor = mysqli_query($db,$repVisitorSql);
                                                while($rowRepVisit = mysqli_fetch_assoc($repResVisitor)){
                                                    $image_rep     = $rowRepVisit['image'];
                                                
                                ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td>
                                                    <?php
                                                    if ( !empty($image) ){ ?>
                                                        <img src="img/visitors/<?php echo $image; ?>" class="table-img">
                                                    <?php }
                                                    else{ ?>
                                                        <img src="img/visitors/temp_image.jpg" class="table-img">
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td><?php echo $rowRepVisit['name']; ?></td>
                                                <td>
                                                    <?=substr($rowRep['comments'],0,50);?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo substr($row['title'],0,50);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ( $rowRep['status'] == 0 ){ 
                                                    ?>
                                                            <span class="badge badge-danger">Hidden</span>
                                                    <?php 
                                                        }
                                                        else if ( $rowRep['status'] == 1 ){ ?>
                                                            <span class="badge badge-success">Visible</span>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $cmtdate = $rowRep['cmt_date']; 
                                                        $dateArea = explode(' ',$cmtdate);
                                                        $date_arr = explode('-',$dateArea[0]);
                                                        echo $date_arr[2] . " " . substr(date('F', mktime(0, 0, 0, $date_arr[1], 10)),0,3) .", " . $date_arr[0];
                                                    ?>
                                                </td>
        
                                                <td>
                                                    <a class="btn btn-info btn-sm" href="comments.php?edit=<?php echo $rowRep['cmt_id']; ?>" >
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="comments.php?edit=" data-toggle="modal" data-target="#delete<?php echo  $rowRep['cmt_id']; ?>">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Do you Confirm to delete this Post?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="delete-option text-center">
                                                            <ul>
                                                                <li><a href="post.php?do=Delete&delete=<?php echo $post_id; ?>" class="btn btn-danger">Delete</a></li>
                                                                <li><button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button></li>
                                                            </ul>                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                                    $i++;
                                                }
                                                
                                            }
                                            
                                        }
                                        $i++;
                                    }
                                    $i++;
                                }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6 m-auto justify-content-center">
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
        <?php
            }
            else if($do == "Update"){
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    $comment_id = $_POST['updateID'];
                    $status_up  = $_POST['status'];
                    
                    $success = [];
                    $error   = [];
                    // $updateSQL = "UPDATE `comments` SET `status`= '$status_up' WHERE cmt_id = '$comment_id'";
                    // echo $updateSQL;
                    // $updateRes = mysqli_query($db,$updateSQL);
                    // if($updateRes){
                    //     $success [] = "Comment Updated Successfully";

                    //     $_SESSION['toastr']['message'] = $success;
                    //     $_SESSION['toastr']['message_type'] = "success";
                    //     header("location: comments.php?do=Manage");
                    //     exit();
                    // }
                    // else{
                    //     $error [] = "Comment Not Updated Successfully!!" . mysqli_error($db);
                    //     $_SESSION['toastr']['message'] = $error;
                    //     $_SESSION['toastr']['message_type'] = "error";
                    //     header("location: comments.php?do=Manage");
                    //     exit();
                    // }
                }
                ?>
                    <div class="alert alert-danger">
                        <?=$updateSQL;?>
                    </div>

                    <script>
                        alert("Comment Id : " + <?=$comment_id?> + "\nStatus : " + <?=$status_up?>);
                    </script>
                <?php
            }
        ?>

        </div>
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
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
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage All Visitors</li>
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
                if ( $_SESSION['role']  == 1 ){ ?>
            <?php

                $do = isset( $_GET['do'] ) ? $_GET['do'] : 'Manage';

                if ( $do == 'Manage' ){ ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Manage All Visitors</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#Sl.</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">ID Status</th>
                                            <th scope="col">Join Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                                $total_rows = $db->query("SELECT * FROM visitor")->num_rows;

                                $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

                                $rows_per_page = 10;

                                if($statement = $db->prepare("SELECT * FROM visitor LIMIT ?,?") ){
                                    $cal_page = ($current_page - 1) * $rows_per_page;
                                    $statement->bind_param("ii",$cal_page,$rows_per_page);
                                    $statement->execute();
                                    $visitors_result = $statement->get_result();
                                }
                            ?>

                                <?php
                                    $i = 0;
                                    while( $row = mysqli_fetch_assoc($visitors_result) ){
                                        $id         = $row['visitor_id'];
                                        $name       = $row['name'];
                                        $email      = $row['email'];
                                        $password   = $row['password'];
                                        $status     = $row['status'];
                                        $id_status  = $row['id_status'];
                                        $image      = $row['image'];
                                        $join_date  = $row['join_date'];
                                        $i++;
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
                                        <td><?php echo $email; ?></td>
                                        <td>
                                            <?php
                                                if ( $status == 0 ){ ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php }
                                                else if ( $status == 1 ){ ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ( $id_status == "1" ){ ?>
                                                    <span class="badge badge-warning">New</span>
                                                <?php 
                                                }
                                                else if ( $id_status == "2" ){ ?>
                                                    <span class="badge badge-info">Old</span>
                                                <?php 
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $join_date; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="visitor.php?do=Edit&edit=<?php echo $id; ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                                Edit
                                            </a>

                                            <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#delete<?php echo $id; ?>">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </a>
                                            
                                        </td>
                                    </tr> 

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Do you Confirm to delete this User?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="delete-option text-center">
                                                        <ul>
                                                            <li><a href="visitor.php?do=Delete&delete=<?php echo $id; ?>" class="btn btn-danger">Delete</a></li>
                                                            <li><button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php  
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
                    
                <?php }

                else if ( $do == 'Edit' ){ 
                        if ( isset($_GET['edit']) ){
                        $editID = $_GET['edit'];

                        $sql = "SELECT * FROM visitor WHERE visitor_id = '$editID'";
                        $readUser = mysqli_query($db, $sql);
                        while( $row = mysqli_fetch_assoc($readUser) ){
                            $id         = $row['visitor_id'];
                            $name       = $row['name'];
                            $email      = $row['email'];
                            $password   = $row['password'];
                            $id_status  = $row['id_status'];
                            $status     = $row['status'];
                            $image      = $row['image'];
                            $join_date  = $row['join_date'];
                ?>

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Update User Information</h3>
                                    </div>
                                    <div class="card-body" style="display: block;">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form action="visitor.php?do=Update" method="POST" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label>Full Name</label>
                                                        <input type="text" name="name" class="form-control disabled" disabled required="required" value="<?php echo $name; ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <input type="email" name="email" class="form-control disabled" disabled required="required" value="<?php echo $email; ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" name="password" class="form-control disabled" disabled value="<?=$password?>">
                                                    </div>
                                            </div>

                                            <div class="col-lg-6">

                                                    <div class="form-group">
                                                        <label>Account Status</label>
                                                        <select name="status" class="form-control">
                                                            <option>Please Select User Account Status</option>
                                                            <option value="0" <?php if ( $status == 0 ){ echo 'selected'; } ?> >Inactive</option>
                                                            <option value="1" <?php if ( $status == 1 ){ echo 'selected'; } ?> >Active</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                    <label>Uploaded Image</label>
                                                        <?php
                                                            if ( !empty($image) ){ ?>
                                                                <img src="img/visitors/<?php echo $image; ?>" class="form-img">
                                                            <?php }
                                                            else{
                                                                echo "No Image uploaded";
                                                            }
                                                        ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="hidden" name="updateUserID" value="<?php echo $id; ?>">
                                                        <input type="submit" name="updateUser" class="btn btn-block btn-primary btn-flat" value="Save Changes">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        <?php    
                        }// End while
                    }// End isset if
                } // End Main if
                else if ( $do == 'Update' ){
                    
                    // Update Start
                    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

                        $status       = $_POST['status'];

                        $sql = "UPDATE visitor SET status='$status' WHERE visitor_id = '$updateUserID' ";

                        $addUser = mysqli_query($db, $sql);

                        if ( $addUser )
                        { 
                            header("Location: visitor.php?do=Manage");
                        }
                        else{
                            die("MySQLi Query Failed." . mysqli_error($db));
                        }

                    }
                    // Update End

                    }
                    else if ( $do == 'Delete' ){
                    
                        if (isset($_GET['delete'])){
                            $deleteID = $_GET['delete'];

                            // Delete the Existing Image while Delete the user account
                            $deleteImageSQL = "SELECT * FROM visitor WHERE visitor_id = '$deleteID'";
                            $data = mysqli_query($db, $deleteImageSQL);
                            while( $row = mysqli_fetch_assoc($data) ){
                                $existingImage = $row['image'];
                            }
                            if ( !empty($existingImage) ){
                                unlink('img/visitors/'. $existingImage);
                            }                      

                            // Delete the user data from db
                            $sql = "DELETE FROM visitor WHERE visitor_id = '$deleteID'";
                            $deleteUserData = mysqli_query($db, $sql);

                            if ( $deleteUserData ){
                                header("Location: visitor.php?do=Manage");
                            }
                            else{
                                die("MySQLi Query Failed." . mysqli_error($db));
                            }

                        }

                    }
                ?>
            <?php }
            else{
                echo '<div class="alert alert-warning">Sorry!!! You have no access in this page.</div>';
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


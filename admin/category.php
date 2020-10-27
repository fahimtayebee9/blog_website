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
              <li class="breadcrumb-item active">Manage All Category</li>
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
          <!-- Left Side -->
          <div class="col-lg-5">
            <!-- Add New Category Start -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add New Category</h3>

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
                <form action="" method="POST">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" autocomplete="off" required="required" id="name">
                  </div>
                  
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="desc"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Parent Category</label>
                    <select class="form-control" name="sub_category">
                      <option value="0">Please Select the Parent Category Status</option>
                      <?php
                        $getSubCatSQL = "SELECT * FROM category WHERE sub_category = 0";
                        $result       = mysqli_query($db,$getSubCatSQL);
                        $rowCount     = mysqli_num_rows($result);
                        $printData    = "";
                        if($rowCount > 0){
                            while($rowSub = mysqli_fetch_assoc($result)){
                            $cat_id = $rowSub['cat_id'];
                            $cat_name = $rowSub['cat_name'];
                              $printData .= "<option value='$cat_id'>$cat_name</option>";
                            }
                            echo $printData;
                        } 
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                      <option value="1">Please Select the Category Status</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="addCategory" class="btn btn-block btn-primary btn-flat" value="Add New Category">
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- Add New Category End -->

            <?php
              // Register New Category
              if ( isset($_POST['addCategory']) ){
                $name     = $_POST['name'];
                $desc     = $_POST['desc'];
                $status   = $_POST['status'];
                $sub_category = $_POST['sub_category'];
                $sql = "INSERT INTO category (cat_name, cat_desc, sub_category,status) VALUES ('$name', '$desc', '$sub_category','$status')";

                $AddSuccess = mysqli_query($db, $sql);

                if ( $AddSuccess ){
                  header("Location: category.php");
                }
                else{
                  die("MySQL Connection Faild." . mysqli_error($db));
                }
              }
            ?>
          </div>


          <!-- Right Side -->
          <div class="col-lg-7">

            <!-- Edit Form Start -->
            <?php
              if (isset( $_GET['edit'] )){ 
                $editID = $_GET['edit'];
                
                $sql = "SELECT * FROM category WHERE cat_id = '$editID'";
                $editCat = mysqli_query($db, $sql);
                while ( $row = mysqli_fetch_assoc($editCat) ) {
                  $cat_id     = $row['cat_id'];
                  $cat_name   = $row['cat_name'];
                  $cat_desc   = $row['cat_desc'];
                  $status     = $row['status'];
                  ?>

                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Update Category Information</h3>

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
                      <form action="" method="POST">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" name="name" class="form-control" autocomplete="off" required="required" id="name" value="<?php echo $cat_name; ?>">
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" name="desc"><?php echo $cat_desc; ?></textarea>
                        </div>
                        <div class="form-group">
                          <label>Parent Category</label>
                          <select class="form-control" name="sub_category">
                            <option value="0">Please Select the Parent Category Status</option>
                            <?php
                              $getSubCatSQL = "SELECT * FROM category WHERE sub_category = 0";
                              $result       = mysqli_query($db,$getSubCatSQL);
                              $rowCount     = mysqli_num_rows($result);
                              $printData    = "";
                              if($rowCount > 0){
                                  while($rowSub = mysqli_fetch_assoc($result)){
                                  $cat_id = $rowSub['cat_id'];
                                  $cat_name = $rowSub['cat_name'];
                                    $printData .= "<option value='$cat_id'>$cat_name</option>";
                                  }
                                  echo $printData;
                              } 
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status">
                            <option value="1">Please Select the Category Status</option>
                            <option value="1" <?php if ( $status == 1 ){ echo 'selected'; } ?> >Active</option>
                            <option value="0" <?php if ( $status == 0 ){ echo 'selected'; } ?> >Inactive</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="updateID" value="<?php echo $cat_id; ?>">
                          <input type="submit" name="updateCategory" class="btn btn-block btn-primary btn-flat" value="Save Changes">
                        </div>
                      </form>
                    </div>
              <!-- /.card-body -->
            </div>
              <?php  }                
              }
            ?>

            <?php
              // Update Category Info
              if (isset($_POST['updateCategory'])){
                $name     = $_POST['name'];
                $desc     = $_POST['desc'];
                $status   = $_POST['status'];
                $updateID = $_POST['updateID'];
                $sub_cat  = $_POST['sub_category'];
                $sql = "UPDATE category SET cat_name='$name', cat_desc='$desc', status='$status',sub_category='$sub_cat' WHERE cat_id = '$updateID'";

                $updateSuccess = mysqli_query($db, $sql);

                if ( $updateSuccess ){
                  header("Location: category.php");
                }
                else{
                  die("MySQL Connection Faild." . mysqli_error($db));
                }
              }
            ?>
            <!-- Edit Form End -->



            <!-- All Category Start -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manage All Category</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body p-0" style="display: block;">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 10%">
                                #SL.
                            </th>
                            <th style="width: 20%">
                                Category Name
                            </th>
                            <th style="width: 20%">
                                Status
                            </th>
                            <th style="width: 20%">
                                Parent Category Name 
                            </th>                           
                            <th style="width: 30%">
                              Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                          $total_rows = $db->query("SELECT * FROM category")->num_rows;

                          $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

                          $rows_per_page = 10;

                          if($statement = $db->prepare("SELECT * FROM category LIMIT ?,?") ){
                              $cal_page = ($current_page - 1) * $rows_per_page;
                              $statement->bind_param("ii",$cal_page,$rows_per_page);
                              $statement->execute();
                              $allCat = $statement->get_result();
                          }
                      ?>
                      <?php
                        $i = 0;
                        while ( $row = mysqli_fetch_assoc($allCat) ) {
                          $cat_id     = $row['cat_id'];
                          $cat_name   = $row['cat_name'];
                          $cat_desc   = $row['cat_desc'];
                          $status     = $row['status'];
                          $sub_category     = $row['sub_category'];
                          $i++;
                      ?>

                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $cat_name; ?></td>
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
                                if($sub_category != 0){
                                  $parentCatSql = "SELECT * FROM category WHERE cat_id = '$sub_category'";
                                  $resparent    = mysqli_query($db,$parentCatSql);
                                  while($rowParentx = mysqli_fetch_assoc($resparent)){
                                    $subCat_name = $rowParentx['cat_name'];
                                  }
                                  echo $subCat_name;
                                }
                                else{
                                  echo "None";
                                }
                              ?>
                            </td>
                            
                            <td class="project-actions">
                                <a class="btn btn-info btn-sm" href="category.php?edit=<?php echo $cat_id; ?>">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#delete<?php echo $cat_id; ?>">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>
                            </td>
                        </tr>
<!-- Delete Modal -->
<div class="modal fade" id="delete<?php echo $cat_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Do you Confirm to delete this category?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="delete-option text-center">
          <ul>
            <li><a href="category.php?delete=<?php echo $cat_id; ?>" class="btn btn-danger">Delete</a></li>
            <li><button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

                      <?php  }
                      ?>

                        
                        
                    </tbody>
                </table>
                        <?php if( ceil($total_rows / $rows_per_page) > 0) : ?>
                        <nav aria-label="Page navigation example vertical-align-bottom ">
                            <ul class="pagination justify-content-center mt-3">

                                <!-- PREVIOUS BUTTON -->
                                <?php if($current_page > 1) : ?>
                                    <li class="page-item ">
                                        <a class="page-link" href="category.php?page=<?=($current_page-1)?>" tabindex="-1" aria-disabled="true">&laquo;</a>
                                    </li>
                                <?php else : ?>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="" tabindex="-1" aria-disabled="true">&laquo;</a>
                                    </li>
                                <?php endif;?>

                                <?php if($current_page - 2 > 0) : ?>
                                    <li class="page-item"><a class="page-link" href="category.php?page=<?=($current_page - 2 )?>"><?=($current_page - 2 )?></a></li>
                                <?php endif;?>

                                <?php if($current_page - 1 > 0) : ?>
                                    <li class="page-item"><a class="page-link" href="category.php?page=<?=($current_page - 1 )?>"><?=($current_page - 1 )?></a></li>
                                <?php endif;?>

                                <li class="page-item active"><a class="page-link" href="category.php?page=<?=$current_page?>"><?=$current_page?></a></li>

                                <?php if($current_page + 1 < ceil($total_rows / $rows_per_page) + 1 ) : ?>
                                    <li class="page-item"><a class="page-link" href="category.php?page=<?=($current_page + 1 )?>"><?=($current_page + 1 )?></a></li>
                                <?php endif;?>

                                <?php if($current_page + 2 < ceil($total_rows / $rows_per_page) + 1 ) : ?>
                                    <li class="page-item"><a class="page-link" href="category.php?page=<?=($current_page + 2 )?>"><?=($current_page + 2 )?></a></li>
                                <?php endif;?>
                                
                                <!-- NEXT BUTTON -->
                                <?php if($current_page < ceil($total_rows / $rows_per_page)) : ?>
                                    <li class="page-item ">
                                        <a class="page-link" href="category.php?page=<?=($current_page + 1 )?>" tabindex="-1" aria-disabled="true">&raquo;</a>
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
              <!-- /.card-body -->
            </div>
            <!-- All Category End -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
    // Delete Category Query
    if ( isset( $_GET['delete'] ) ){
      $delete_id = $_GET['delete'];

      $sql = "DELETE FROM category WHERE cat_id = '$delete_id' ";
      $delete_query = mysqli_query($db, $sql);
      if ( $delete_query ){
        header("Location: category.php");
      }
      else{
        die("MySQL Query Failed. " . mysqli_error($db));
      }
    }
  ?>


  <!-- Footer -->
  <?php include "inc/footer.php"; ?>

  <!-- Control Sidebar -->
  <?php include "inc/sidebar.php"; ?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include "inc/script.php"; ?>
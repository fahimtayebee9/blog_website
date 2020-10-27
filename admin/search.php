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
            <h1 class="m-0 text-dark">Search Results</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Search</li>
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
                        if(isset($_GET['action']) && $_GET['action'] == "Search"){
                            if($_SERVER['REQUEST_METHOD'] == "POST"){
                                $text     = $_POST['search'];
                                $text_2   = $_POST['search'];
                                $text_3   = $_POST['search'];
                                $text_4   = $_POST['search'];
                                $text_5   = $_POST['search'];
                                
                                if(!empty($text)){
                                    // CATGEORY DATA
                                    $cat_sql = "SELECT * FROM category WHERE cat_name LIKE '%$text%'";
                                    $res_cat = mysqli_query($db,$cat_sql);
                                    if(mysqli_num_rows($res_cat) != 0){
                        ?>
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title font-weight-bold text-center float-none">Manage All Category</h3>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                    <table class="table">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">
                                                                    #SL.
                                                                </th>
                                                                <th scope="col">
                                                                    Category Name
                                                                </th>
                                                                <th scope="col">
                                                                    Status
                                                                </th>
                                                                <th scope="col">
                                                                    Parent Category Name 
                                                                </th>                           
                                                                <th scope="col">
                                                                    Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $i = 0;
                                                                while ( $row = mysqli_fetch_assoc($res_cat) ) {
                                                                    $cat_id             = $row['cat_id'];
                                                                    $cat_name           = $row['cat_name'];
                                                                    $cat_desc           = $row['cat_desc'];
                                                                    $status             = $row['status'];
                                                                    $sub_category       = $row['sub_category'];
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
                                            
                                <?php                           
                                                                }
                                ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                        <?php
                                    }

                                    // USERS DATA
                                    $user_sql = "SELECT * FROM users WHERE name LIKE '%$text_2%'";
                                    $res_user = mysqli_query($db,$user_sql);
                                    if(mysqli_num_rows($res_user) > 0){
                                ?>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title font-weight-bold text-center float-none">Manage All Users</h3>
                                            </div>
                                            <div class="card-body" style="display: block;">
                                            
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#Sl.</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">User Role</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Join Date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $i = 0;
                                                    while( $row = mysqli_fetch_assoc($res_user) ){
                                                        $id         = $row['id'];
                                                        $name       = $row['name'];
                                                        $email      = $row['email'];
                                                        $password   = $row['password'];
                                                        $address    = $row['address'];
                                                        $phone      = $row['phone'];
                                                        $role       = $row['role'];
                                                        $status     = $row['status'];
                                                        $image      = $row['image'];
                                                        $join_date  = $row['join_date'];
                                                        $i++;
                                                ?>

                                                    <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td>
                                                    <?php
                                                        if ( !empty($image) ){ ?>
                                                        <img src="img/users/<?php echo $image; ?>" class="table-img">
                                                        <?php }
                                                        else{ ?>
                                                        <img src="img/users/default.png" class="table-img">
                                                        <?php }
                                                    ?>

                                                    
                                                    </td>
                                                    <td><?php echo $name; ?></td>
                                                    <td><?php echo $email; ?></td>
                                                    <td><?php echo $address; ?></td>
                                                    <td><?php echo $phone; ?></td>
                                                    <td>
                                                    <?php
                                                        if ( $role == 1 ){ ?>
                                                        <span class="badge badge-success">Super Admin</span>
                                                        <?php }
                                                        else if ( $role == 2 ){ ?>
                                                        <span class="badge badge-primary">Editor</span>
                                                        <?php }
                                                    ?>
                                                    </td>
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
                                                    <td><?php echo $join_date; ?></td>
                                                    <td>
                                                    <a class="btn btn-info btn-sm" href="users.php?do=Edit&edit=<?php echo $id; ?>">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>


                                                    <?php
                                                        if ( $role == 1 ){

                                                        }
                                                        else if ( $role == 2 ){ ?>
                                                        <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#delete<?php echo $id; ?>">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Delete
                                                    </a>
                                                        <?php }
                                                    ?>
                                                    


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
                                                                <li><a href="users.php?do=Delete&delete=<?php echo $id; ?>" class="btn btn-danger">Delete</a></li>
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

                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }

                                    // POST DATA
                                    $sql = "SELECT * FROM post WHERE title LIKE '%$text%'";
                                    $res_post = mysqli_query($db,$sql);
                                    if(mysqli_num_rows($res_post) > 0){
                                ?>
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title font-weight-bold text-center float-none">Manage All Posts</h3>
                                                </div>
                                                <div class="card-body" style="display: block;">
                                                
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">#Sl.</th>
                                                            <th scope="col">Image</th>
                                                            <th scope="col">Title</th>                                
                                                            <th scope="col">Category</th>
                                                            <th scope="col">Author</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Post Date</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php
                                                        $i = 0;
                                                        while( $row = mysqli_fetch_assoc($res_post) ){
                                                            $post_id        = $row['post_id'];
                                                            $title          = $row['title'];
                                                            $description    = $row['description'];
                                                            $image          = $row['image'];
                                                            $category_id    = $row['category_id'];
                                                            $author_id      = $row['author_id'];
                                                            $status         = $row['status'];
                                                            $meta           = $row['meta'];
                                                            $post_date      = $row['post_date'];
                                                            $i++;
                                                        ?>

                                                    <tr>
                                                        <th scope="row"><?php echo $i; ?></th>
                                                        <td>
                                                        <?php
                                                            if ( !empty($image) ){ ?>
                                                            <img src="img/post/<?php echo $image; ?>" class="table-img">
                                                            <?php }
                                                            else{ ?>
                                                            <img src="img/post/default.png" class="table-img">
                                                            <?php }
                                                        ?>

                                                        
                                                        </td>
                                                        <td><?php echo $title; ?></td>
                                                        <td>
                                                        <?php
                                                            $sql = "SELECT * FROM category WHERE cat_id = '$category_id'";
                                                            $readCat = mysqli_query($db, $sql);
                                                            while( $row = mysqli_fetch_assoc($readCat) ){
                                                            $cat_id   = $row['cat_id'];
                                                            $cat_name = $row['cat_name'];
                                                            }
                                                            echo $cat_name;
                                                        ?>
                                                        </td>
                                                        <td>
                                                        <?php
                                                            $sql = "SELECT * FROM users WHERE id = '$author_id'";
                                                            $readUser = mysqli_query($db, $sql);
                                                            while( $row = mysqli_fetch_assoc($readUser) ){
                                                            $id   = $row['id'];
                                                            $name = $row['name'];
                                                            }
                                                            echo $name;
                                                        ?>
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ( $status == 0 ){ ?>
                                                            <span class="badge badge-danger">Draft</span>
                                                            <?php }
                                                            else if ( $status == 1 ){ ?>
                                                            <span class="badge badge-success">Published</span>
                                                            <?php }
                                                        ?>
                                                        </td>
                                                        <td><?php echo $post_date; ?></td>

                                                        <td>
                                                        <a class="btn btn-info btn-sm" href="post.php?do=Edit&edit=<?php echo $post_id; ?>">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                            Edit
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#delete<?php echo $post_id; ?>">
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

                                                    <?php  }
                                                    ?>
                                                    
                                                    </tbody>
                                                </table>

                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                    

                                    // VISITOR DATA
                                    $vis_sql = "SELECT * FROM visitor WHERE name LIKE '%$text_4%'";
                                    $res_vis = mysqli_query($db,$vis_sql);
                                    if(mysqli_num_rows($res_vis) > 0){
                                ?>
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title font-weight-bold text-center float-none">Manage All Visitors</h3>
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
                                                        $i = 0;
                                                        while( $row = mysqli_fetch_assoc($res_vis) ){
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
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                    Edit
                                                                </a>

                                                                <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#delete<?php echo $id; ?>">
                                                                        <i class="fas fa-trash">
                                                                        </i>
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
                                <?php
                                    }
                                    while($row_cat = mysqli_fetch_assoc($res_vis)){

                                    }
                                }
                                else{
                                    $_SESSION['search_warn'] = "Please Type Something to Search";
                                    header("location: dashboard.php");
                                    exit();
                                }
                            }
                        }
                    ?>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <?php
        function posts($text){
            // $post_sql = "";
            // 
            
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
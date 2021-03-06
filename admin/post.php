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
              <li class="breadcrumb-item active">Manage All Post</li>
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

                  $do = isset( $_GET['do'] ) ? $_GET['do'] : 'Manage';

                  if ( $do == 'Manage' ){ ?>
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Manage All Posts</h3>
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
                                if(isset($_SESSION['role']) && $_SESSION['role'] == 1){
                                  $sql = "SELECT * FROM post ORDER BY post_id DESC";
                                }
                                else{
                                  $sql = "SELECT * FROM post WHERE author_id = '{$_SESSION['id']}' ORDER BY post_id DESC";
                                }
                                $allPosts = mysqli_query($db, $sql);
                                $i = 0;
                                while( $row = mysqli_fetch_assoc($allPosts) ){
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
                                <td><?php echo substr($title, 0, 50); ?></td>
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
                                <td>
                                  <?php 
                                    $postDateArr = explode(' ', $post_date);
                                    $datePart_post = explode('-',$postDateArr[0]);
                                    $date_         = $datePart_post[2] . " " . substr(date('F', mktime(0, 0, 0, $datePart_post[1], 10)),0,3) . " ," . $datePart_post[0];
                                    echo $date_;
                                  ?>
                                </td>

                                <td>
                                  <a class="btn btn-info btn-sm" href="post.php?do=Edit&edit=<?php echo $post_id; ?>">
                                      <i class="fas fa-pencil-alt">
                                      </i>
                                      Edit
                                  </a>
                                  <button class="btn btn-danger btn-sm" onclick="deletePost(<?=$post_id?>)">
                                      <i class="fas fa-trash">
                                      </i>
                                      Delete
                                  </button>


                                </td>
                              </tr>

                              <?php  }
                              ?>
                              
                              
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>
                    
                  <?php }
                  else if ( $do == 'Add' ){ ?>
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Add New Post</h3>
                        </div>
                        <div class="card-body" style="display: block;">
                          <div class="row">
                            <div class="col-lg-6">
                              <form action="post.php?do=Insert" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                  <label>Title</label>
                                  <input type="text" name="title" class="form-control" required="required">
                                </div>

                                <?php
                                  if(isset($_SESSION['role']) && $_SESSION['role'] == 1){
                                ?>
                                      <div class="form-group">
                                        <label>Publish Status</label>
                                        <select name="status" class="form-control">
                                          <option>Please Select Post Status</option>
                                          <option value="0">Draft</option>
                                          <option value="1">Published</option>
                                        </select>
                                      </div>
                                <?php
                                  }
                                ?>
                                

                                <div class="form-group" data-select2-id="46">
                                  <label>Meta Tags (Please Press Space to Make a Seperate tag)</label>
                                  <input type="text" onkeyup="" id="meta_tag" name="meta" class="form-control" required="required">
                                </div>

                            </div>

                            <div class="col-lg-6">    
                                <div class="form-group">
                                  <label>Category</label>
                                  <select class="form-control" name="category_id" id="category_id" onchange="getSubCategory()">
                                    <option>Please select the category</option>
                                    <?php
                                      $sql = "SELECT * FROM category WHERE status = 1 AND sub_category = 0 ORDER BY cat_name ASC";
                                      $readCat = mysqli_query($db, $sql);
                                      while( $row = mysqli_fetch_assoc($readCat) ){
                                        $cat_id   = $row['cat_id'];
                                        $cat_name = $row['cat_name'];
                                    ?>
                                        <option value="<?php echo $cat_id; ?>"><?php echo $cat_name; ?></option>
                                    <?php  }
                                    ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label>Sub Category</label>
                                  <select class="form-control" name="sub_id" id="sub_id" disabled>
                                    <option value="0">Please select the category</option>
                                    
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label>Upload Image</label>
                                  <input type="file" name="image" class="form-control-file" required="required">
                                </div>   

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Description</label>
                                  <textarea class="form-control" name="description" rows="15" id="ckeditor"></textarea>
                                  <!-- <textarea class="textarea" placeholder="Place some text here" id="editor" rows="15" name="description"
                                  style="width: 100%; font-size: 14px; resize: none; height: 420px;line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                </div>    
                            </div>

                            <div class="col-md-4 m-auto">
                                <div class="form-group">
                                  <input type="submit" name="addPost" class="btn btn-block btn-primary btn-flat" value="Publish Post">
                                </div>
                              </form>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  <?php }

                  else if ( $do == 'Insert' ){
                    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                      $title            = $_POST['title'];
                      $category_id      = $_POST['category_id'];
                      $sub_cat          = $_POST['sub_id'];
                      if(!empty($_POST['status'])){
                        $status = $_POST['status'];
                      }
                      else{
                        $status = 0;
                      }
                      $meta             = $_POST['meta'];
                      $html_desc        = $_POST['description'];
                      $description      = mysqli_real_escape_string($db, $_POST['description']);
                      $author_id        = $_SESSION['id'];
                      $meta_arr = explode(' ',$meta);
                      $meta_list = implode(',',$meta_arr);

                      // Preapre the Image
                      $imageName    = $_FILES['image']['name'];
                      $imageSize    = $_FILES['image']['size'];
                      $imageTmp     = $_FILES['image']['tmp_name'];

                      $imageAllowedExtension = array("jpg", "jpeg", "png");
                      $exp_arr = explode('.', $imageName);
                      $imageExtension = strtolower( end( $exp_arr ) );
                      
                      $formErrors = [];

                      if ( strlen($title) < 3 ){
                        $formErrors[] = 'Username is too short!!!';
                      }
                      if ( !empty($imageName) ){
                        if ( !empty($imageName) && !in_array($imageExtension, $imageAllowedExtension) ){
                          $formErrors[] = 'Invalid Image Format. Please Upload a JPG, JPEG or PNG image';
                        }
                        if ( !empty($imageSize) && $imageSize > 2097152 ){
                          $formErrors[] = 'Image Size is Too Large! Allowed Image size Max is 2 MB.';
                        }
                      }

                      $countSize = sizeof($formErrors);
                      $count     = 0;
                      while($count < $countSize){
                        echo '<div class="alert alert-warning">' . $formErrors[$count] . '</div>';
                        $count++;
                      }

                      if ( empty($formErrors) ){

                        if ( !empty( $imageName ) ){
                            // Change the Image Name
                            $image = rand(0, 999999) . '_' .$imageName;
                            // Upload the Image to its own Folder Location
                            move_uploaded_file($imageTmp, "img\post\\" . $image );

                            if(!empty($sub_cat) || $sub_cat != 0){
                              $sql = "INSERT INTO post ( title, description, image, category_id, author_id, status, meta, post_date ) VALUES ('$title', '$description', '$image', '$sub_cat', '$author_id', '$status', '$meta_list', now() )";
                            }
                            else{
                              $sql = "INSERT INTO post ( title, description, image, category_id, author_id, status, meta, post_date ) VALUES ('$title', '$description', '$image', '$category_id', '$author_id', '$status', '$meta_list', now() )";
                            }
                            $addPost = mysqli_query($db, $sql);

                            if ( $addPost ){
                              header("Location: post.php?do=Manage");
                            }
                            else{
                              die("MySQLi Query Failed." . mysqli_error($db));
                            }
                        }
                        else{
                          if(!empty($sub_cat) || $sub_cat != 0){
                            $sql = "INSERT INTO post ( title, description, category_id, author_id, status, meta, post_date ) VALUES ('$title', '$description', '$sub_cat', '$author_id', '$status', '$meta_list', now() )";
                          }
                          else{
                            $sql = "INSERT INTO post ( title, description, category_id, author_id, status, meta, post_date ) VALUES ('$title', '$description', '$category_id', '$author_id', '$status', '$meta_list', now() )";
                          }
                            $addUser = mysqli_query($db, $sql);

                            if ( $addUser ){
                              if(!empty($meta)){
                                $meta_tags = explode(' ',$meta);
                                foreach($meta_tags as $mt){
                                  $ins_meta = "INSERT into meta_tags(meta_info) VALUES ('$mt')";
                                  $rs_mtag  = mysqli_query($db,$ins_meta);
                                }
                              }
                              
                              header("Location: post.php?do=Manage");
                            }
                            else{
                              die("MySQLi Query Failed." . mysqli_error($db));
                            }
                        } 
                      }

                    }
                  }

                  else if ( $do == 'Edit' ){ 
                    if ( isset($_GET['edit']) ){
                      $editID = $_GET['edit'];

                      $sql = "SELECT * FROM post WHERE post_id = '$editID'";
                      $readPost     = mysqli_query($db, $sql);
                      while( $row = mysqli_fetch_assoc($readPost) ){
                        $post_id        = $row['post_id'];
                        $title          = $row['title'];
                        $description    = $row['description'];
                        $image          = $row['image'];
                        $category_id    = $row['category_id'];
                        $author_id      = $row['author_id'];
                        $status         = $row['status'];
                        $meta           = $row['meta'];
                        $post_date      = $row['post_date'];

                        $getCatInfo = "SELECT * FROM category WHERE cat_id = '$category_id' OR sub_category='$category_id'";
                        $resCat     = mysqli_query($db,$getCatInfo);
                        while($rowCat = mysqli_fetch_assoc($resCat)){
                          $cat_idFn = $rowCat['cat_id'];
                          $parent_cat = $rowCat['sub_category'];
                        }
                      ?>

                        <div class="col-lg-12">
                          <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">Update Post Information</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                              <div class="row">
                                <div class="col-lg-6">
                                  <form action="post.php?do=Update" method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                      <label>Title</label>
                                      <input type="text" name="title" class="form-control" required="required" value="<?php echo $title; ?>">
                                    </div>

                                    <div class="form-group">
                                      <label>Category</label>
                                      <select class="form-control" name="category_id" id="category_id_edit" onchange="getSubCategory()">
                                        <option value="0">Please select the category</option>
                                        <?php
                                          $sql = "SELECT * FROM category WHERE status = 1 AND sub_category = 0 ORDER BY cat_name ASC";
                                          $readCat = mysqli_query($db, $sql);
                                          while( $row = mysqli_fetch_assoc($readCat) ){
                                            $cat_id   = $row['cat_id'];
                                            $cat_name = $row['cat_name'];
                                            // $parent_cat = $row['sub_category'];
                                        ?>
                                            <option value="<?=$cat_id;?>" 
                                              <?php if($cat_id == $category_id){ echo "selected";}else if($parent_cat == $cat_id){ echo "selected";}?>><?=$cat_name;?></option>
                                        <?php  }
                                        ?>
                                      </select>
                                    </div>

                                    <div class="form-group">
                                      <label>Sub Category</label>
                                      <select class="form-control" name="sub_id" id="sub_id" disabled>
                                        <option value="0">Please Select The Sub Category</option>
                                        <?php
                                          $sql = "SELECT * FROM category WHERE status = 1 AND sub_category != 0 ORDER BY cat_name ASC";
                                          $readCat = mysqli_query($db, $sql);
                                          while( $row = mysqli_fetch_assoc($readCat) ){
                                            $cat_id   = $row['cat_id'];
                                            $cat_name = $row['cat_name'];
                                            // $parent_cat = $row['sub_category'];
                                        ?>
                                            <option value="<?=$cat_id;?>" 
                                              <?php if($cat_id == $category_id){ echo "selected";}else if($parent_cat == $cat_id){ echo "selected";}?>><?=$cat_name;?></option>
                                        <?php  }
                                        ?>
                                      </select>
                                    </div>  
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Publish Status</label>
                                      <select name="status" class="form-control" <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1){ } else{ echo "disabled";}?>>
                                        <option>Please Select Post Status</option>
                                        <option value="0" <?php if ( $status == 0 ){ echo 'selected'; } ?> >Draft</option>
                                        <option value="1" <?php if ( $status == 1 ){ echo 'selected'; } ?> >Published</option>
                                      </select>
                                    </div>

                                    <div class="form-group">
                                      <label>Meta Tags</label>
                                      <?php
                                        $meta_tag = str_replace(',',' ',$meta);
                                      ?>
                                      <input type="text" name="meta" class="form-control text-uppercase" required="required" value="<?php echo $meta_tag; ?>">
                                    </div>

                                    <div class="input-group d-block mb-3">
                                      <label class="d-block">Upload Post Thumbnail</label>
                                      <?php
                                        if ( !empty($image) ){ ?>
                                          <img src="img/post/<?php echo $image; ?>" class="form-img">
                                        <?php }
                                        else{
                                          echo "No Image uploaded";
                                        }
                                      ?>
                                      <div class="custom-file d-block">
                                        <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                      </div>
                                    </div> 
                                </div>

                                <div class="col-lg-12">                                

                                    <div class="form-group">
                                      <label>Description</label>
                                      <textarea class="form-control" id="ckeditor" name="description" rows="15"><?php echo $description; ?></textarea>
                                    </div>

                                </div>
                                <div class="col-md-4 m-auto">

                                    <div class="form-group">
                                      <input type="hidden" name="updatePostID" value="<?php echo $post_id; ?>">
                                      <input type="submit" name="updatePost" class="btn btn-block btn-primary btn-flat" value="Save Changes">
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
                      $updatePostID = $_POST['updatePostID'];
                      $title            = $_POST['title'];
                      $category_id      = $_POST['category_id'];
                      $category_idSub   = $_POST['sub_id'];
                      $status           = $_POST['status'];
                      $meta             = $_POST['meta'];
                      $description      = mysqli_real_escape_string($db,$_POST['description']) ;
                      $metas            = str_replace(' ',',',$meta);
                      $imageName        = $_FILES['image']['name'];

                      if ( !empty($imageName) ){
                        // Preapre the Image
                      // $imageName    = $_FILES['image']['name'];
                      $imageSize    = $_FILES['image']['size'];
                      $imageTmp     = $_FILES['image']['tmp_name'];

                      $imageAllowedExtension = array("jpg", "jpeg", "png");
                      $imageExtension = strtolower( end( explode('.', $imageName) ) );
                      
                      $formErrors = array();

                      if ( strlen($title) < 3 ){
                        // $formErrors = 'Username is too short!!!';
                        array_push($formErrors,'Username is too short!!!');
                      }
                      if ( !empty($imageName) ){
                        if ( !empty($imageName) && !in_array($imageExtension, $imageAllowedExtension) ){
                          array_push($formErrors ,'Invalid Image Format. Please Upload a JPG, JPEG or PNG image');
                        }
                        if ( !empty($imageSize) && $imageSize > 2097152 ){
                          array_push($formErrors , 'Image Size is Too Large! Allowed Image size Max is 2 MB.');
                        }
                      }
                      }

                      // Print the Errors 
                      foreach( $formErrors as $error ){
                        echo '<div class="alert alert-warning">' . $error . '</div>';
                      }

                      if ( empty($formErrors) ){

                        // Upload Image and Change the Password
                        if ( !empty($imageName) ){

                          // Delete the Existing Image while update the new image
                          $deleteImageSQL = "SELECT * FROM post WHERE post_id = '$updatePostID'";
                          $data = mysqli_query($db, $deleteImageSQL);
                          while( $row = mysqli_fetch_assoc($data) ){
                            $existingImage = $row['image'];
                          }
                          unlink('img/post/'. $existingImage);

                          // Change the Image Name
                          $image = rand(0, 999999) . '_' .$imageName;
                          // Upload the Image to its own Folder Location
                          move_uploaded_file($imageTmp, "img\post\\" . $image );

                          if($category_idSub != 0){
                            $sql = "UPDATE post SET title='$title', description='$description', image='$image', category_id='$category_idSub', status='$status', meta='$metas' WHERE post_id = '$updatePostID' ";
                          }
                          else{
                            $sql = "UPDATE post SET title='$title', description='$description', image='$image', category_id='$category_id', status='$status', meta='$metas' WHERE post_id = '$updatePostID' ";
                          }
                          $addUser = mysqli_query($db, $sql);


                          if ( $addUser ){
                            $_SESSION['update_status'] = $sql;
                            $_SESSION['type'] = "success";
                            header("Location: post.php?do=Manage");
                            exit();
                          }
                          else{
                            $_SESSION['update_status'] = "POST NOT UPDATED !!!";
                            $_SESSION['type'] = "error";
                            die("MySQLi Query Failed." . mysqli_error($db));
                            exit();
                          }
                        }

                        // Change the Password Only
                        else if ( empty($imageName) ){

                          if($category_idSub != 0){
                            $sql = "UPDATE post SET title='$title', description='$description', category_id='$category_idSub', status='$status', meta='$metas' WHERE post_id = '$updatePostID' ";
                          }
                          else{
                            $sql = "UPDATE post SET title='$title', description='$description', category_id='$category_id', status='$status', meta='$metas' WHERE post_id = '$updatePostID' ";
                          }

                          $updatePost = mysqli_query($db, $sql);

                          if ( $updatePost ){
                            $_SESSION['update_status'] = "POST UPDATED SUCCESSFULLY!!";
                            $_SESSION['type']          = "success";
                            header("Location: post.php?do=Manage");
                            exit();
                          }
                          else{
                            $_SESSION['update_status'] = "POST NOT UPDATED SUCCESSFULLY!!";
                            $_SESSION['type']          = "error";
                            die("MySQLi Query Failed." . mysqli_error($db));
                            exit();
                          }
                        }
                      }
                      unset($_SESSION['parent_cat']);
                    }
                    // Update End

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

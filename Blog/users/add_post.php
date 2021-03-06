<?php include "includes/user_header.php"; ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/user_navigation.php"; ?>
    <!-- /.navbar-collapse -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php welcome(); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
                        <li class="active"> <i class="fa fa-file"></i> Add Post</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <?php

                if(isset($_SESSION['username'])){
                    $s_username = $_SESSION['username'];
                }
                if(isset($_POST['create_post'])){
                    $post_title = $_POST['post_title'];
                    $post_category_id = $_POST['post_category'];
                    $post_status = 'draft';
                    $post_image = $_FILES['image']['name'];
                    $post_image_temp = $_FILES['image']['tmp_name'];
                    move_uploaded_file($post_image_temp, "../images/post_pic/$post_image");
                    $post_tags = $_POST['post_tags'];
                    $post_content = $_POST['post_content'];
                    $post_date = date('D, F d, Y - h:i:s A');
                    $post_comment_count = 0;
                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$s_username}','{$post_date}','{$post_image}','{$post_content}','{$post_tags}',{$post_comment_count},'{$post_status}') ";

                    $create_post_query = mysqli_query($connection, $query);
                    confirm($create_post_query);
                    $p_id = mysqli_insert_id($connection);

                echo "<div class='alert alert-success'><strong>Success!</strong> Post successfully added. <a href='../post.php?p_id={$p_id}'>View Post</a></div>";
                }
                ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="post_title">Title</label>
                            <input type="text" class="form-control" name="post_title"> </div>
                        <table class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th class="col-sm-2 control-label">Select Category</th>
                                    <th class="col-sm-2 control-label">Post Author</th>
                                    <th class="col-sm-2 control-label">Post Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="post_category" id="" class="form-control">
                                                    <?php
                                            $query = "SELECT * FROM categories";
                                            $select_category = mysqli_query($connection, $query);
                                            confirm($select_category);

                                            while($row = mysqli_fetch_assoc($select_category)){
                                                $cat_title = $row['cat_title'];
                                                $cat_id = $row['cat_id'];
                                                echo "<option value='{$cat_id}'>{$cat_title}</option>";
                                            }
                                            ?>
                                                </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="post_author" id="disabledInput" disabled>
                                                    <option>
                                                        <?php echo $s_username; ?>
                                                    </option>
                                                </select>
                                    </td>
                                    <td>
                                        <select name="post_status" id="" class="form-control" disabled>
                                                    <option value="draft">Draft</option>
                                                </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="post_image">Post Image</label>
                            <input type="file" name="image"> </div>
                        <div class="form-group">
                            <label for="post_tags">Tags</label>
                            <input type="text" class="form-control" name="post_tags"> </div>
                        <div class="form-group">
                            <label for="post_content">Post Content</label><!-- 
                            <script>tinymce.init({ selector:'textarea' });</script> -->
                            <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="btn-group btn-group-lg">
                            <input type="submit" name="create_post" class="btn btn-primary" value="Publish Post"> </div>
                    </form>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php include "includes/user_footer.php" ?>

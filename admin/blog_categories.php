<?php

    include_once 'includes/include.php';

    if ($_SESSION['user_id'] != $admin_id) {
        flag_set('You don\'t have enough permission to reach category page', 'failed');
        redirect('index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['form_name'] == 'add_category') {
            if (empty($_POST['category_title']) || 
                empty($_POST['category_meta_title']) || 
                empty($_POST['category_path'])) {
                flag_set('Please fill out all fields!', 'failed');
                field_set('category_title', $_POST['category_title']);
                field_set('category_meta_title', $_POST['category_meta_title']);
                field_set('category_path', $_POST['category_path']);
                redirect('blog_categories.php');
            }
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];

            // Bind Params
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->create()) {
                flag_set('Create category successfully!');
                redirect('blog_categories.php');
            }

        }

        if ($_POST['form_name'] == 'edit_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->update()) {
                flag_set('Edit category successfully!');
                redirect('blog_categories.php');
            }

        }

        if ($_POST['form_name'] == 'delete_category') {
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            if ($category->delete()) {
                flag_set('Delete category successfully!');
                redirect('blog_categories.php');
            }

        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'partials/meta.php'; ?>
    <?php include_once 'partials/style.php'; ?>

    <!-- Title Page-->
    <title>Blog Categories</title>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php include_once 'partials/sidebar.php'; ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <?php include_once 'partials/header.php'; ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Blog Categories</h2>
                                </div>
                            </div>
                        </div>

                        <?php flag_get(); ?>

                        <div class="row m-t-20">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Add Category</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="">
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">Title</label>
                                                <input type="text" id="title" name="category_title" value="<?php field_get('category_title'); ?>" onfocusout="check_category_title(this.value);" placeholder="Enter title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_title" class="form-control-label">Meta Title</label>
                                                <input type="text" id="meta_title" name="category_meta_title" value="<?php field_get('category_meta_title'); ?>" onfocusout="check_category_title(this.value);" placeholder="Enter meta title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="path" class="form-control-label">Path</label>
                                                <input type="text" id="path" name="category_path" value="<?php field_get('category_path'); ?>" onfocusout="check_category_title(this.value);" placeholder="Enter path" class="form-control">
                                            </div>
                                            <input type="hidden" name="form_name" value="add_category">
                                            <button type="submit" class="btn btn-primary" id="btn_add_category">
                                                <i class="fa fa-plus"></i> Add Category</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Meta Title</th>
                                                <th>Path</th>
                                                <th>Blog Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $category_list = $category->read();
                                                $category_list_count = $category_list->rowCount();
                                                if ($category_list_count > 0):
                                                    while ($category_item = $category_list->fetch()):
                                                        $blog->n_category_id = $category_item['n_category_id'];
                                                        $blog_list = $blog->admin_read_blog_by_category();
                                            ?>
                                            <tr>
                                                <td><?php echo $category_item['n_category_id']; ?></td>
                                                <td><?php echo $category_item['v_category_title']; ?></td>
                                                <td><?php echo $category_item['v_category_meta_title']; ?></td>
                                                <td><?php echo $category_item['v_category_path']; ?></td>
                                                <td><?php echo $blog_list->rowCount(); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.open('../categories.php?id=<?php echo $category_item['n_category_id']; ?>', '_blank')">
                                                        <i class="fa fa-eye"></i> View</button>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-category<?php echo $category_item['n_category_id']; ?>">
                                                        <i class="fa fa-edit"></i> Edit</button>
                                                    <?php if ($blog_list->rowCount() == 0): ?>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-category<?php echo $category_item['n_category_id']; ?>">
                                                        <i class="fa fa-trash"></i> Drop</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    endwhile;
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                        <?php include_once 'partials/footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

            <?php
                $category_list = $category->read();
                $category_list_count = $category_list->rowCount();
                if ($category_list_count > 0):
                    while ($category_item = $category_list->fetch()):
            ?>

			<div class="modal fade" id="edit-category<?php echo $category_item['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title</label>
                                    <input type="text" id="title" name="category_title" placeholder="Enter title" class="form-control" value="<?php echo $category_item['v_category_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="meta_title" class="form-control-label">Meta Title</label>
                                    <input type="text" id="meta_title" name="category_meta_title" placeholder="Enter meta title" class="form-control" value="<?php echo $category_item['v_category_meta_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="path" class="form-control-label">Path</label>
                                    <input type="text" id="path" name="category_path" placeholder="Enter path" class="form-control" value="<?php echo $category_item['v_category_path']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="edit_category">
                                <input type="hidden" name="category_id" value="<?php echo $category_item['n_category_id']; ?>">
                                <button type="submit" class="btn btn-warning">OK</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <div class="modal fade" id="delete-category<?php echo $category_item['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete category with title <b><?php echo $category_item['v_category_title']; ?></b>?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="delete_category">
                                <input type="hidden" name="category_id" value="<?php echo $category_item['n_category_id']; ?>">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <?php
                    endwhile;
                endif;
            ?>

            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include_once 'partials/script.php'; ?>

</body>

</html>
<!-- end document-->

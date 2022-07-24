<?php

    include_once 'include.php';

    $blog->n_user_id = $_SESSION['user_id'];

    if ($blog->admin_read_deleted_blog()->rowCount() == 0) {
        redirect('blogs.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['inactive_blog'])) {
            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->inactive()) {
                flag_set('Restore blog to inactive successfully!');
                redirect();
            }

        }

        if (isset($_POST['active_blog'])) {
            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->active()) {
                flag_set('Restore blog to active blog successfully!');
                redirect();
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
    <title>Deleted Blogs</title>

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
                                    <h2 class="title-1">Deleted Blogs</h2>
                                    <button type="button" class="btn btn-info btn-lg" onclick="location.href='blogs.php'">
                                        <i class="fa fa-arrow-left"></i> Back to Blogs
                                    </button>
                                </div>
                            </div>
                        </div>

                        <?php flag_get(); ?>
                        
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="col-4">Title</th>
                                                <th>Views</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $blog->n_user_id = $_SESSION['user_id'];
                                                $deleted_blog_list = $blog->admin_read_deleted_blog();
                                                $deleted_blog_list_count = $deleted_blog_list->rowCount();
                                                if ($deleted_blog_list_count > 0):
                                                    while ($deleted_blog_item = $deleted_blog_list->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $deleted_blog_item['n_blog_post_id']; ?></td>
                                                <td><?php echo $deleted_blog_item['v_post_title']; ?></td>
                                                <td><?php echo $deleted_blog_item['n_blog_post_views']; ?></td>
                                                <td class="hide">Deleted</td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#restore-blog<?php echo $deleted_blog_item['n_blog_post_id']; ?>">
                                                        <i class="fa fa-undo"></i> Restore</button>
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
                $deleted_blog_list = $blog->admin_read_deleted_blog();
                $deleted_blog_list_count = $deleted_blog_list->rowCount();
                if ($deleted_blog_list_count > 0):
                    while ($deleted_blog_item = $deleted_blog_list->fetch()):
            ?>

			<div class="modal fade" id="restore-blog<?php echo $deleted_blog_item['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Restore Blog</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to restore blog with title <b><?php echo $deleted_blog_item['v_post_title']; ?></b>? Everyone will be able to see your blog on client page.</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="inactive_blog">
                                <input type="hidden" name="blog_id" value="<?php echo $deleted_blog_item['n_blog_post_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="inactive_blog">Restore to inactive blog</button>
                                <button type="submit" class="btn btn-success" name="active_blog">Restore to active blog</button>
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

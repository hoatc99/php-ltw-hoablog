<?php

    include 'includes/include.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['create_inactive_blog'])) {
            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            $blog->n_category_id = $_POST['select_category'];	
            $blog->n_user_id = $_SESSION['user_id'];	
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = upload_image('main_image');
            $blog->v_alt_image_url = upload_image('alt_image');
            $blog->n_blog_post_views = 0;
            $blog->f_post_status = 0;
            $blog->n_home_page_placement = $opt;
            $blog->d_date_created = date('Y-m-d', time());
            $blog->d_time_created = date('h:i:s', time());

            if ($blog->create()) {
                flag_set('Create blog successfully!');
                
                // Write blog tag
                $tag = new Tag($db);
                $tag->n_blog_post_id = $blog->last_id();
                $tag->v_tag = $_POST['blog_tags'];
                $tag->create();

                redirect();
            }
        }

        if (isset($_POST['create_active_blog'])) {
            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            $blog->n_category_id = $_POST['select_category'];	
            $blog->n_user_id = $_SESSION['user_id'];	
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = upload_image('main_image');
            $blog->v_alt_image_url = upload_image('alt_image');
            $blog->n_blog_post_views = 0;
            $blog->f_post_status = 1;
            $blog->n_home_page_placement = $opt;
            $blog->d_date_created = date('Y-m-d', time());
            $blog->d_time_created = date('h:i:s', time());

            if ($blog->create()) {
                flag_set('Create blog successfully!');
                
                // Write blog tag
                $tag = new Tag($db);
                $tag->n_blog_post_id = $blog->last_id();
                $tag->v_tag = $_POST['blog_tags'];
                $tag->create();

                redirect();
            }
        }

        if (isset($_POST['update_blog'])) {

            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            // Params
            $blog->n_blog_post_id = $_POST['blog_id'];	
            $blog->n_category_id = $_POST['select_category'];
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = upload_image('main_image', 'old_main_image');
            $blog->v_alt_image_url = upload_image('alt_image', 'old_alt_image');
            $blog->n_blog_post_views = $_POST['post_view'];	
            $blog->n_home_page_placement = $opt;
            $blog->f_post_status = $_POST['status'];
            $blog->d_date_created = $_POST['date_created'];	
            $blog->d_time_created = $_POST['time_created'];	
            $blog->d_date_updated = date('Y-m-d', time());
            $blog->d_time_updated = date('h:i:s', time());
            
            if ($blog->update()) {
                flag_set('Upload blog successfully!');
                redirect();
            }

        }

        if (isset($_POST['inactive_blog'])) {
            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->inactive()) {
                flag_set('Inactive blog successfully!');
                redirect();
            }

        }

        if (isset($_POST['active_blog'])) {
            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->active()) {
                flag_set('Active blog successfully!');
                redirect();
            }

        }

        if (isset($_POST['delete_blog'])) {
            $tag = new Tag($db);
            $tag->n_blog_post_id = $_POST['blog_id'];
            $tag->delete();

            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->delete()) {
                flag_set('Delete blog successfully!');
                redirect();
            }

        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>

    <!-- Title Page-->
    <title>Blogs</title>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php include 'partials/sidebar.php'; ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <?php include 'partials/header.php'; ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Blogs</h2>
                                    <?php 
                                        $blog->n_user_id = $_SESSION['user_id'];
                                        if ($blog->admin_read_deleted_blog()->rowCount() > 0): 
                                    ?>
                                    <button type="button" class="btn btn-danger btn-lg" onclick="location.href='deleted_blogs.php'">
                                        <i class="fa fa-trash"></i> Go to trash
                                    </button>
                                    <?php endif; ?>
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
                                                $blog_list = $blog->admin_read_active_blog();
                                                $blog_list_count = $blog_list->rowCount();
                                                if ($blog_list_count > 0):
                                                    while ($blog_item = $blog_list->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $blog_item['n_blog_post_id']; ?></td>
                                                <td><?php echo $blog_item['v_post_title']; ?></td>
                                                <td><?php echo $blog_item['n_blog_post_views']; ?></td>
                                                <?php if ($blog_item['f_post_status'] == 1): ?>
                                                <td class="process">Active</td>
                                                <?php elseif ($blog_item['f_post_status'] == 0): ?>
                                                <td class="denied">Inactive</td>
                                                <?php endif; ?>
                                                <td>
                                                    <?php if ($blog_item['f_post_status'] == 1): ?>
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#inactive-blog<?php echo $blog_item['n_blog_post_id']; ?>">
                                                        <i class="fa fa-eye-slash"></i> Inactive</button>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.open('../read_blog.php?id=<?php echo $blog_item['n_blog_post_id']; ?>', '_blank')">
                                                        <i class="fa fa-eye"></i> View</button>
                                                    <?php elseif ($blog_item['f_post_status'] == 0): ?>
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#active-blog<?php echo $blog_item['n_blog_post_id']; ?>">
                                                        <i class="fa fa-eye"></i> Active</button>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="location.href='edit_blog.php?id=<?php echo $blog_item['n_blog_post_id']; ?>'">
                                                        <i class="fa fa-edit"></i> Edit</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-blog<?php echo $blog_item['n_blog_post_id']; ?>">
                                                        <i class="fa fa-trash"></i> Drop</button>
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
                        <?php include 'partials/footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

            <?php
                $blog_list = $blog->read();
                $blog_list_count = $blog_list->rowCount();
                if ($blog_list_count > 0):
                    while ($blog_item = $blog_list->fetch()):
            ?>

			<div class="modal fade" id="inactive-blog<?php echo $blog_item['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Inactive Blog</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to inactive blog with title <b><?php echo $blog_item['v_post_title']; ?></b>? Your blog will be disappeared on client page.</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="inactive_blog">
                                <input type="hidden" name="blog_id" value="<?php echo $blog_item['n_blog_post_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="inactive_blog">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

			<div class="modal fade" id="active-blog<?php echo $blog_item['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Active Blog</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to active blog with title <b><?php echo $blog_item['v_post_title']; ?></b>? Everyone will be able to see your blog on client page.</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="active_blog">
                                <input type="hidden" name="blog_id" value="<?php echo $blog_item['n_blog_post_id']; ?>">
                                <button type="submit" class="btn btn-success" name="active_blog">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

			<div class="modal fade" id="delete-blog<?php echo $blog_item['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Blog</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete blog with title <b><?php echo $blog_item['v_post_title']; ?></b>?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="delete_blog">
                                <input type="hidden" name="main_image" value="<?php echo $blog_item['v_main_image_url']; ?>">
                                <input type="hidden" name="alt_image" value="<?php echo $blog_item['v_alt_image_url']; ?>">
                                <input type="hidden" name="blog_id" value="<?php echo $blog_item['n_blog_post_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_blog">Yes</button>
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

    <?php include 'partials/script.php'; ?>

</body>

</html>
<!-- end document-->

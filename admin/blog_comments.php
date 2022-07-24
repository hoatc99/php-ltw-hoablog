<?php

    include_once 'includes/include.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['delete_comment'])) {
            
            $comment->n_blog_comment_id = $_POST['comment_id'];
            if ($comment->delete_comment()) {
                flag_set('Delete comment successfully!');
                header('Location: blog_comments.php');
                exit();
                // redirect();
            }

        }

        if (isset($_POST['delete_reply'])) {
            
            $comment->n_blog_comment_id = $_POST['reply_id'];
            if ($comment->delete_reply()) {
                flag_set('Delete reply successfully!');
                header('Location: blog_comments.php');
                exit();
                // redirect();
            }

        }

        if (isset($_POST['delete_all_comments'])) {
            
            $comment->n_blog_post_id = $_POST['blog_post_id'];
            if ($comment->delete_all_comments()) {
                flag_set('Delete all comments of blog successfully!');
                header('Location: blog_comments.php');
                exit();
                // redirect();
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
    <title>Blog Comments</title>

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
                                    <h2 class="title-1">Blog Comments</h2>
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
                                                <th>Blog Title</th>
                                                <th>Blog Status</th>
                                                <th class="col-1">Sum Of Comments</th>
                                                <th class="col-5">Action</th>
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
                                            <?php
                                                $comment_list = $comment->read_comment_reply_by_blog_id($blog_item['n_blog_post_id']);
                                                $comment_list_count = $comment_list->rowCount();
                                            ?>
                                            <tr>
                                                <td><?php echo $blog_item['n_blog_post_id']; ?></td>
                                                <td><?php echo $blog_item['v_post_title']; ?></td>
                                                <?php if ($blog_item['f_post_status'] == 1): ?>
                                                <td class="process">Active</td>
                                                <?php elseif ($blog_item['f_post_status'] == 0): ?>
                                                <td class="denied">Inactive</td>
                                                <?php endif; ?>
                                                <td><?php echo $comment_list_count; ?></td>
                                                <td>
                                                    <?php if ($comment_list_count > 0): ?>
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view-blog-comments<?php echo $blog_item['n_blog_post_id']; ?>">
                                                        <i class="fa fa-eye"></i> View</button>
                                                    <?php endif; ?>
                                                    <?php if ($blog_item['f_post_status'] == 1): ?>
                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.open('../read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>#comment', '_blank')">
                                                        <i class="fa fa-expand"></i> Go To</button>
                                                    <?php endif; ?>
                                                    <?php if ($comment_list_count > 0): ?>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-all-comments<?php echo $blog_item['n_blog_post_id']; ?>">
                                                        <i class="fa fa-trash"></i> Delete All</button>
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
                $blog_list = $blog->read();
                $blog_list_count = $blog_list->rowCount();
                if ($blog_list_count > 0):
                    while ($blog_item = $blog_list->fetch()):
            ?>

			<div class="modal fade" id="view-blog-comments<?php echo $blog_item['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel"><?php echo $blog_item['v_post_title']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-danger" role="alert">
                                <span class="badge badge-pill badge-danger">Be careful!</span>
                                Delete comment will also delete all of its replies
                            </div>
                            <?php
                                $comment->n_blog_post_id = $blog_item['n_blog_post_id'];
                                $comment_list = $comment->read_single_blog_post();
                            ?>
                            <div class="modal-body">
                                <ul class="comment-list">
                                    <?php while ($comment_item = $comment_list->fetch()): ?>
                                    <li class="comment">
                                        <div class="vcard bio">
                                            <img src="../images/avatars/person_1.jpg" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">
                                            <h3><?php echo $comment_item['v_comment_author'] ?></h3>
                                            <div class="meta mb-2"><?php echo $comment_item['d_date_created'] . ' ' . $comment_item['d_time_created']; ?></div>
                                            <p><?php echo $comment_item['v_comment'] ?></p>
                                            <form role="form" action="" method="post">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment_item['n_blog_comment_id']; ?>">
                                                <button type="submit" class="delete" name="delete_comment">Delete comment</button>
                                            </form>
                                        </div>
                                        
                                        <?php
                                            $comment->n_blog_comment_id = $comment_item['n_blog_comment_id'];
                                            $reply_list = $comment->read_single_blog_post_reply();  
                                            while ($reply_item = $reply_list->fetch()):
                                        ?>
                                        <ul class="children">
                                            <li class="comment">
                                                <div class="vcard bio">
                                                    <img src="../images/avatars/person_1.jpg" alt="Image placeholder">
                                                </div>
                                                <div class="comment-body">
                                                    <h3><?php echo $reply_item['v_comment_author'] ?></h3>
                                                    <div class="meta mb-2"><?php echo $reply_item['d_date_created'] . ' ' . $reply_item['d_time_created']; ?></div>
                                                    <p><?php echo $reply_item['v_comment'] ?></p>
                                                    <form role="form" action="" method="post">
                                                        <input type="hidden" name="reply_id" value="<?php echo $reply_item['n_blog_comment_id']; ?>">
                                                        <button type="submit" class="delete" name="delete_reply">Delete reply</button>
                                                    </form>
                                                </div>
                                            </li>
                                        </ul>
                                        <?php endwhile; ?>
                                    </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <div class="modal fade" id="delete-all-comments<?php echo $blog_item['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Contact</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete all comments of blog <b><?php echo $blog_item['v_post_title']; ?></b>. This action couldn't be restored?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="blog_post_id" value="<?php echo $blog_item['n_blog_post_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_all_comments">Yes</button>
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

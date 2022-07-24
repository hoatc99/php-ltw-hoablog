<?php

    include_once 'includes/include.php';

    if (isset($_GET['id'])) {

        $blog->n_blog_post_id = $_GET['id'];
        $blog->admin_read_single();

        if ($blog->n_user_id != $_SESSION['user_id'] && $admin_id != $_SESSION['user_id']) {
            flag_set('You don\'t have enough permission to access blog with id = ' . $blog->n_blog_post_id . '!', 'failed');
            header('Location: blogs.php');
            exit();
            // redirect('blogs.php');
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'partials/meta.php'; ?>
    <?php include_once 'partials/style.php'; ?>

    <!-- Title Page-->
    <title>Edit Blog</title>

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
                                    <h2 class="title-1">Edit Blog</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Edit Blog</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" id="title" name="title" value="<?php echo $blog->v_post_title; ?>" placeholder="Enter title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_title">Meta Title</label>
                                                <input type="text" id="meta_title" name="meta_title" value="<?php echo $blog->v_post_meta_title; ?>" placeholder="Enter meta title" class="form-control">
                                            </div>
                                            <?php
                                                $category_list = $category->read();
                                            ?>
                                            <div class="form-group">
                                                <label>Blog Category</label>
                                                <select class="form-control" name="select_category">
                                                    <?php while ($category_item = $category_list->fetch()): ?>
                                                    <option value="<?php echo $category_item['n_category_id']; ?>" <?php echo $category_item['n_category_id'] == $blog->n_category_id ? 'selected' : ''; ?>><?php echo $category_item['v_category_title']; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <br/>
                                                <input type="file" name="main_image">
                                                <?php 
                                                    if ($blog->v_main_image_url != ''):
                                                ?>
                                                <br/>
                                                <img src="../images/upload/<?php echo $blog->v_main_image_url; ?>" width="400px">
                                                <?php
                                                    endif;
                                                ?>
                                                <input type="hidden" name="old_main_image" value="<?php echo $blog->v_main_image_url; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Alt Image</label>
                                                <br/>
                                                <input type="file" name="alt_image">
                                                <?php 
                                                    if ($blog->v_alt_image_url != ''):
                                                ?>
                                                <br/>
                                                <img src="../images/upload/<?php echo $blog->v_alt_image_url; ?>" width="400px">
                                                <?php
                                                    endif;
                                                ?>
                                                <input type="hidden" name="old_alt_image" value="<?php echo $blog->v_alt_image_url; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Summary</label>
                                                <textarea class="form-control" id="summernote_summary" name="blog_summary"><?php echo htmlspecialchars_decode($blog->v_post_summary); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Content</label>
                                                <textarea class="form-control" id="summernote_content" name="blog_content"><?php echo htmlspecialchars_decode($blog->v_post_content); ?></textarea>
                                            </div>
                                            <?php
                                                $tag = new Tag($db);
                                                $tag->n_blog_post_id = $blog->n_blog_post_id;
                                                $tag->read_single();
                                            ?>
                                            <div class="form-group">
                                                <label>Blog Tags <b>(separate by comma)</b></label>
                                                <input class="form-control" name="blog_tags" value="<?php echo $tag->v_tag; ?>" placeholder="Enter tag">
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Path</label>
                                                <input class="form-control" name="blog_path" value="<?php echo $blog->v_post_path; ?>" placeholder="Enter path">
                                            </div>
                                            <div class="form-group">
                                                <label>Home Page Placement</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline1" value="1" <?php echo $blog->n_home_page_placement == 1 ? 'checked' : '' ?>>1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline2" value="2" <?php echo $blog->n_home_page_placement == 2 ? 'checked' : '' ?>>2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline3" value="3" <?php echo $blog->n_home_page_placement == 3 ? 'checked' : '' ?>>3
                                                </label>
                                            </div>
                                            <input type="hidden" name="blog_id" value="<?php echo $blog->n_blog_post_id; ?>">
                                            <input type="hidden" name="date_created" value="<?php echo $blog->d_date_created; ?>">
                                            <input type="hidden" name="time_created" value="<?php echo $blog->d_time_created; ?>">
                                            <input type="hidden" name="post_view" value="<?php echo $blog->n_blog_post_views; ?>">
                                            <input type="hidden" name="status" value="<?php echo $blog->f_post_status; ?>">
                                            <button type="submit" class="btn btn-warning" name="update_blog">
                                                <i class="fa fa-check"></i> OK</button>
                                            <button type="button" class="btn btn-secondary" onclick="location.href='blogs.php'">
                                                <i class="fa fa-chevron-left"></i> Back</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include_once 'partials/footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include_once 'partials/script.php'; ?>

</body>

</html>
<!-- end document-->

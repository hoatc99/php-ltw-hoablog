<?php

    include 'includes/include.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>

    <!-- Title Page-->
    <title>Write A Blog</title>

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
                                    <h2 class="title-1">Write A Blog</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Write A Blog</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" id="title" name="title" placeholder="Enter title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_title">Meta Title</label>
                                                <input type="text" id="meta_title" name="meta_title" placeholder="Enter meta title" class="form-control">
                                            </div>
                                            <?php
                                                $category_list = $category->read();
                                            ?>
                                            <div class="form-group">
                                                <label>Blog Category</label>
                                                <select class="form-control" name="select_category">
                                                    <?php while ($category_item = $category_list->fetch()): ?>
                                                    <option value="<?php echo $category_item['n_category_id']; ?>"><?php echo $category_item['v_category_title']; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <br/>
                                                <input type="file" name="main_image">
                                            </div>
                                            <div class="form-group">
                                                <label>Alt Image</label>
                                                <br/>
                                                <input type="file" name="alt_image">
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea class="form-control" id="summernote_summary" name="blog_summary"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Content</label>
                                                <textarea class="form-control" id="summernote_content" name="blog_content"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Tags <b>(separate by comma)</b></label>
                                                <input class="form-control" name="blog_tags" placeholder="Enter tags">
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Path</label>
                                                <input class="form-control" name="blog_path" placeholder="Enter path">
                                            </div>
                                            <div class="form-group">
                                                <label>Home Page Placement</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline1" value="1">1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline2" value="2">2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline3" value="3">3
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="create_active_blog">Create Active Blog</button>
                                            <button type="submit" class="btn btn-warning" name="create_inactive_blog">Create Inactive Blog</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'partials/footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include 'partials/script.php'; ?>

</body>

</html>
<!-- end document-->

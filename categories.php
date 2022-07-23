<?php  
    include 'admin/includes/include.php';

    if (empty($_GET['id'])) {
        redirect('blogs.php');
    }

    $blog->n_category_id = $_GET['id'];
    $category_blog_list = $blog->client_read_active_blog_by_category();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>HoaBlog - Chuyên mục</title>
    
</head>

<body>

    <?php include 'partials/navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Chuyên mục: <?php echo $current_category_title; ?></h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.html">Trang chủ 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Chuyên mục 
                            <i class="ion-ios-arrow-forward"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php while($category_blog_item = $category_blog_list->fetch()): ?>
                        <div class="col-md-6 ftco-animate">
                            <div class="blog-entry">
                                <a href="read_blog.php?id=<?php echo $category_blog_item['n_blog_post_id'] ?>" class="block-20" style="background-image: url('images/upload/<?php echo $category_blog_item['v_main_image_url'] ?>');"></a>
                                <div class="text d-flex py-4">
                                    <div class="meta mb-3">
                                        <div><a href="#"><?php echo $category_blog_item['d_date_created']; ?></a></div>
                                        <div><a href="#">Admin</a></div>
                                        <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                                    </div>
                                    <div class="desc pl-3">
                                        <h3 class="heading"><a href="read_blog.php?id=<?php echo $category_blog_item['n_blog_post_id'] ?>"><?php echo $category_blog_item['v_post_title']; ?></a></h3>
                                        <p class="blog-summary"><?php echo $category_blog_item['v_post_summary']; ?></p>
                                        <div class="tag-widget post-tag-container">
                                            <div class="tagcloud">
                                                <?php
                                                    $tag->n_blog_post_id = $category_blog_item['n_blog_post_id'];
                                                    $tag->read_single();
                                                    $tag_arr = explode(',', $tag->v_tag);
                                                    foreach ($tag_arr as $tag_element):
                                                        $tag_item = trim($tag_item);
                                                ?>
                                                <a href="search.php?q=<?php echo $tag_element; ?>"><?php echo $tag_element; ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="col-lg-4 sidebar ftco-animate">
                    <?php include 'partials/right_sidebar.php'; ?>
                </div>

            </div>
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>

    <?php include 'partials/script.php'; ?>

</body>

</html>
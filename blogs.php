<?php  
    include "admin/includes/include.php";

    if (!isset($_GET['page']) || empty($_GET['page'])) {
        redirect('blogs.php?page=1');
    }
    $offset = 6;
    $total_page = ceil($blog->client_read_active_blog()->rowCount() / $offset);
    $current_page = $_GET['page'] - 1;
    $blog_from = $current_page * $offset;
    $blog_list = $blog->client_read_active_blog_by_page($blog_from, $offset);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>HoaBlog - Bài viết</title>
    
</head>

<body>

    <?php include 'partials/navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Tất cả bài viết</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.html">Trang chủ 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Bài viết 
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
                        <?php 
                            while($blog_item = $blog_list->fetch()): 
                                $user->n_user_id = $blog_item['n_user_id'];
                                $user->read_single();
                        ?>
                        <div class="col-md-6 ftco-animate">
                            <div class="blog-entry">
                                <a href="read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>" class="block-20" 
                                    style="background-image: url('images/upload/<?php echo $blog_item['v_main_image_url'] ?>');"></a>
                                <div class="text d-flex py-4">
                                    <div class="meta mb-3">
                                        <div><a href="#"><?php echo $blog_item['d_date_created']; ?></a></div>
                                        <div><a href="#"><?php echo $user->v_fullname; ?></a></div>
                                        <div><a href="#"><span class="icon-eye"></span> <?php echo $blog_item['n_blog_post_views']; ?></a></div>
                                        <div><a href="#" class="meta-chat"><span class="icon-chat"></span> <?php echo $comment->read_comment_reply_by_blog_id($blog_item['n_blog_post_id'])->rowCount(); ?></a></div>
                                    </div>
                                    <div class="desc pl-3">
                                        <h3 class="heading"><a href="read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>"><?php echo $blog_item['v_post_title']; ?></a></h3>
                                        <p class="blog-summary"><?php echo $blog_item['v_post_summary']; ?></p>
                                        <div class="tag-widget post-tag-container">
                                            <div class="tagcloud">
                                                <?php
                                                    $tag->n_blog_post_id = $blog_item['n_blog_post_id'];
                                                    $tag->read_single();
                                                    $tag_arr = explode(',', $tag->v_tag);
                                                    foreach ($tag_arr as $tag_element):
                                                        $tag_element = trim($tag_element);
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
                    <div class="row no-gutters my-5">
                        <div class="col text-center">
                            <div class="block-27">
                                <ul>
                                    <?php if ($current_page > 0): ?>
                                    <li><a href="blogs.php?page=<?php echo $current_page; ?>">&lt;</a></li>
                                    <?php endif; ?>
                                    <?php for($i = 0; $i < $total_page; $i++): ?>
                                    <li><a href="blogs.php?page=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></li>
                                    <?php endfor; ?>
                                    <?php if ($current_page < $total_page - 1): ?>
                                    <li><a href="blogs.php?page=<?php echo $current_page+2; ?>">&gt;</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
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
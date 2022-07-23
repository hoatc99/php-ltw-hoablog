<?php  
    include_once 'admin/includes/include.php';

    $blog_list = $blog->client_read_active_blog();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>HoaBlog - Trang chủ</title>

</head>

<body>

    <?php include 'partials/navbar.php'; ?>

    <?php include 'partials/banner.php'; ?>
    
    <?php include 'partials/counter_section.php'; ?>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-2">
                <div class="col-md-4 heading-section ftco-animate">
                    <span class="subheading subheading-with-line"><small class="pr-2 bg-white">Bài viết</small></span>
                    <h2 class="mb-4">Mới nhất</h2>
                </div>
            </div>
            <div class="row">
                <?php 
                    while($blog_item = $blog_list->fetch()): 
                        $user->n_user_id = $blog_item['n_user_id'];
                        $user->read_single();
                        $comment->n_blog_post_id = $blog_item['n_blog_post_id'];
                ?>
                <div class="col-md-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>" class="block-20"
                            style="background-image: url('images/upload/<?php echo $blog_item['v_main_image_url'] ?>');">
                        </a>
                        <div class="text d-flex py-4">
                            <div class="meta mb-3">
                                <div><a href="#"><?php echo $blog_item['d_date_created']; ?></a></div>
                                <div><a href="#"><?php echo $user->v_fullname; ?></a></div>
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
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>

    <?php include 'partials/script.php'; ?>

</body>

</html>
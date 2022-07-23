<?php  
    include "admin/includes/include.php";

    $blog->n_blog_post_id = $_GET['id'];

    $blog->read_single();

    if ($blog->f_post_status != 1) {
        redirect('blogs.php');
    }
    
    $user->n_user_id = $blog->n_user_id;
    $user->read_single();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit_comment'])) {
            $comment->n_blog_comment_parent_id = 0;
            $comment->n_blog_post_id = $_GET['id'];
            $comment->v_comment_author = $_POST['c_name'];
            $comment->v_comment_author_email = $_POST['c_email'];
            $comment->v_comment = $_POST['c_message'];
            $comment->d_date_created = date('y-m-d',time());
            $comment->d_time_created = date('h:i:s',time());
            $comment->create();
            redirect();
        }

        if (isset($_POST['submit_comment_reply'])) {
            $comment->n_blog_comment_parent_id = $_POST['blog_comment_id'];
            $comment->n_blog_post_id = $_GET['id'];
            $comment->v_comment_author = $_POST['c_name_reply'];
            $comment->v_comment_author_email = $_POST['c_email_reply'];
            $comment->v_comment = $_POST['c_message_reply'];
            $comment->d_date_created = date('y-m-d',time());
            $comment->d_time_created = date('h:i:s',time());
            $comment->create();
            redirect();
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>HoaBlog - <?php echo $blog->v_post_title; ?></title>
    
</head>

<body onload="hide_form_reply();">

    <?php include 'partials/navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread"><?php echo $blog->v_post_title; ?></h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.php">Trang chủ 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span class="mr-2">
                            <a href="blogs.php">Bài viết 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>
                            Xem bài viết 
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
                <div class="col-lg-8 ftco-animate">
                    <p>
                        <img src="images/upload/<?php echo $blog->v_main_image_url; ?>" alt="" class="img-fluid">
                    </p>
                    <h2 class="mb-3"><?php echo $blog->v_post_title; ?></h2>
                    <?php echo html_entity_decode($blog->v_post_content); ?>
                    <div class="tag-widget post-tag-container mb-5 mt-5">
                        <div class="tagcloud">
                            <?php
                                $tag->n_blog_post_id = $blog->n_blog_post_id;
                                $tag->read_single();
                                $tag_arr = explode(',', $tag->v_tag);
                                foreach ($tag_arr as $tag_element):
                                    $tag_element = trim($tag_element);
                            ?>
                            <a href="search.php?q=<?php echo $tag_element; ?>"><?php echo $tag_element; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="about-author d-flex p-4 bg-light row">
                        <div class="bio mr-5 col-2">
                            <?php if (!empty($user->v_image)): ?>
                            <img src="images/avatars/<?php echo $user->v_image; ?>" alt="Image placeholder" class="img-fluid mb-4">
                            <?php else: ?>
                            <img src="images/avatars/person_1.jpg" alt="Image placeholder" class="img-fluid mb-4">
                            <?php endif; ?>
                        </div>
                        <div class="desc col-9">
                            <h3><?php echo $user->v_fullname; ?></h3>
                            <p><?php echo html_entity_decode($user->v_message); ?></p>
                        </div>
                    </div>

                    <?php
                        $comment->n_blog_post_id = $_GET['id'];
                        $comment_list = $comment->read_single_blog_post();
                        $num_comment = $comment_list->rowCount();    
                    ?>
                    <div class="pt-5 mt-5" id="comment">
                        <h3 class="mb-5 h4 font-weight-bold"><?php echo $num_comment; ?> bình luận</h3>
                        <ul class="comment-list">
                            <?php while ($comment_item = $comment_list->fetch()): ?>
                            <li class="comment">
                                <div class="vcard bio">
                                    <img src="images/avatars/person_1.jpg" alt="Image placeholder">
                                </div>
                                <div class="comment-body">
                                    <h3><?php echo $comment_item['v_comment_author'] ?></h3>
                                    <div class="meta mb-2"><?php echo $comment_item['d_date_created'] . ' ' . $comment_item['d_time_created']; ?></div>
                                    <p><?php echo $comment_item['v_comment'] ?></p>
                                    <p><a href="#reply" class="reply" onclick="reply_comment(<?php echo $comment_item['n_blog_comment_id']?>)">Trả lời</a></p>
                                </div>
                                
                                <?php
                                    $comment->n_blog_comment_id = $comment_item['n_blog_comment_id'];
                                    $reply_list = $comment->read_single_blog_post_reply();  
                                    while ($reply_item = $reply_list->fetch()):
                                ?>
                                <ul class="children">
                                    <li class="comment">
                                        <div class="vcard bio">
                                            <img src="images/avatars/person_1.jpg" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">
                                            <h3><?php echo $reply_item['v_comment_author'] ?></h3>
                                            <div class="meta mb-2"><?php echo $reply_item['d_date_created'] . ' ' . $reply_item['d_time_created']; ?></div>
                                            <p><?php echo $reply_item['v_comment'] ?></p>
                                        </div>
                                    </li>
                                </ul>
                                <?php endwhile; ?>
                                
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5" id="respond">
                            <h3 class="mb-5 h4 font-weight-bold">Để lại bình luận</h3>
                            <form name="c_form" class="p-5 bg-light" onsubmit="return check_respond()" id="contactForm" method="post" action="" autocomplete="off">
                                <div class="form-group">
                                    <label for="name">Họ và tên</label>
                                    <input type="text" class="form-control" id="name" name="c_name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Địa chỉ email</label>
                                    <input type="email" class="form-control" id="email" name="c_email">
                                </div>
                                <div class="form-group">
                                    <label for="message">Bình luận</label>
                                    <textarea name="c_message" id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Bình luận" class="btn py-3 px-4 btn-primary" name="submit_comment">
                                </div>
                            </form>
                        </div>

                        <div class="comment-form-wrap pt-5" id="reply">
                            <h3 class="mb-5 h4 font-weight-bold">Trả lời: </h3>
                            <form name="c_form_reply" class="p-5 bg-light" onsubmit="return check_reply()" id="contactForm" method="post" action="" autocomplete="off">
                                <div class="form-group">
                                    <label for="name">Họ và tên</label>
                                    <input type="text" class="form-control" id="name" name="c_name_reply">
                                </div>
                                <div class="form-group">
                                    <label for="email">Địa chỉ email</label>
                                    <input type="email" class="form-control" id="email" name="c_email_reply">
                                </div>
                                <div class="form-group">
                                    <label for="message">Lời nhắn</label>
                                    <textarea name="c_message_reply" id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="blog_comment_id">
                                    <input type="submit" value="Trả lời" class="btn py-3 px-4 btn-primary" name="submit_comment_reply">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- .col-md-8 -->

                <div class="col-lg-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <?php 
                            $previous_blog_list = $blog->client_read_previous_blog();
                            if ($previous_blog_list->rowCount() > 0):
                        ?>
                        <h3>Bài viết trước đó</h3>
                        <?php 
                                while($previous_blog_item = $previous_blog_list->fetch()): 
                        ?>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4"
                                style="background-image: url('images/upload/<?php echo $previous_blog_item['v_main_image_url'] ?>');"></a>
                            <div class="text">
                                <h3 class="heading"><a
                                    href="read_blog.php?id=<?php echo $previous_blog_item['n_blog_post_id'] ?>"><?php echo $previous_blog_item['v_post_title']; ?></a>
                                </h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span>
                                        <?php echo $previous_blog_item['d_date_created']; ?></a></div>
                                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                                    <div><a href="#"><span class="icon-eye"></span>
                                        <?php echo $previous_blog_item['n_blog_post_views']; ?></a></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                                endwhile; 
                            endif;
                        ?>

                        <?php 
                            $next_blog_list = $blog->client_read_next_blog();
                            if ($next_blog_list->rowCount() > 0):
                        ?>
                        <h3>Bài viết kế tiếp</h3>
                        <?php 
                                while($next_blog_item = $next_blog_list->fetch()): 
                        ?>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4"
                                style="background-image: url('images/upload/<?php echo $next_blog_item['v_main_image_url'] ?>');"></a>
                            <div class="text">
                                <h3 class="heading"><a
                                    href="read_blog.php?id=<?php echo $next_blog_item['n_blog_post_id'] ?>"><?php echo $next_blog_item['v_post_title']; ?></a>
                                </h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span>
                                        <?php echo $next_blog_item['d_date_created']; ?></a></div>
                                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                                    <div><a href="#"><span class="icon-eye"></span>
                                        <?php echo $next_blog_item['n_blog_post_views']; ?></a></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                                endwhile; 
                            endif;
                        ?>
                    </div>

                    <?php include 'partials/right_sidebar.php'; ?>
                </div>

            </div>
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>

    <?php include 'partials/script.php'; ?>

</body>

</html>
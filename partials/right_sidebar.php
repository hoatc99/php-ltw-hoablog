<div class="sidebar-box ftco-animate">
    <h3>Chuyên mục</h3>
    <ul class="categories">
        <?php
            $category_list = $category->read(); 
            while ($category_item = $category_list->fetch()): 
                $blog->n_category_id = $category_item['n_category_id']; 
                $blog_list = $blog->client_read_active_blog_by_category();
                $num_blog = $blog_list->rowCount();
                if ($num_blog > 0):
        ?>
        <li><a href="categories.php?id=<?php echo $category_item['n_category_id'] ?>">
            <?php echo $category_item['v_category_title'] ?>
            <span><?php echo $num_blog; ?> bài viết</span>
        </a></li>
        <?php
                endif; 
            endwhile; 
        ?>
    </ul>
</div>

<div class="sidebar-box ftco-animate">
    <h3>Bài viết nổi bật</h3>
    <?php 
        $popular_blog_list = $blog->client_read_popular_blog();
        while($popular_blog_item = $popular_blog_list->fetch()): 
            $user->n_user_id = $popular_blog_item['n_user_id'];
            $user->read_single();
            $like->n_blog_post_id = $popular_blog_item['n_blog_post_id'];
            $comment->n_blog_post_id = $popular_blog_item['n_blog_post_id'];
    ?>
    <div class="block-21 mb-4 d-flex">
        <a class="blog-img mr-4"
            style="background-image: url('images/upload/<?php echo $popular_blog_item['v_main_image_url'] ?>');"></a>
        <div class="text">
            <h3 class="heading"><a
                href="read_blog.php?id=<?php echo $popular_blog_item['n_blog_post_id'] ?>"><?php echo $popular_blog_item['v_post_title']; ?></a>
            </h3>
            <div class="meta">
                <div><a href="#"><span class="icon-calendar"></span>
                    <?php echo $popular_blog_item['d_date_created']; ?></a></div>
                <div><a href="#"><span class="icon-person"></span> 
                    <?php echo $user->v_fullname; ?></a></div>
                <div><a href="#"><span class="icon-eye"></span>
                    <?php echo $popular_blog_item['n_blog_post_views']; ?></a></div>
                <div><a href="#"><span class="icon-heart text-danger"></span>
                    <?php echo $like->read()->rowCount(); ?></a></div>
                <div><a href="#"><span class="icon-chat"></span>
                    <?php echo $comment->read_comment_reply_by_blog_id()->rowCount(); ?></a></div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div class="sidebar-box ftco-animate">
    <h3>Bộ sưu tập gắn thẻ</h3>
    <ul class="tagcloud m-0 p-0">
        <?php 
            $tag_list = $tag->read();
            foreach ($tag_list as $tag_item):
                $tag_arr = explode(',', $tag_item['v_tag']);
                foreach ($tag_arr as $tag_element):
                    $tag_element = trim($tag_element);
        ?>
        <a href="search.php?q=<?php echo $tag_element; ?>" class="tag-cloud-link"><?php echo $tag_element; ?></a>
        <?php
                endforeach;
            endforeach;
        ?>
    </ul>
</div>
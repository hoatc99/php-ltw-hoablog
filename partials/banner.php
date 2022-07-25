<section class="home-slider js-fullheight owl-carousel bg-white">
    <?php  
        $banner_list = $blog->client_read_home_page_placement();
        while($banner_item = $banner_list->fetch()):
    ?>
    <div class="slider-item js-fullheight">
        <div class="overlay"></div>
        <div class="container">
            <div class="row d-md-flex no-gutters slider-text js-fullheight align-items-center justify-content-end"
                data-scrollax-parent="true">
                <div class="one-third order-md-last img js-fullheight" style="background-image: url('images/upload/<?php echo $banner_item['v_main_image_url'] ?>');">
                    <h3 class="vr"><?php echo $banner_item['d_date_created']; ?></h3>
                </div>
                <div class="one-forth d-flex js-fullheight align-items-center ftco-animate"
                    data-scrollax=" properties: { translateY: '70%' }">
                    <div class="text">
                        <h1 class="mb-4"><?php echo $banner_item['v_post_title'] ?></h1>
                        <p><a href="read_blog.php?id=<?php echo $banner_item['n_blog_post_id']?>" class="btn btn-primary px-4 py-3 mt-3">Xem bài viết</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</section>
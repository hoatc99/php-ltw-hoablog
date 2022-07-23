<?php 
    if (empty($_SESSION['client_id'])) {
        $_SESSION['client_id'] = session_id();
        file_put_contents('admin/sum_of_visits.txt', (int)file_get_contents('admin/sum_of_visits.txt') + 1);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email']) != "") {
            $subscriber->v_sub_email = $_POST['email'];
            $subscriber->d_date_created = date('y-m-d',time());
            $subscriber->d_time_created = date('h:i:s',time());
            $subscriber->f_sub_status = 1;
            if ($subscriber->create()) {
                redirect();
            }
        }
    }
    
    $category_list = $category->read();
?>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">HoaBlog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Trang chủ</a></li>
                <li class="nav-item has-children">
                    <a href="#" class="nav-link">Chuyên mục</a>
                    <ul class="sub-menu">
                        <?php 
                            while ($category_item = $category_list->fetch()): 
                                $blog->n_category_id = $category_item['n_category_id'];
                                if ($blog->client_read_active_blog_by_category()->rowCount() > 0):
                        ?>
                        <li><a href="categories.php?id=<?php echo $category_item['n_category_id']; ?>">
                            <?php echo $category_item['v_category_title']; ?>
                        </a></li>
                        <?php 
                            if (isset($_GET['id']) && $category_item['n_category_id'] == $_GET['id']):
                                $current_category_title = $category_item['v_category_title']; 
                            endif;
                        ?>
                        <?php 
                                endif;
                            endwhile; 
                        ?>
                    </ul>
                </li>
                <li class="nav-item"><a href="blogs.php" class="nav-link">Bài viết</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">Về chúng tôi</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Liên hệ</a></li>
                <li class="nav-item">
                    <form action="search.php" id="search-form" method="get">
                        <input type="text" class="search-field" placeholder="Tìm kiếm..." name="q" autocomplete="off">
                        <button type="submit" class="search-submit"><span class="icon-search"></span></button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->
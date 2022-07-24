<?php 
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
        // redirect('login.php');
    }
?>

<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="index.html">
                    <img src="images/icon/logo.png" alt="CoolAdmin" />
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li>
                    <a href="index.php">
                        <i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="blogs.php">
                        <i class="fas fa-list"></i>Blogs</a>
                </li>
                <li>
                    <a href="write_a_blog.php">
                        <i class="fas fa-pencil-square"></i>Write A Blog</a>
                </li>
                <li>
                    <a href="blog_comments.php">
                        <i class="fas fa-comments"></i>Blog Comments</a>
                </li>
                <?php if ($_SESSION['user_id'] == $admin_id): ?>
                <li>
                    <a href="blog_categories.php">
                        <i class="fas fa-book"></i>Blog Categories</a>
                </li>
                <li>
                    <a href="blog_contacts.php">
                        <i class="fas fa-star"></i>Blog Contacts</a>
                </li>
                <li>
                    <a href="blog_subscribers.php">
                        <i class="fas fa-group"></i>Blog Subscribers</a>
                </li>
                <li>
                    <a href="blog_users.php">
                        <i class="fas fa-user"></i>Blog Users</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="index.php">
            <img src="images/icon/logo.png" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li>
                    <a href="index.php">
                        <i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="blogs.php">
                        <i class="fas fa-list"></i>Blogs</a>
                </li>
                <li>
                    <a href="write_a_blog.php">
                        <i class="fas fa-pencil-square"></i>Write A Blog</a>
                </li>
                <li>
                    <a href="blog_comments.php">
                        <i class="fas fa-comments"></i>Blog Comments</a>
                </li>
                <?php if ($_SESSION['user_id'] == $admin_id): ?>
                <li>
                    <a href="blog_categories.php">
                        <i class="fas fa-book"></i>Blog Categories</a>
                </li>
                <li>
                    <a href="blog_contacts.php">
                        <i class="fas fa-star"></i>Blog Contacts</a>
                </li>
                <li>
                    <a href="blog_subscribers.php">
                        <i class="fas fa-group"></i>Blog Subscribers</a>
                </li>
                <li>
                    <a href="blog_users.php">
                        <i class="fas fa-user"></i>Blog Users</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
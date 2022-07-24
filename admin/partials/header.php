<?php 

    $user->n_user_id = $_SESSION['user_id'];
    $user->read_single();

    $notification->n_user_id = $_SESSION['user_id'];
    $notification_list = $notification->read();

?>

<!-- HEADER DESKTOP-->
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST"></form>
                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item js-item-menu">
                            <i class="zmdi zmdi-notifications"></i>
                            <span class="quantity"><?php echo $notification_list->rowCount(); ?></span>
                            <div class="notifi-dropdown js-dropdown">
                                <div class="notifi__title">
                                    <p>You have <?php echo $notification_list->rowCount(); ?> Notifications</p>
                                </div>
                                <?php 
                                    if ($notification_list->rowCount() > 0):
                                        while ($notification_item = $notification_list->fetch()):
                                ?>
                                <div class="notifi__item">
                                    <div class="bg-c1 img-cir img-40">
                                        <i class="zmdi zmdi-email-open"></i>
                                    </div>
                                    <div class="content">
                                        <p><?php echo $notification_item['v_message']; ?></p>
                                        <span class="date"><?php echo $notification_item['d_date_created'] . ' ' . $notification_item['d_time_created']; ?></span>
                                    </div>
                                </div>
                                <?php 
                                        endwhile;
                                    endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <?php if (!empty($user->v_image)): ?>
                                <img src="../images/avatars/<?php echo $user->v_image; ?>" class="img-fluid mb-4">
                                <?php else: ?>
                                <img src="../images/icon/avatar-01.jpg" class="img-fluid mb-4">
                                <?php endif; ?>
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#"><?php echo $user->v_fullname; ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <?php if (!empty($user->v_image)): ?>
                                            <img src="../images/avatars/<?php echo $user->v_image; ?>" class="img-fluid mb-4">
                                            <?php else: ?>
                                            <img src="../images/icon/avatar-01.jpg" class="img-fluid mb-4">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#"><?php echo $user->v_fullname; ?></a>
                                        </h5>
                                        <span class="email"><?php echo $user->v_email; ?></span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="edit_user_profile.php">
                                            <i class="zmdi zmdi-account"></i>User Infomation</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="logout.php">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER DESKTOP-->
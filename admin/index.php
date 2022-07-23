<?php

    include 'includes/include.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>

    <!-- Title Page-->
    <title>Dashboard</title>

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
                                    <h2 class="title-1">Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        
                        <?php flag_get(); ?>
                
                        <div class="row m-t-30 m-b-40">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-blogger"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $blog->read()->rowCount(); ?></h2>
                                                <span>Blogs</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $subscriber->read()->rowCount(); ?></h2>
                                                <span>Subscribers</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-phone"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $contact->read()->rowCount(); ?></h2>
                                                <span>Contacts</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-google-maps"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo file_get_contents('sum_of_visits.txt'); ?></h2>
                                                <span>Sum Of Visits</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'partials/footer.php'; ?>
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

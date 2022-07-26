<?php

    include_once 'include.php';
    include_once 'includes/check_login.php';

    if ($_SESSION['user_id'] != $admin_id) {
        flag_set('You don\'t have enough permission to reach subscriber page', 'failed');
        redirect('index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['delete_subscriber'])) {
            
            $subscriber->n_sub_id = $_POST['sub_id'];
            if ($subscriber->delete()) {
                flag_set('Delete subscriber successfully!');
                redirect();
            }

        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'partials/meta.php'; ?>
    <?php include_once 'partials/style.php'; ?>

    <!-- Title Page-->
    <title>Blog Subscribers</title>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php include_once 'partials/sidebar.php'; ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <?php include_once 'partials/header.php'; ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Blog Subscribers</h2>
                                </div>
                            </div>
                        </div>
                        
                        <?php flag_get(); ?>
                        
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table id="dataTables" class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th class="col-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $subscriber_list = $subscriber->read();
                                                $subscriber_list_count = $subscriber_list->rowCount();
                                                if ($subscriber_list_count > 0):
                                                    while ($subscriber_item = $subscriber_list->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $subscriber_item['n_sub_id']; ?></td>
                                                <td><?php echo $subscriber_item['v_sub_email']; ?></td>
                                                <td><?php echo $subscriber_item['d_date_created']; ?></td>
                                                <td><?php echo $subscriber_item['d_time_created']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-subscriber<?php echo $subscriber_item['n_sub_id']; ?>">
                                                        <i class="fa fa-trash"></i> Drop</button>
                                                </td>
                                            </tr>
                                            <?php
                                                    endwhile;
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                        <?php include_once 'partials/footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

            <?php
                $subscriber_list = $subscriber->read();
                $subscriber_list_count = $subscriber_list->rowCount();
                if ($subscriber_list_count > 0):
                    while ($subscriber_item = $subscriber_list->fetch()):
            ?>

			<div class="modal fade" id="delete-subscriber<?php echo $subscriber_item['n_sub_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Subscriber</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete subscriber with email <b><?php echo $subscriber_item['v_sub_email']; ?></b>?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="sub_id" value="<?php echo $subscriber_item['n_sub_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_subscriber">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <?php
                    endwhile;
                endif;
            ?>

            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include_once 'partials/script.php'; ?>

</body>

</html>
<!-- end document-->

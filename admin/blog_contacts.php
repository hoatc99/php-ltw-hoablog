<?php

    include_once 'include.php';
    include_once 'includes/check_login.php';

    if ($_SESSION['user_id'] != $admin_id) {
        flag_set('You don\'t have enough permission to reach contact page', 'failed');
        redirect('index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['delete_contact'])) {
            
            $contact->n_contact_id = $_POST['contact_id'];
            if ($contact->delete()) {
                flag_set('Delete contact successfully!');
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
    <title>Blog Contacts</title>

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
                                    <h2 class="title-1">Blog Contacts</h2>
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
                                                <th>Fullname</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th class="col-4">Message</th>
                                                <th class="col-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $contact_list = $contact->read();
                                                $contact_list_count = $contact_list->rowCount();
                                                if ($contact_list_count > 0):
                                                    while ($contact_item = $contact_list->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $contact_item['n_contact_id']; ?></td>
                                                <td><?php echo $contact_item['v_fullname']; ?></td>
                                                <td><?php echo $contact_item['v_email']; ?></td>
                                                <td><?php echo $contact_item['v_phone']; ?></td>
                                                <td><?php echo $contact_item['v_message']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-contact<?php echo $contact_item['n_contact_id']; ?>">
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
                $contact_list = $contact->read();
                $contact_list_count = $contact_list->rowCount();
                if ($contact_list_count > 0):
                    while ($contact_item = $contact_list->fetch()):
            ?>

			<div class="modal fade" id="delete-contact<?php echo $contact_item['n_contact_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Contact</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete contact with name <b><?php echo $contact_item['v_fullname']; ?></b>?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="contact_id" value="<?php echo $contact_item['n_contact_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_contact">Yes</button>
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

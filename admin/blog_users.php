<?php

    include_once 'include.php';

    if ($_SESSION['user_id'] != $admin_id) {
        flag_set('You don\'t have enough permission to reach user page', 'failed');
        redirect('index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['reset_password'])) {
            
            $user->n_user_id = $_POST['user_id'];
            $user->v_password = md5($_POST['password']);

            if ($user->reset_password()) {
                flag_set('Reset password for user with id = ' . $_POST['user_id'] . ' successfully!');
                redirect();
            }

        }

        if (isset($_POST['disable_user'])) {
            
            $user->n_user_id = $_POST['user_id'];

            if ($user->disable()) {
                flag_set('Disable user with id = ' . $_POST['user_id'] . ' successfully!');
                redirect();
            }

        }

        if (isset($_POST['enable_user'])) {
            
            $user->n_user_id = $_POST['user_id'];

            if ($user->enable()) {
                flag_set('Enable user with id = ' . $_POST['user_id'] . ' successfully!');
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
    <title>Blog Users</title>

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
                                    <h2 class="title-1">Blog Users</h2>
                                </div>
                            </div>
                        </div>
                        
                        <?php flag_get(); ?>
                        
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Fullname</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $user_list = $user->read();
                                                $user_list_count = $user_list->rowCount();
                                                if ($user_list_count > 0):
                                                    while ($user_item = $user_list->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $user_item['n_user_id']; ?></td>
                                                <td><?php echo $user_item['v_username']; ?></td>
                                                <td><?php echo $user_item['v_fullname']; ?></td>
                                                <td><?php echo $user_item['v_phone']; ?></td>
                                                <td><?php echo $user_item['v_email']; ?></td>
                                                <?php if ($user_item['f_user_status'] == 1): ?>
                                                <td class="process">Enabled</td>
                                                <?php elseif ($user_item['f_user_status'] == 0): ?>
                                                <td class="denied">Disabled</td>
                                                <?php endif; ?>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#reset-password<?php echo $user_item['n_user_id']; ?>">
                                                        <i class="fa fa-key"></i> RS Pass</button>
                                                    <?php 
                                                        if ($admin_id != $user_item['n_user_id']):
                                                            if ($user_item['f_user_status'] == 1): ?>
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#disable-user<?php echo $user_item['n_user_id']; ?>">
                                                        <i class="fa fa-lock"></i> Disable</button>
                                                    <?php 
                                                            elseif ($user_item['f_user_status'] == 0): 
                                                    ?>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#enable-user<?php echo $user_item['n_user_id']; ?>">
                                                        <i class="fa fa-lock-open"></i> Enable</button>
                                                    <?php 
                                                            endif; 
                                                        endif; 
                                                    ?>
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
                $user_list = $user->read();
                $user_list_count = $user_list->rowCount();
                $i = 0;
                if ($user_list_count > 0):
                    while ($user_item = $user_list->fetch()):
                        
            ?>

			<div class="modal fade" id="reset-password<?php echo $user_item['n_user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Reset password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Username</label>
                                    <input type="text" name="username" value="<?php echo $user_item['v_username']; ?>" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="form-control-label">New Password</label>
                                    <label id="password_message<?php echo $i; ?>" class="message"></label>
                                    <input type="password" name="password" oninput="check_password(this.value, repassword.value, <?php echo $i; ?>);" placeholder="Enter new password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Re-enter New Password</label>
                                    <label id="repassword_message<?php echo $i; ?>" class="message"></label>
                                    <input type="password" name="repassword" oninput="check_password(password.value, this.value, <?php echo $i; ?>);" placeholder="Re-enter new password" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="<?php echo $user_item['n_user_id']; ?>">
                                <button type="submit" id="btn_reset_password<?php echo $i; ?>" class="btn btn-warning" name="reset_password" disabled>Reset password</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <div class="modal fade" id="disable-user<?php echo $user_item['n_user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Disable user</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to disable user with username <b><?php echo $user_item['v_username']; ?></b>? This user can't login in future.</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="<?php echo $user_item['n_user_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="disable_user">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <div class="modal fade" id="enable-user<?php echo $user_item['n_user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Enable user</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to enable user with username <b><?php echo $user_item['v_username']; ?></b>? This user will able to login and create blog in future.</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="user_id" value="<?php echo $user_item['n_user_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="enable_user">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
            <?php  
                        $i++;
                    endwhile;
                endif;
            ?>

            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include_once 'partials/script.php'; ?>

    <script>

        const check_password = (password, repassword, number) => {
            if (password == '') {
                $('#password_message' + number).text('Please enter a password');
                $('#btn_reset_password' + number).prop('disabled', true);
            } else if (repassword == '') {
                $('#repassword_message' + number).text('Please re-enter a password');
                $('#btn_reset_password' + number).prop('disabled', true);
            } else if (password != repassword) {
                $('#password_message' + number).text('Password is not match');
                $('#btn_reset_password' + number).prop('disabled', true);
            } else {
                $('#password_message' + number).text('');
                $('#repassword_message' + number).text('');
                $('#btn_reset_password' + number).prop('disabled', false);
            }
        }

    </script>

</body>

</html>
<!-- end document-->

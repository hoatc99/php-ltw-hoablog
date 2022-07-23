<?php

    include_once 'includes/include.php';

    $user->n_user_id = $_SESSION['user_id'];
    $user->read_single();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['change_password'])) {

            if (md5($_POST['old_password']) != $user->v_password || 
                $_POST['password'] == '' || $_POST['repassword'] == '' || $_POST['password'] != $_POST['repassword']) {
                flag_set('Change password failed, please check again.', 'failed');
                redirect('edit_user_profile.php');
            }

            $user->v_password = md5($_POST['password']);

            if ($user->reset_password()) {
                flag_set('Change password successfully!');
                redirect('edit_user_profile.php');
            }

        }

        if (isset($_POST['update_user_profile'])) {

            if (md5($_POST['current_password']) != $user->v_password) {
                flag_set('Update user profile failed! Current password is wrong, please check again.', 'failed');
                redirect('edit_user_profile.php');
            }

            $user->v_fullname = $_POST['name'];
            $user->v_email = $_POST['email'];
            $user->v_phone = $_POST['phone'];
            $user->v_image = upload_image('image_profile', 'old_image_profile', '../images/avatars/');
            $user->v_message = $_POST['about'];

            if ($user->update()) {
                flag_set('Update user profile successfully!');
                redirect('edit_user_profile.php');
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
    <title>Edit User Profile</title>

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
                                    <h2 class="title-1">Edit User Profile</h2>
                                </div>
                            </div>
                        </div>
                        
                        <?php flag_get(); ?>
                        
                        <div class="row m-t-20">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Edit User Profile</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="name">Full name</label>
                                                <input type="text" id="name" name="name" value="<?php echo $user->v_fullname; ?>" placeholder="Enter full name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" id="email" name="email" value="<?php echo $user->v_email; ?>" placeholder="Enter email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" id="phone" name="phone" value="<?php echo $user->v_phone; ?>" placeholder="Enter phone number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Image Profile</label>
                                                <br/>
                                                <input type="file" name="image_profile">
                                                <input type="hidden" name="old_image_profile" value="<?php echo $user->v_image; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="about">About me</label>
                                                <textarea class="form-control" id="summernote_profile" name="about"><?php echo htmlspecialchars_decode($user->v_message); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="current_password">Current password</label>
                                                <input type="password" id="current_password" name="current_password" placeholder="Please enter current password for submit changes" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-warning" name="update_user_profile">
                                                <i class="fa fa-check"></i> Update Profile</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Change user password</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" id="username" name="username" value="<?php echo $user->v_username; ?>" class="form-control" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Old Password</label>
                                                <input type="password" id="old_password" name="old_password" placeholder="Enter old password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Password</label>
                                                <input type="password" id="password" name="password" placeholder="Enter new password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Re-enter password</label>
                                                <input type="password" id="repassword" name="repassword" placeholder="Re-enter new password" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-warning" name="change_password">
                                                <i class="fa fa-key"></i> Change Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>User Image</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <img src="../images/avatars/<?php echo $user->v_image; ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include_once 'partials/footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include_once 'partials/script.php'; ?>

</body>

</html>
<!-- end document-->

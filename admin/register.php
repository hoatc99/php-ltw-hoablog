<?php  
    include 'includes/include.php';
    
    if (isset($_SESSION['user_id'])) {
        redirect('index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User($db);
        $user->v_fullname = $_POST['username'];
        $user->v_username = $_POST['username'];
        $user->v_password = md5($_POST['password']);
        $user->f_user_status = 1;
        $user->d_date_created = date('Y-m-d', time());
        $user->d_time_created = date('h:i:s', time());
        if ($user->create()) {
            flag_set('Create account successfully! Please login.');
            redirect('login.php');
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>Register</title>

</head>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>

                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Username</label>
                                    <label id="username_message" class="message"></label>
                                    <input class="au-input au-input--full" type="text" name="username" onfocusout="check_username(this.value);" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <label id="password_message" class="message"></label>
                                    <input class="au-input au-input--full" type="password" name="password" oninput="check_password(this.value, repassword.value);" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Retype Password</label>
                                    <label id="repassword_message" class="message"></label>
                                    <input class="au-input au-input--full" type="password" name="repassword" oninput="check_password(password.value, this.value);" placeholder="Retype Password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-t-10 m-b-10" id="btn_register" type="submit" disabled>register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="login.php">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include 'partials/script.php'; ?>

    <script>
        
        is_check_username = false;
        is_check_password = false;

        const check_username = (username) => {
            if (username == '') {
                $('#username_message').text('Please enter a username');
                is_check_username = false;
            } else {
                $.ajax({
                    method: 'POST',
                    async: false,
                    url: 'apis/check_username.php',
                    data: { username: username }
                    })
                .done((response) => {
                    if (response == "true") {
                        $('#username_message').text('This username has already been taken. Please choose another one.');
                        is_check_username = false;
                    } else {
                        $('#username_message').text('');
                        is_check_username = true;
                    }
                });
            }
            toggle_submit_button();
        }

        const check_password = (password, repassword) => {
            if (password == '') {
                $('#password_message').text('Please enter a password');
                is_check_password = false;
            } else if (repassword == '') {
                $('#re-password_message').text('Please re-enter a password');
                is_check_password = false;
            } else if (password != repassword) {
                $('#password_message').text('Password is not match');
                is_check_password = false;
            } else {
                $('#password_message').text('');
                is_check_password = true;
            }
            toggle_submit_button();
        }

        const toggle_submit_button = () => {
            if (is_check_username && is_check_password) {
                $('#btn_register').prop('disabled', false);
            } else {
                $('#btn_register').prop('disabled', true);
            }
            console.log($('#btn_register').prop('disabled'));
        }
        
    </script>

</body>

</html>
<!-- end document-->
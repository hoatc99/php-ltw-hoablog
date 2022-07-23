<?php  
    session_start();

    include 'includes/dbc.php';
    include 'includes/users.php';
    include 'includes/handler.php';

    if (isset($_SESSION['user_id'])) {
        redirect('index.php');
    }
    
    $database = new Database();
    $db = $database->connect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User($db);
        $user->v_username = $_POST['username'];
        $user->v_password = md5($_POST['password']);
        $login_user_list = $user->login();

        if ($login_user_list->rowCount() > 0) {
            $login_user_item = $login_user_list->fetch();

            if ($login_user_item['f_user_status'] == 0) {
                flag_set('Login failed! This account is disabled. Please contact admin for more infomation.', 'failed');
                redirect();
            }

            $_SESSION['user_id'] = $login_user_item['n_user_id'];
            file_put_contents('sum_of_visits.txt', (int)file_get_contents('sum_of_visits.txt') + 1);
            flag_set('Login successfully! Welcome to HoaBlog Admin page.');
            redirect('index.php');
        } else {
            flag_set('Login failed! Username or password is wrong!.', 'failed');
            redirect();
        }  
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>Login</title>

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

                        <?php flag_get(); ?>

                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Username</label>
                                    <label id="username_message" class="message"></label>
                                    <input class="au-input au-input--full" type="text" id="username" oninput="check_login(this.value, password.value);" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <label id="password_message" class="message"></label>
                                    <input class="au-input au-input--full" type="password" id="password" oninput="check_login(username.value, this.value);" name="password" placeholder="Password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-t-10 m-b-10" id="btn_login" type="submit" disabled>sign in</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Don't you have account?
                                    <a href="register.php">Sign Up Here</a>
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

        is_check_login = false;

        const check_login = (username, password) => {
            if (username == '') {
                $('#username_message').text('Please enter a username');
                is_check_login = false;
            } else if (password == '') {
                $('#password_message').text('Please enter a password');
                is_check_login = false;
            } else {
                $('#password_message').text('');
                is_check_login = true;
            }
            toggle_submit_button();
        }

        const toggle_submit_button = () => {
            if (is_check_login) {
                $('#btn_login').prop('disabled', false);
            } else {
                $('#btn_login').prop('disabled', true);
            }
        }

    </script>
    
</body>

</html>
<!-- end document-->
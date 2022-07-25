<?php
    include_once 'admin/include.php';

    $blog_list = $blog->read();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit_contact'])) {
            $contact->v_fullname = $_POST['c_name'];
            $contact->v_email = $_POST['c_email'];
            $contact->v_phone = $_POST['c_phone'];        
            $contact->v_message = $_POST['c_message'];
            $contact->d_date_created = date('y-m-d',time());
            $contact->d_time_created = date('h:i:s',time());
            $contact->f_contact_status = 1;
            if ($contact->create()) {
                redirect();
            }
        }
    }

    $user->n_user_id = $admin_id;
    $user->read_single();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once 'partials/meta.php'; ?>
    <?php include_once 'partials/style.php'; ?>
    <title>HoaBlog - Liên hệ</title>

</head>

<body>

    <?php include_once 'partials/navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Liên hệ</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.php">Trang chủ
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Liên hệ
                            <i class="ion-ios-arrow-forward"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section contact-section bg-light">
        <div class="container">
            <div class="row d-flex mb-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h4">Thông tin liên hệ</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-md-3">
                    <b>Họ và tên:</b>
                    <p><?php echo $user->v_fullname; ?></p>
                </div>
                <div class="col-md-3">
                    <b>Số điện thoại:</b>
                    <p><a href="tel://<?php echo $user->v_phone; ?>"><?php echo $user->v_phone; ?></a></p>
                </div>
                <div class="col-md-3">
                    <b>Email:</b>
                    <p><a href="mailto:<?php echo $user->v_email; ?>"><?php echo $user->v_email; ?></a></p>
                </div>
                <div class="col-md-3">
                    <b>Website:</b>
                    <p><a href="http://hoablog.herokuapp.com">hoablog.herokuapp.com</a></p>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
        <div class="container-wrap">
            <div class="row d-flex align-items-stretch no-gutters">
                <div class="col-md-6 p-5 order-md-last">
                    <h2>Hãy nêu cảm nhận của bạn về trang này</h2>
                    <p>Những lời góp ý chân thành của bạn sẽ là bàn đạp vững chắc để chúng tôi cải thiện sản phẩm này.</p>
                    <form action="" method="POST" onsubmit="alert('Chúng tôi đã nhận được lời góp ý của bạn. Xin chân thành cảm ơn.');">
                        <div class="form-group">
                            <input type="text" class="form-control" name="c_name" placeholder="Nhập tên của bạn">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="c_email" placeholder="Nhập email của bạn">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="c_phone" placeholder="Nhập số điện thoại của bạn">
                        </div>
                        <div class="form-group">
                            <textarea name="c_message" cols="30" rows="7" class="form-control" placeholder="Nhập nội dung góp ý"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi" name="submit_contact" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 d-flex align-items-stretch">
                    <img src="images/upload/cam-on.png" class="img-fluid" alt="Image placeholder">
                </div>
            </div>
        </div>
    </section>

    <?php include_once 'partials/footer.php'; ?>

    <?php include_once 'partials/script.php'; ?>
    
</body>

</html>
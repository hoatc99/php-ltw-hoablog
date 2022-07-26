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
                <div class="col-md-6 p-4 order-md-last">
                    <h2>Hãy nêu cảm nhận của bạn về trang này</h2>
                    <p>Những lời góp ý chân thành của bạn sẽ là động lực để chúng tôi cải thiện sản phẩm này.</p>
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
                            <textarea name="c_message" cols="30" rows="5" class="form-control" placeholder="Nhập nội dung góp ý"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi" name="submit_contact" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 p-4 d-flex align-items-stretch">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.605252125846!2d106.67114211411639!3d10.76487536235205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ee10bef3c07%3A0xfd59127e8c2a3e0!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEtpbmggVOG6vyBUUC5IQ00!5e0!3m2!1svi!2s!4v1658804815031!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <?php include_once 'partials/footer.php'; ?>

    <?php include_once 'partials/script.php'; ?>
    
</body>

</html>
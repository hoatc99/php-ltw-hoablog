<?php  
    include "admin/includes/include.php";

    $blog_list = $blog->read();

    $contact_list = $contact->client_read();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php include 'partials/meta.php'; ?>
    <?php include 'partials/style.php'; ?>
    <title>HoaBlog - Về chúng tôi</title>
    
</head>

<body>

    <?php include 'partials/navbar.php'; ?>    

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/background/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">HoaBlog</h1>
                    <h4 class="mb-2 bread">Nơi kết nối cảm xúc của những trái tim băng giá</h4>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.html">Trang chủ 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Về chúng tôi 
                            <i class="ion-ios-arrow-forward"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-5 p-md-5 img img-2" style="background-image: url(images/background/bg_3.jpg);">
                </div>
                <div class="col-md-7 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section mb-5 pl-md-5">
                        <div class="pl-md-5 ml-md-5">
                            <span class="subheading subheading-with-line"><small
                                    class="pr-2 bg-white">Về chúng tôi</small></span>
                            <h2 class="mb-4">Trần Cẩm Hòa</h2>
                        </div>
                    </div>
                    <div class="pl-md-5 ml-md-5 mb-5">
                        <div class="row">
                            <div class="col-md-3"><h5>Ngành nghề</h5></div>
                            <div class="col-md-3"><h5>Số điện thoại</h5></div>
                            <div class="col-md-3"><h5>Email</h5></div>
                            <div class="col-md-3"><h5>Đơn vị công tác</h5></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Lập trình viên</div>
                            <div class="col-md-3">0908834610</div>
                            <div class="col-md-3">hoact.it@gmail.com</div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 pt-4">
                <div class="col-md-4 ftco-animate">
                    <h3 class="h4">Sứ mệnh</h3>
                    <p>Mang đến cho bạn một không gian ấm áp, một nơi mà hàng triệu trái tim đang cô đơn có thể hòa nhịp cùng nhau.</p>
                </div>
                <div class="col-md-4 ftco-animate">
                    <h3 class="h4">Tầm nhìn</h3>
                    <p>Chúng tôi mong muốn phát triển bản thân trở nên tốt hơn mỗi ngày và chúng tôi sẽ thể hiện thông qua trang này.</p>
                </div>
                <div class="col-md-4 ftco-animate">
                    <h3 class="h4">Vai trò</h3>
                    <p>Chúng tôi luôn mong muốn cải thiện để mang đến cho độc giả một không gian đọc tốt hơn. Xin hãy góp ý cho chúng tôi <a href="contact.php">tại đây</a>.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'partials/counter_section.php'; ?>

    <section class="ftco-section testimony-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading subheading-with-line"><small class="pr-2 bg-light">Nhận xét của độc giả</small></span>
                    <h2 class="mb-4">Độc giả nói gì</h2>
                    <p>Chúng tôi rất trân trọng những ý kiến và đóng góp của các bạn. Nếu có bất kỳ đóng góp nào, vui lòng <a href="contact.php">Nhấn vào đây</a>.</p>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel">
                        <?php while ($contact_item = $contact_list->fetch()): ?>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(images/avatars/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line"><?php echo $contact_item['v_message']; ?></p>
                                    <div class="pl-5">
                                        <p class="name"><?php echo $contact_item['v_fullname']; ?></p>
                                        <span class="position"><?php echo $contact_item['d_date_created']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>
    
    <?php include 'partials/script.php'; ?>

</body>

</html>
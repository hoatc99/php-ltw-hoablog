<section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/background/bg_3.jpg);"
    data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row d-md-flex align-items-center justify-content-end">
            <div class="col-lg-10">
                <div class="row d-md-flex align-items-center">
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number" data-number="<?php echo $blog->read()->rowCount(); ?>">0</strong>
                                <span>Bài viết</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number"
                                    data-number="<?php echo $contact->read()->rowCount(); ?>">0</strong>
                                <span>Liên hệ</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number"
                                    data-number="<?php echo $subscriber->read()->rowCount(); ?>">0</strong>
                                <span>Lượt đăng ký</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">
                                <strong class="number"
                                    data-number="<?php echo file_get_contents('admin/sum_of_visits.txt'); ?>">0</strong>
                                <span>Tổng truy cập</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
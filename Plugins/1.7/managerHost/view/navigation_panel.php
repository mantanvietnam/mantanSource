	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Bảng điều hướng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Bảng điều hướng</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <div class="ourclients">
        <div class="row">
            <div class="col-sm-12">
                <h3>Bạn muốn đi đâu?</h3>
				<p><?php echo $mess;?></p>
				
                <div class="row spacing-40">
                    <div class="col-sm-9 center-block">

                        <div class="block-grid-sm-4 block-grid-xs-2 clients">

                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.05s">
                                <a href="<?php echo $urlHomes.'add-coin';?>">Nạp tiền</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.1s">
                                <a href="<?php echo $urlHomes.'check-domains';?>">Mua tên miền</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.15s">
                                <a href="<?php echo $urlHomes.'hosting-plans';?>">Mua host</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.2s">
                                <a href="<?php echo $urlHomes.'cloud-vps';?>">Mua VPS</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.25s">
                                <a href="<?php echo $urlHomes.'cart';?>">Giỏ hàng</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.3s">
                                <a href="<?php echo $urlHomes.'checkout';?>">Thanh toán</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.35s">
                                <a href="<?php echo $urlHomes.'manage-services';?>">Quản lý dịch vụ</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.4s">
                                <a href="<?php echo $urlHomes.'revenue';?>">Doanh thu</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.45s">
                                <a href="<?php echo $urlHomes.'account';?>">Thông tin tài khoản</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.5s">
                                <a href="<?php echo $urlNotices.'cat/khuyen-mai.html';?>">Khuyến mại</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.55s">
                                <a href="<?php echo $urlNotices.'cat/tuyen-dung.html';?>">Tuyển dụng</a>
                            </div>
                            <div class="block-grid-item wow fadeInUp" data-wow-delay="0.6s">
                                <a href="<?php echo $urlHomes.'logout';?>">Đăng xuất</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- End of About Us -->


    <?php getFooter();?>

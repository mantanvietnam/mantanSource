	<?php getHeader();?>

	<!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Kiếm tiền cùng Mantan Host</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Chương trình giới thiệu</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->
    
	<!--  Features -->
    <section class="features">
        <div class="row">
            <div class="col-sm-12">
                <h2>Chương trình giới thiệu</h2>
                <span>Tăng <a title="Xem doanh thu của bạn" href="<?php echo $urlHomes.'revenue';?>">doanh thu</a> của bạn từ việc chia sẻ dịch vụ của chúng tôi</span>
                <span>
                	<?php
	                	if(!isset($_SESSION['infoUser'])){
		                	echo '  <a href="'.$urlHomes.'register">
				                		<input type="button" value="Đăng ký ngay" class="btn btn-danger">
				                	</a>';
	                	}else{
	                		$link= $urlHomes.'?refCode='.$_SESSION['infoUser']['User']['id'];
		                	echo 'Link giới thiệu: <a target="_blank" title="Link giới thiệu nhận hoa hồng" href="'.$link.'">'.$link.'</a>';
	                	}
                	?>
                </span>
            </div>
        </div>

        <div class="row spacing-70">
            <div class="col-sm-4">
                <div class="feature wow zoomIn" data-wow-delay="0.2s">
                    <img src="<?php echo $urlThemeActive;?>images/idea.png" alt="" />
                    <h4>Nó hoạt động như thế nào?</h4>
                    <p>Sau khi đăng ký bạn sẽ nhận được link giới thiệu. Gửi đường link đó tới mọi người và sau khi họ đặng ký sử dụng dịch vụ tại Mantan Host bạn sẽ được chia hoa hồng. Càng nhiều người đăng ký bạn càng có nhiều doanh thu.</p>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="feature wow zoomIn" data-wow-delay="0.4s">
                    <img src="<?php echo $urlThemeActive;?>images/coupon-code.png" alt="" />
                    <h4>Sử dụng banner bắt mắt - Giảm giá sốc</h4>
                    <p>Banners gọn gàng, bắt mắt cùng các chương trình giảm giá sốc của chúng tôi chắc chắn sẽ thu hút nhiều người click. Chọn một cái bạn thích, chèn lên website và chờ xem số lượng đăng ký tăng lên thế nào.</p>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="feature wow zoomIn" data-wow-delay="0.6s">
                    <img src="<?php echo $urlThemeActive;?>images/make-money.png" alt="" />
                    <h4>Tiền có được để làm gì?</h4>
                    <p>Bạn có thể sử dụng số tiền có được từ việc chia sẻ này để mua tên miền, hosting, VPS của Mantan Host hoặc quy đổi thành thẻ cào điện thoại, tiền mặt.</p>
                </div>
            </div>

        </div>
    </section>
    <!-- End of Features -->
    
    <?php getFooter();?>
	<?php getHeader();?>
    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Đăng ký nhận tin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Đăng ký thành công</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <!-- Blog -->
    <div class="blog single">
    	<div class="row">
            <div class="col-sm-8">
            <!-- Blog Post-->
            <article>
            	<div class="post-content content-view">
					<h2><a href="<?php echo $urlNow;?>">Đăng ký nhận tin thành công</a></h2>
					Mantan Host đã lưu địa chỉ email của bạn lại, mỗi khi có thông báo hoặc các chương trình khuyến mại mới chúng tôi sẽ gửi email cho bạn. Cảm ơn đã quan tâm đến Mantan Host.
				</div>
            </article>
            <!-- End of Blog Post-->
        </div>

        <?php getSidebar();?>

        </div>
	</div>

    <!-- End of Blog -->
    <?php getFooter();?>
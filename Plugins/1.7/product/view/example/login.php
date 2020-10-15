<?php getHeader();?>
<section class="body-section products-list">
	<!-- U S E R   S E C T I O N -->
	<div class="body-section user-account">
		<div class="title-wrapper">
			<h2>Đăng nhập</h2>
		</div>
		<div class="clear-both"></div>
		<div class="row" style="padding:10px;">
			<div class="col-sm-6">
				<form class="custom-form pre-validation row" role="form" method="post" action="<?php echo $urlHomes.'checkLogin';?>">
					<?php
						if(isset($_GET['status'])){
							switch ($_GET['status']) {
								case -1: echo '<p style="color:red;">Sai tên đăng nhập hoặc mật khẩu !</p>';break;
							}
						}
					?>
					
					<div class="form-group">
						<label for="username">Tên đăng nhập<span class="form-require"> (*)</span></label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
					</div>
					<div class="form-group">
						<label for="password">Mật khẩu<span class="form-require"> (*)</span></label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
					</div>
					<div class="form-group">
						<button type="submit" class="custom-btn btn-float">Đăng nhập</button>
					</div>
				</form>
			</div><!-- / col-sm-6 -->
			<div class="col-sm-6">
				<span>Bạn chưa có tài khoản?<strong><a href="<?php echo getLinkRegister();?>"> Đăng ký ngay </a></strong>để nhận nhiều ưu đãi.</span>
				<ul class="custom-ulist">
					<li>Đặt hàng nhanh chóng</li>
					<li>Nhận thông tin sản phẩm mới</li>
					<li>Ưu đãi với thành viên tích cực</li>
				</ul>
			</div><!-- / col-sm-6 -->
		</div>
		<div class="clear-both"></div>
	</div><!-- / user-section -->
</section>

<?php getSidebar();?>
<?php getFooter();?>
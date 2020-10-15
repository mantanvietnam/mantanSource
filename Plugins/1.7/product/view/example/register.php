<?php getHeader();?>
<section class="body-section products-list">
	<!-- U S E R   S E C T I O N -->
	<div class="body-section user-account">
		<div class="title-wrapper">
			<h2>Đăng ký tài khoản</h2>
		</div>
		<div class="clear-both"></div>
		<div class="row" style="padding:10px;">
			<form class="custom-form row" role="form" method="post" action="<?php echo $urlHomes.'saveUser';?>">
				<div class="col-xs-12">
				<?php
					if(isset($_GET['status'])){
						switch ($_GET['status']) {
							case 1: echo '<p style="color:red;">Đăng ký thành công. Bạn có thể <a href="'.getLinkLogin().'">đăng nhập</a> để mua hàng !</p>';break;
							case -1: echo '<p style="color:red;">Bạn cần điền đầy đủ các trường thông tin !</p>';break;
							case -2: echo '<p style="color:red;">Tài khoản này đã tồn tại !</p>';break;
							case -3: echo '<p style="color:red;">Mật khẩu nhập lại chưa đúng !</p>';break;
						}
					}
				?>
				</div>

				<div class="col-sm-6">
					<div class="form-group" style="margin-bottom: 20px">
						<label for="fullname">Họ & tên<span class="form-require"> (*)</span></label>
						<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Tên đầy đủ" required>
					</div>
					<div class="form-group">
						<label for="username">Tài khoản<span class="form-require"> (*)</span></label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập mới" required>
					</div>
					<div class="form-group">
						<label for="password">Mật khẩu<span class="form-require"> (*)</span></label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu mới" required>
					</div>
					<div class="form-group">
						<label for="password">Nhập lại mật khẩu<span class="form-require"> (*)</span></label>
						<input type="password" class="form-control" id="passwordAgain" name="passwordAgain" placeholder="Nhập lại mật khẩu" required>
					</div>
				</div><!-- / col-sm-6 -->
				<div class="col-sm-6">
					<div class="form-group">
						<label for="email">Email<span class="form-require"> (*)</span></label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
					</div>
					<div class="form-group">
						<label for="phone">Điện thoại<span class="form-require"> (*)</span></label>
						<input type="number" class="form-control" id="phone" name="phone" placeholder="Điện thoại" required>
					</div>
					<div class="form-group">
						<label for="address">Địa chỉ<span class="form-require"> (*)</span></label>
						<textarea class="form-control" rows="3" name="address" placeholder="Số nhà, xã, phường, quận ..." required></textarea>
					</div>
				</div><!-- / col-sm-6 -->
				<div class="form-group col-xs-12">
					<button type="submit" class="custom-btn btn-float pull-right">Đăng ký</button>
				</div>
			</form>
		</div>
	</div><!-- / user-section -->
</section>			

<?php getSidebar();?>
<?php getFooter();?>		
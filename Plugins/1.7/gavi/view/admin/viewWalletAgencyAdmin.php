<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<div class="form-horizontal form-label-left">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Ví tiền của đại lý <?php echo $agency['Agency']['phone'].' - '.$agency['Agency']['code'];?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Quỹ mua hàng: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['purchaseFund']); ?> đ">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Số dư khả dụng: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['active']); ?> đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Số dư chờ rút: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['request']); ?> đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tiền đặt cọc đại lý: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['deposit']); ?> đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tiền mua hàng bị đóng băng: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['order']); ?> đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tiền tạo mã QR bị đóng băng: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['qrcode']); ?> đ">
								</div>
							</div>

							<!--
							<div class="form-group">
								<form method="post" action="/changeMoneyAgencyAdmin">
									<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
									<input type="hidden" name="type" value="waitingOrder">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="waitingOrder">Tiền bán hàng đợi kế toán duyệt: </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input name="waitingOrder" class="form-control col-md-7 col-xs-12 input_money" id="waitingOrder" maxlength="255" type="text" value="<?php echo (int) @$agency['Agency']['wallet']['waitingOrder']; ?>">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<button class="btn btn-success width-100" type="submit" onclick="return confirm('Bạn có chắc muốn duyệt Tiền bán hàng không ?');">Duyệt</button> 
									</div>
								</form>
							</div>

							<div class="form-group">
								<form method="post" action="/changeMoneyAgencyAdmin">
									<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
									<input type="hidden" name="type" value="waitingBonus">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="waitingBonus">Tiền thưởng phát triển đại lý đợi duyệt: </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input name="waitingBonus" class="form-control col-md-7 col-xs-12 input_money" id="waitingBonus" maxlength="255" type="text" value="<?php echo (int) @$agency['Agency']['wallet']['waitingBonus']; ?>">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<button class="btn btn-success width-100" type="submit" onclick="return confirm('Bạn có chắc muốn duyệt Tiền thưởng phát triển đại lý không ?');">Duyệt</button> 
									</div>
								</form>
							</div>

							<div class="form-group">
								<form method="post" action="/changeMoneyAgencyAdmin">
									<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
									<input type="hidden" name="type" value="waitingQRBonus">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="waitingQRBonus">Tiền thường giới thiệu đại lý đợi duyệt: </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input name="waitingQRBonus" class="form-control col-md-7 col-xs-12 input_money" id="waitingQRBonus" maxlength="255" type="text" value="<?php echo (int) @$agency['Agency']['wallet']['waitingQRBonus']; ?>">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<button class="btn btn-success width-100" type="submit" onclick="return confirm('Bạn có chắc muốn duyệt Tiền thường giới thiệu đại lý không ?');">Duyệt</button> 
									</div>
								</form>
							</div>
						-->
						<div class="form-group">
							<form method="post" action="/changeMoneyAgencyAdmin">
								<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
								<input type="hidden" name="type" value="waitingShip">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="waitingShip">Tiền giao hàng nhờ thu hộ: </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input name="waitingShip" class="form-control col-md-7 col-xs-12 input_money" id="waitingShip" maxlength="255" type="text" value="<?php echo (int) @$agency['Agency']['wallet']['waitingShip']; ?>">
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<button class="btn btn-success width-100" type="submit" onclick="return confirm('Bạn có chắc muốn duyệt Tiền giao hàng nhờ thu hộ không ?');">Duyệt</button>
								</div>
							</form>
						</div>

						<div class="form-group">
							<form method="post" action="/changeMoneyAgencyAdmin">
								<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
								<input type="hidden" name="type" value="penalties">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="waitingShip">Tiền phạt do hàng vận chuyển bị trả lại: </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input name="penalties" class="form-control col-md-7 col-xs-12 input_money" id="penalties" maxlength="255" type="text" value="<?php echo (int) @$agency['Agency']['wallet']['penalties']; ?>">
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<button class="btn btn-success width-100" type="submit" onclick="return confirm('Bạn có chắc muốn duyệt Tiền phạt do hàng vận chuyển bị trả lại không ?');">Duyệt</button>
								</div>
							</form>
						</div>

						<div class="form-group">
							<form method="post" action="/changeMoneyAgencyAdmin">
								<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
								<input type="hidden" name="type" value="ship">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="waitingShip">Tiền phí vận chuyển: </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input name="ship" class="form-control col-md-7 col-xs-12 input_money" id="ship" maxlength="255" type="text" value="<?php echo (int) @$agency['Agency']['wallet']['ship']; ?>">
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<button class="btn btn-success width-100" type="submit" onclick="return confirm('Bạn có chắc muốn duyệt Tiền phí vận chuyển không ?');">Duyệt</button>
								</div>
							</form>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tổng tiền mặt đã nạp vào hệ thống: </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['wallet']['recharge']); ?> đ">
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
</div>
<?php if(!empty($mess)){ ?>
	<div id="showM" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thông báo</h4>
				</div>
				<div class="modal-body">
					<div class="showMess"><?php echo $mess; ?></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
				</div>
			</div>

		</div>
	</div>
	<?php }?>
	<?php include "footer.php";?>

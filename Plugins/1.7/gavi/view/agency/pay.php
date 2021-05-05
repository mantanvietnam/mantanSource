
	<?php include('header_nav.php');?>

	<div class="container title-page">
		<a onclick="" href="/wallet" class="back">
			<i class="fa fa-angle-left" aria-hidden="true"></i>
		</a>
		<p>Đặt lệnh rút tiền</p>
	</div>
	<div class="container home-block">
		<div class="">
			<a href="/listPay">
				<div class="col-xs-12 item" style="text-align: left;padding-top: 12px; height: auto">
					<ul class="list-unstyled">
						<li>Danh sách yêu cầu rút tiền</li>
					</ul>
				</div>
			</a> 
		</div>
	</div>

	<div class="container page-content">
		<div class="col-xs-12 col-sm-12 agency-detail">
			<div class="letter-content">
				<form action="" method="post">
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
									<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
								</div>
							</div>

						</div>
					</div>
					<?php }?>
					<div class="row">
						<div class="col-xs-6">
							<label>Số dư được rút: </label>
							<span><?php echo number_format($agency['Agency']['wallet']['active']);?>đ</span>
						</div>
						<div class="col-xs-6">
							<label>Tiền chờ rút: </label>
							<span><?php echo number_format(@$agency['Agency']['wallet']['request']);?>đ</span>
						</div>
					</div>

					<div class="form-group">
						<input type="text" class="input_money form-control" id="" placeholder="Số tiền rút*" name="money" pattern="^[\d/.]{7,16}$" title="Số tiền rút thấp nhất là 100.000 đ" required="">
					</div>

					<div class="" id="selectAddress">
						<Select id="" class="form-control" style="margin-bottom: 10px;" name="bank" required="">
							<option value="">Tài khoản ngân hàng*</option>
							<?php
							if(!empty($_SESSION['infoAgency']['Agency']['bank'])){
								foreach($_SESSION['infoAgency']['Agency']['bank'] as $key=>$addressTo){
									echo '<option value="'.$key.'">'.$addressTo['bankAccount'].' - '.$addressTo['bankNumber'].' - '.$addressTo['bankName'].'</option>';
								}
								
							}
							?>
						</Select>
					</div>

					<div class="letter-footer">
						
						<button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
							<i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

	<script src="/app/Plugin/gavi/view/agency/js/number-divider.js"></script>
	<script>
		$(document).ready(function() {
			$('.input_money').divide({delimiter: '.',
				divideThousand: true});
		});
	</script>

</body>
</html>

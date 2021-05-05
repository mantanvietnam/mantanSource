<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" id="add_user_form" class="form-horizontal form-label-left" method="post">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Thêm mới đại lý</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							
							<div class="card">
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Cài đặt chung</a></li>
									<li role="presentation"><a href="#wallet" aria-controls="wallet" role="tab" data-toggle="tab">Ví điện tử</a></li>
									<li role="presentation"><a href="#warehouse" aria-controls="warehouse" role="tab" data-toggle="tab">Kho hàng ảo</a></li>
									<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Tài khoản ngân hàng</a></li>
									<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Địa chỉ nhận hàng</a></li>
								</ul>

								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="home">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Mã đại lý:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="code" class="form-control col-md-7 col-xs-12" id="" maxlength="255" type="text" disabled="" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Cấp độ đại lý: <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="form-control col-md-7 col-xs-12" name="level" required="" onchange="checkLevel(this.value);">
													<option value="">Chọn cấp độ</option>
													<?php
													foreach($listTypeAgency as $typeAgency){
														echo '<option value="'.$typeAgency['id'].'">'.$typeAgency['name'].'</option>';
													}
													?>
												</select>								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tên đại lý: <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="fullName" required="required" class="form-control col-md-7 col-xs-12" id="" maxlength="255" type="text" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email: <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="email" required="required" class="form-control col-md-7 col-xs-12" id="email" maxlength="255" type="email" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Mật khẩu: <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="pass" required="required" class="form-control col-md-7 col-xs-12" id="" maxlength="200" type="text" autocomplete="off">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_mobile">Điện thoại: <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="phone" required="required" class="form-control col-md-7 col-xs-12" id="user_mobile" maxlength="200" type="text" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Chứng minh thư nhân dân:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="cmnd" class="form-control col-md-7 col-xs-12" id="" maxlength="12" type="text" value="">	
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tỉnh thành phố:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="form-control col-md-7 col-xs-12" name="idCity">
													<option>Chọn tỉnh thành phố</option>
													<?php
													foreach($listCity as $city){
														echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
													}
													?>
												</select>								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_address">Địa chỉ:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="address" class="form-control col-md-7 col-xs-12" id="user_address" maxlength="" type="text" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Ngày tham gia: <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" maxlength="50" required="" class="form-control datetimepicker" placeholder="" name="dateStart" value="">
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Mã đại lý cấp cha:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="codeAgencyFather" class="form-control col-md-7 col-xs-12" id="" maxlength="" type="text" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Mã đại lý giới thiệu:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="codeAgencyIntroduce" class="form-control col-md-7 col-xs-12" id="" maxlength="" type="text" value="">								
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Mô tả:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<textarea class="form-control col-md-7 col-xs-12" name="note"></textarea>							
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Ảnh đại diện:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php                    
												showUploadFile('avatar','avatar','',0);
												?>								
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Số hợp đồng:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="contractNumber" class="form-control col-md-7 col-xs-12" id="" maxlength="" type="text" value="">								
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">File hợp đồng:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php                    
												showUploadFile('contractFile','contractFile','',1);
												?>								
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="wallet">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Số dư khả dụng:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="moneyActive" class="form-control col-md-7 col-xs-12 input_money" id="" maxlength="" type="text" value="">								
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tiền đặt cọc:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="moneyDeposit" class="form-control col-md-7 col-xs-12 input_money" id="moneyDeposit" maxlength="" type="text" value="">								
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="warehouse">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Lấy hàng từ kho:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="idWarehous" class="form-control">
													<?php
													if(!empty($listWarehous['Option']['value']['allData'])){
														foreach($listWarehous['Option']['value']['allData'] as $warehous){
															echo '<option value="'.$warehous['id'].'">'.$warehous['name'].'</option>';
														}
													}
													?>
												</select>							
											</div>
										</div>
										<?php
										if(!empty($listProduct)){
											foreach($listProduct as $product){
												echo '	<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="">'.$product['Product']['name'].':</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
												<input name="product['.$product['Product']['id'].']" class="form-control col-md-7 col-xs-12 input_money" id="" maxlength="" type="text" >								
												</div>
												</div>';
											}
										}
										?>
									</div>
									<div role="tabpanel" class="tab-pane" id="profile">

										<div class="row mb6">
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<label for="">Tài khoản ngân hàng 1</label>
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankAccount[1]" placeholder="Tên chủ tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankNumber[1]" placeholder="Số tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<select name="bankName[1]" class="form-control">
														<option value="">Chọn tên ngân hàng</option>
														<?php 
														foreach($listBank as $bank){
															echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankBranch[1]" placeholder="Tên chi nhánh ngân hàng" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
										<div class="row mb6">
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<label for="">Tài khoản ngân hàng 2</label>
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankAccount[2]" placeholder="Tên chủ tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankNumber[2]" placeholder="Số tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													
													<select name="bankName[2]" class="form-control">
														<option value="">Chọn tên ngân hàng</option>
														<?php 
														foreach($listBank as $bank){
															echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankBranch[2]" placeholder="Tên chi nhánh ngân hàng" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
										<div class="row mb6">
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<label for="">Tài khoản ngân hàng 3</label>
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankAccount[3]" placeholder="Tên chủ tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankNumber[3]" placeholder="Số tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<select name="bankName[3]" class="form-control">
														<option value="">Chọn tên ngân hàng</option>
														<?php 
														foreach($listBank as $bank){
															echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col-md-4">
												<div class="form-group">
													<input name="bankBranch[3]" placeholder="Tên chi nhánh ngân hàng" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>

									</div>
									<div role="tabpanel" class="tab-pane" id="messages">
										<div class="row mb6">
											<div class="col-sm-12">
												<label for="">Địa chỉ giao hàng số 1</label>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressName[1]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressPhone[1]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<input name="addressAdd[1]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
										<div class="row mb6">
											<div class="col-sm-12">
												<label for="">Địa chỉ giao hàng số 2</label>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressName[2]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressPhone[2]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<input name="addressAdd[2]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
										<div class="row mb6">
											<div class="col-sm-12">
												<label for="">Địa chỉ giao hàng số 3</label>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressName[3]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressPhone[3]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<input name="addressAdd[3]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
										<div class="row mb6">
											<div class="col-sm-12">
												<label for="">Địa chỉ giao hàng số 4</label>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressName[4]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressPhone[4]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<input name="addressAdd[4]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
										<div class="row mb6">
											<div class="col-sm-12">
												<label for="">Địa chỉ giao hàng số 5</label>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressName[5]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-6 col-md-3">
												<div class="form-group">
													<input name="addressPhone[5]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
											<div class="col-sm-12 col-md-6">
												<div class="form-group">
													<input name="addressAdd[5]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>




							<div class="form-group btn-submit-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<button class="btn btn-success width-100" type="submit">Lưu lại</button> 
									<a href="/listAgency" class="btn btn-primary width-100">Quay lại</a>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</form>	
	</div>
</div>

<style type="text/css" media="screen">
.tab-content{
	padding: 20px 0;
}
.mb6{
	margin-bottom: 20px;
}
</style>
<script type="text/javascript">
	var level= [];
	<?php
	foreach($listTypeAgency as $typeAgency){
		echo 'level['.$typeAgency['id'].']= '.$typeAgency['money_deposit'].';';
	}
	?>
	function checkLevel(idlevel){
		$('#moneyDeposit').val(level[idlevel]);
	}
</script>
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

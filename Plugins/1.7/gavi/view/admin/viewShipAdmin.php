<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" class="form-horizontal form-label-left" id="ExchangeAddMoneyForm" method="post" >
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Thông tin yêu cầu chuyển hàng</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Mã đại lý:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="codeAgency" disabled="" value="<?php echo $data['Ship']['codeAgency'];?>" class="form-control col-md-7 col-xs-12" id="email" type="text">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Mã yêu cầu:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="code" disabled="" value="<?php echo $data['Ship']['code'];?>" class="form-control col-md-7 col-xs-12" id="email" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="catproduct_id">Trạng thái xử lý: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="status" required="required" class="form-control col-md-7 col-xs-12" id="catproduct_id" data-parsley-required-message="Không được bỏ trống trường này" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
										<?php
										foreach($listStatusShip as $statusShip){
											if($statusShip['id']>=$data['Ship']['status']){
												echo '<option value="'.$statusShip['id'].'">'.$statusShip['name'].'</option>';
											}
										}
										?>			
									</select>								
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Tên người nhận: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" required="required" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $data['Ship']['address']['name'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Địa chỉ nhận: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="address" required="required" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $data['Ship']['address']['address'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Tỉnh thành<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="city" class="form-control" required="" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
		                                <?php
		                                    $listCity= getListCity();
		                                    foreach($listCity as $city){
		                                    	if($city['id']!=$data['Ship']['city']){
			                                        echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
			                                    }else{
			                                    	echo '<option selected value="'.$city['id'].'">'.$city['name'].'</option>';
			                                    }
		                                    }
		                                ?>
		                           	</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Điện thoại người nhận: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control" placeholder="Số điện thoại" id="phone" name="phone" required="" value="<?php echo $data['Ship']['address']['phone'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Ngày giao hàng:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text"  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" id="date" name="date" placeholder="Ngày nhận" value="<?php echo $data['Ship']['address']['date'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Số tiền cần thu: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="money" required="required" class="form-control col-md-7 col-xs-12 input_money" id="money_count" type="text" value="<?php echo $data['Ship']['money'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Phí vận chuyển: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="moneyShip" required="required" class="form-control col-md-7 col-xs-12 input_money" id="money_count" type="text" value="<?php echo $data['Ship']['moneyShip'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Phí phạt trả hàng: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="moneyPenalties" required="required" class="form-control col-md-7 col-xs-12 input_money" id="money_count" type="text" value="<?php echo $data['Ship']['moneyPenalties'];?>" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Sản phẩm:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php
									if(!empty($data['Ship']['product'])){
										foreach($data['Ship']['product'] as $product){
											echo '<p><a target="_blank" href="/addProduct?id='.$product['id'].'">'.$product['name'].'</a> : '.$product['quantily'].'</p>';
										}
									}
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="money_count">Thông báo cho đại lý</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="note" class="form-control col-md-7 col-xs-12" <?php if(!$checkProduct || in_array($data['Ship']['status'], array(3,4,5))) echo 'disabled=""';?> ><?php echo $data['Ship']['note'];?></textarea>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="form-group btn-submit-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<?php if($checkProduct && !in_array($data['Ship']['status'], array(3,4,5))) echo '<button class="btn btn-success width-100" type="submit" onclick="return confirm(\'Chú ý kiểm tra trạng thái xử lý yêu cầu vì không thể thay đổi được nếu chọn sai\');">Lưu lại</button>';?> 
									<a href="/listShipAdmin" class="btn btn-primary width-100">Quay lại</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>	</div>
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

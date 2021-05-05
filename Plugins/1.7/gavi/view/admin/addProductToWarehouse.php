<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" data-parsley-validate="data-parsley-validate" id="add_agency_form" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8">		
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Thêm hàng vào kho</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="row">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Chọn kho <span class="color_red">*</span>: </label>
											<select name="idWarehouse" class="form-control" required="">
												<option value="">Chọn kho</option>
												<?php
												if(!empty($listWarehouse['Option']['value']['allData'])){
													foreach($listWarehouse['Option']['value']['allData'] as $warehouse){
														if(empty($_GET['idWarehouse']) || $_GET['idWarehouse']!=$warehouse['id']){
															echo '<option value="'.$warehouse['id'].'">'.$warehouse['name'].'</option>';
														}else{
															echo '<option selected value="'.$warehouse['id'].'">'.$warehouse['name'].'</option>';
														}
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Chọn sản phẩm <span class="color_red">*</span>: </label>
											<select name="idProduct" class="form-control" required="">
												<option value="">Chọn sản phẩm</option>
												<?php
												if(!empty($listProduct)){
													foreach($listProduct as $product){
														if(empty($_GET['idProduct']) || $_GET['idProduct']!=$product['Product']['id']){
															echo '<option value="'.$product['Product']['id'].'">'.$product['Product']['name'].'</option>';
														}else{
															echo '<option selected value="'.$product['Product']['id'].'">'.$product['Product']['name'].'</option>';
														}
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Số lượng <span class="color_red">*</span>: </label>
											<input type="text" min="1" value="" class="form-control input_money" placeholder="Số lượng" name="quantity" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Ngày hết hạn <span class="color_red">*</span>: </label>
											<input type="text" value="" class="form-control input_date datetimepicker" placeholder="Ngày hết hạn" name="dateExpiration" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Ngày nhập kho <span class="color_red">*</span>: </label>
											<input type="text" value="" class="form-control input_date datetimepicker" placeholder="Ngày nhập kho" name="dateInput" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" class="btn_ad" style="display: inline-block !important;">Lưu</button>
										<span class="btn_ad_back"><a href="/viewWarehouse?id=<?php echo @$_GET['idWarehouse'];?>">Quay lại</a></span>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</form>	
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

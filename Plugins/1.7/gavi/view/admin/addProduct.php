<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">

	<div class="">
		<form action="" id="add_product_form" class="form-horizontal form-label-left" method="post" accept-charset="utf-8">			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Thêm mới sản phẩm</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_code">Mã sản phẩm: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="code" required="required" class="form-control col-md-7 col-xs-12" id="product_code" maxlength="50" value="<?php echo @$data['Product']['code'];?>" data-parsley-required-message="Không được bỏ trống trường này" data-parsley-pattern="^[A-Za-z0-9-]+$" data-parsley-pattern-message="Mã sản phẩm: Chỉ bao gồm các ký tự 0-9, a-z, A-Z và dấu -" type="text">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Tên sản phẩm: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" required="required" class="form-control col-md-7 col-xs-12" id="product_name" data-parsley-required-message="Không được bỏ trống trường này" maxlength="255" type="text" value="<?php echo @$data['Product']['name'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="catproduct_id">Danh mục: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="idCategory" required="required" class="form-control col-md-7 col-xs-12" id="catproduct_id" data-parsley-required-message="Không được bỏ trống trường này">
										<option value="">--- Chọn danh mục ---</option>
										<?php
										if(!empty($listCategoryProduct['Option']['value']['allData'])){
											foreach($listCategoryProduct['Option']['value']['allData'] as $category){
												if(empty($data['Product']['idCategory']) || $data['Product']['idCategory']!=$category['id']){
													echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
												}else{
													echo '<option selected value="'.$category['id'].'">'.$category['name'].'</option>';
												}
											}
										}
										?>
									</select>								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_image">Hình ảnh:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php                    
									showUploadFile('image','image',@$data['Product']['image'],0);
									?>							
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Giá bán lẻ: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="price" value="<?php echo @$data['Product']['price'];?>" required class="form-control col-md-7 col-xs-12 input_money" id="price" type="text">	
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_unit">Đơn vị bán: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="unit" required="required" class="form-control col-md-7 col-xs-12" id="product_unit" data-parsley-required-message="Không được bỏ trống trường này" maxlength="255" type="text" value="<?php echo @$data['Product']['unit'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="productContainer">Số sản phẩm 1 lô: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="productContainer" value="<?php echo @$data['Product']['productContainer'];?>" required class="form-control col-md-7 col-xs-12 input_money" id="productContainer" type="text">	
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="priceShipContainer">Phí vận chuyển 1 lô: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="priceShipContainer" value="<?php echo @$data['Product']['priceShipContainer'];?>" required class="form-control col-md-7 col-xs-12 input_money" id="priceShipContainer" type="text">	
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="freeShipContainer">Miễn phí vận chuyển với đơn hàng có ít nhất bao nhiêu lô: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="freeShipContainer" value="<?php echo @$data['Product']['freeShipContainer'];?>" required class="form-control col-md-7 col-xs-12 input_money" id="freeShipContainer" type="text">	
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_description">Mô tả:</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<textarea name="description" class="form-control col-md-7 col-xs-12" id="product_description" rows="3" cols="30"><?php echo @$data['Product']['description'];?></textarea>								
								</div>
							</div>

							
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Số lượng sản phẩm trong kho</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<?php
							if(!empty($listWarehouseProduct['Option']['value']['allData'])){
								foreach($listWarehouseProduct['Option']['value']['allData'] as $warehouse){
									echo '	<div class="form-group">
									<div class="col-md-8 col-sm-8 col-xs-12">
									<input disabled="" class="form-control col-md-7 col-xs-12" value="'.$warehouse['name'].'" >
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<input disabled="" class="form-control col-md-7 col-xs-12 input_money" id="quantity" placeholder="Số lượng" type="text" value="'.@$data['Product']['warehouse'][$warehouse['id']].'">									
									</div>
									</div>';
								}
							}
							?>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Giá đại lý</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<?php
							foreach($listAgency as $agency){
								echo '	<div class="form-group">
								<div class="col-md-8 col-sm-8 col-xs-12">
								<input disabled="" class="form-control col-md-7 col-xs-12" value="'.$agency['name'].'" type="text">
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
								<input required name="priceAgency['.$agency['id'].']" class="form-control col-md-7 col-xs-12 input_money" id="price" placeholder="Giá bán (vnđ)" type="text" value="'.@$data['Product']['priceAgency'][$agency['id']].'">									
								</div>
								</div>';
							}
							?>

							
							
							<div class="form-group">
								<div class="ln_solid"></div>
								<div class="form-group btn-submit-group">
									<div class="col-md-12 col-sm-12 col-xs-12 text-center">
										<button class="btn btn-success width-100" type="submit">Lưu lại</button>
										<a href="/listProduct" class="btn btn-primary width-100">Hủy bỏ</a>
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

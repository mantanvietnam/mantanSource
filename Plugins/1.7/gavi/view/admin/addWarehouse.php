<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" id="add_store_form" class="form-horizontal form-label-left" method="post">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Thêm mới kho hàng</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tên kho hàng: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" required="required" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo @$data['name'];?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_address">Địa chỉ: <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="address" required="required" class="form-control col-md-7 col-xs-12" id="store_address" maxlength="500" type="text" value="<?php echo @$data['address'];?>">
								</div>
							</div>

							<div class="ln_solid"></div>
							<div class="form-group btn-submit-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<button class="btn btn-success width-100" type="submit" id="btn_add_store">Lưu lại</button>
									<a href="/listWarehouse" class="btn btn-primary width-100">Hủy bỏ</a>
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

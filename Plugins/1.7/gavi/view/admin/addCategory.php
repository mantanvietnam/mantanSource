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
							<h2>Thêm danh mục mới</h2>
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
											
											<label>Tên danh mục <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" value="<?php echo @$data['name'];?>" placeholder="Nhập tên danh mục" class="form-control" required="" name="name" >
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" class="btn_ad" style="display: inline-block !important;">Lưu</button>
										<span class="btn_ad_back"><a href="/listCategory">Quay lại</a></span>
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

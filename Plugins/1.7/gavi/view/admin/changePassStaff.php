<?php include "header.php";?>
<style type="text/css" media="screen">
	.sub_staff {
		margin-left: 15px;
	}
</style>
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
							<h2>Đổi mật khẩu</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Mật khẩu cũ:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="passOld" required="required" class="form-control col-md-7 col-xs-12" id="" maxlength="255" type="password" value="" autocomplete="off">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Mật khẩu mới:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="passNew" required="required" class="form-control col-md-7 col-xs-12" id="" maxlength="255" type="password" value="" autocomplete="off">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Nhập lại mật khẩu mới:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="passAgain" required="required" class="form-control col-md-7 col-xs-12" id="" maxlength="255" type="password" value="" autocomplete="off">								
								</div>
							</div>

							
							<div class="ln_solid"></div>
							<div class="form-group btn-submit-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<button class="btn btn-success width-100" type="submit" id="btn_edit_profile">Lưu lại</button>
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

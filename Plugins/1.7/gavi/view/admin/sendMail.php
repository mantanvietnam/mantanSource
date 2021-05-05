<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" id="add_letter_form" class="form-horizontal form-label-left" method="post">
			<div class="clearfix"></div>
			<div class="row letter-view">
				<div class="col-md-12 letter-add">
					<div class="x_panel">
						<div class="x_content">
							<div class="row">
								<div class="letter-info">
									Gửi thông báo cho <?php echo (isset($_GET['type']) && $_GET['type']=='agency')?'đại lý':'tất cả';?>
								</div>
								<div class="letter-content1">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="letter_subject">SĐT đại lý nhận:<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input name="phoneAgency" required="required" class="form-control col-md-7 col-xs-12" id="" maxlength="" type="text" <?php echo (isset($_GET['type']) && $_GET['type']=='agency')?'':'disabled=""';?> >
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="letter_subject">Tiêu đề:<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input name="subject" required="required" class="form-control col-md-7 col-xs-12" id="letter_subject" maxlength="255" type="text">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="letter_subject">Nội dung:<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea style="width:100%" name="content" cols="" rows="5" required=""></textarea>
										</div>
									</div>
								</div>
								<div class="mail-body text-center tooltip-demo letter-add-footer">
									<button class="btn btn-success width-100" type="submit" id="btn_add_letter">Gửi thư</button>
									<a href="/listMail" class="btn btn-primary width-100">Hủy bỏ</a>
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


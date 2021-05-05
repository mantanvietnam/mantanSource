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
							<h2>Thêm mới nhân viên</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Họ tên:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="fullName" required="required" class="form-control col-md-7 col-xs-12" id="last_name" maxlength="255" type="text" value="<?php echo @$data['Staff']['fullName'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="email" required="required" class="form-control col-md-7 col-xs-12" id="email"  maxlength="255" type="email" value="<?php echo @$data['Staff']['email'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Mật khẩu:<?php if(empty($_GET['id'])) echo '<span class="required">*</span>';?></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="pass" autocomplete="off" <?php if(empty($_GET['id'])) echo 'required="required"';?>  class="form-control col-md-7 col-xs-12" id="password" minlength="6" type="text" value="">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_mobile">Điện thoại:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="phone" required="" class="form-control col-md-7 col-xs-12" id="user_mobile" maxlength="12" type="text" value="<?php echo @$data['Staff']['phone'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_birthday" >Ngày sinh:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="birthday" class="form-control col-md-7 col-xs-12 datetimepicker" id="user_birthday" type="text" value="<?php echo @$data['Staff']['birthday'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_address">Địa chỉ:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="address" class="form-control col-md-7 col-xs-12" id="user_address" maxlength="255" type="text" value="<?php echo @$data['Staff']['address'];?>">								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_description">Giới thiệu:</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<textarea name="desc" class="form-control col-md-7 col-xs-12" id="user_description" rows="3" cols="30"><?php echo @$data['Staff']['desc'];?></textarea>								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12 label-no-required">Trạng thái:</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<label class="control-label control-label-published">
										<input type="radio" name="status" value="active" <?php if(!empty($data['Staff']['status']) && $data['Staff']['status']=='active') echo 'checked';?>>
										Kích hoạt                    
									</label>
									<label class="control-label control-label-published">
										<input type="radio" name="status" value="lock" <?php if(!empty($data['Staff']['status']) && $data['Staff']['status']=='lock') echo 'checked';?>>
										Khóa
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Phân quyền nhân viên</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<script type="text/javascript">
								function addCheck(idCheckbox)
								{
									$('#'+idCheckbox).attr( 'checked', true );
								}
							</script>
							<div class="gavi-user-role">
								<div class="form-group">
									<div class="col-sm-6 col-md-4">
										<ul class="list-unstyled list_addPer">
											<?php
												$listPermissionAgency= getListPermissionAgency();
												foreach($listPermissionAgency as $key=>$permissionAgency){
													$checkGroup= false;

													echo '	<li class="has_sub_staff"><span><input type="checkbox" id="check'.$key.'" > <label for="">'.$permissionAgency['name'].' <i class="fa fa-angle-down"></i></label></span>
																<ul class="list-unstyled sub_staff" style="">';
																foreach($permissionAgency['sub'] as $keysub=>$sub){
																	if(!empty($data['Staff']['permission']) && in_array($sub['permission'], $data['Staff']['permission'])){
																		$check= 'checked';
																		$checkGroup= true;
																	}else{
																		$check= '';
																	}
																	echo '<li><input '.$check.' name="permission[]" type="checkbox" value="'.$sub['permission'].'" id="check'.$key.'_'.$keysub.'"> <label for="check'.$key.'_'.$keysub.'">'.$sub['name'].'</label></li>';
																}
													echo		'</ul>
															</li>
													';

													if($checkGroup){
														echo '<script type="text/javascript">addCheck("check'.$key.'");</script>';
													}
												}
											?>
										</ul>
									</div>
								</div>
							</div>

							<div class="ln_solid"></div>
							<div class="form-group btn-submit-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<button class="btn btn-success width-100" type="submit" id="btn_edit_profile">Lưu lại</button>
									<a href="/listStaffAgency" class="btn btn-primary width-100">Hủy bỏ</a>
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
	<style type="text/css" media="screen">
	.show {
		display: block!important;
	}
</style>
<script>
	$(document).ready(function() {
		$('.list_addPer ul').hide();
		$('.has_sub_staff span label').click(function(){
			if($(this).parent().next('.sub_staff').hasClass('show')){
				$(this).parent().next('.sub_staff').slideUp();
				$(this).parent().next('.sub_staff').removeClass('show');

			} else{
				$(this).parent().next('.sub_staff').slideDown();
				$(this).parent().next('.sub_staff').addClass('show');
			}
		});

		$(".has_sub_staff span input").click(function(){
			$(this).parent().parent().find('input').prop('checked', this.checked);    
		});
	});
</script>
<?php include "footer.php";?>

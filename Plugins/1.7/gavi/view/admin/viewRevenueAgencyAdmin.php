<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" method="get" name="" id="changeMonth" class="form-horizontal form-label-left">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Doanh thu của đại lý <?php echo $agency['Agency']['phone'].' - '.$agency['Agency']['code'];?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="col-sm-12 r_item" style="padding:2px;">
								<div class="form-group" style="margin-bottom: 10px;">
									<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
									<select name="months" class="form-control" onchange='document.getElementById("changeMonth").submit();'>
										<?php
										$today= getdate();

										if(empty($_GET['months'])){
											$_GET['months']= $today['mon'];
										}

										for($i=1;$i<=12;$i++){
											if(empty($_GET['months']) || $_GET['months']!=$i){
												echo '<option value="'.$i.'">Tháng '.$i.'/'.$today['year'].'</option>';
											}else{
												echo '<option selected value="'.$i.'">Tháng '.$i.'/'.$today['year'].'</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tổng thu nhập: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['walletStatic']['profit'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['introduce'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['productBonus'][$today['year']][$_GET['months']]);?>đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Lãi bán hàng: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['walletStatic']['profit'][$today['year']][$_GET['months']]);?>đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Hoa hồng giới thiệu: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['walletStatic']['introduce'][$today['year']][$_GET['months']]);?>đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Thưởng phát triển đại lý: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['walletStatic']['productBonus'][$today['year']][$_GET['months']]);?>đ">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="store_name">Tổng doanh thu: </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="name" disabled="" class="form-control col-md-7 col-xs-12" id="store_name" maxlength="255" type="text" value="<?php echo number_format(@$agency['Agency']['walletStatic']['order'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['introduce'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['productBonus'][$today['year']][$_GET['months']]);?>đ">
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

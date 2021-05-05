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
				<div class="col-md-12 letter-list">
					<div class="x_panel">
						<div class="x_content">
							<div class="row">
								<label><?php echo $data['Email']['subject'];?></label>
								
								<div class="letter-info" style="font-size: 12px;">
									<b>Người gửi: <?php echo $data['Email']['nameFrom'];?>
									&nbsp;&nbsp;&nbsp;&nbsp;
									Ngày gửi: <?php echo date('d/m/Y',$data['Email']['time']);?></b>
									<br/>
									<?php echo nl2br($data['Email']['content']);?>
								</div>

								<?php
								if(!empty($data['Email']['reply'])){
									foreach($data['Email']['reply'] as $reply){
										echo '  <div class="letter-info" style="font-size: 12px;">
										<b>Người gửi: '.$reply['nameFrom'].'
										&nbsp;&nbsp;&nbsp;&nbsp;
										Ngày gửi: '.date('d/m/Y',$reply['time']).'</b>
										<br/>
										'.nl2br($reply['content']).'
										</div>';
									}
								}
								?>
								<?php if($data['Email']['type']=='agency'){ ?>
									<form action="" method="post">
										<div class="letter-content">
											<div class="form-group">
												<textarea class="form-control" name="content" placeholder="Nội dung phản hồi" required=""></textarea>
											</div>
										</div>

										<div class="letter-footer">
											<button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
												<i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi trả lời
											</button>
										</div>
									</form>
									<?php }?>
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


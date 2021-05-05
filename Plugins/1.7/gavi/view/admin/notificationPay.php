<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" data-parsley-validate="data-parsley-validate" id="add_agency_form" class="form-horizontal form-label-left" enctype="multipart/form-data" method="get" accept-charset="utf-8" >
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Danh sách thông báo thanh toán</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive table1">
										
										<table class="table table-bordered">
											<tbody>
												<tr>
													<td>
														<select name="idStatus" placeholder="--Trạng thái--" class="form-control">
															<option value="">--Trạng thái--</option>
															<?php
																$getStatusDefault= getStatusDefault();
																foreach($getStatusDefault as $status){
																	if(empty($_GET['idStatus']) || $_GET['idStatus']!=$status['id']){
																		echo '<option value="'.$status['id'].'">'.$status['name'].'</option>';
																	}else{
																		echo '<option selected value="'.$status['id'].'">'.$status['name'].'</option>';
																	}
																}
															?>
														</select>
													</td>
													<td>
														<button class="add_p1" type="submit">Tìm kiếm</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Hình ảnh</th>
													<th>Đại lý</th>
													<th>Số tiền</th>
													<th>Ngày nạp</th>
													<th>Ngân hàng</th>
													<th>Lý do nạp</th>
													<th>Hành động</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData)){
													foreach($listData as $data){
														if($data['Notification']['status']=='new'){
															$active= '<a onclick="return confirm(\'Bạn có chắc chắn muốn ẩn thông báo này không ?\')" href="/hideNotificationPay?id='.$data['Notification']['id'].'">Từ chối</a><br/><br/><br/><a onclick="return confirm(\'Bạn có chắc chắn muốn cộng tiền cho đại lý này không ?\')" href="/activeNotificationPay?id='.$data['Notification']['id'].'">Nạp tiền tự động</a>';
														}else{
															$active= $getStatusDefault[$data['Notification']['status']]['name'];
														}

														echo '	<tr>
														<td><a target="_blank" href="'.@$data['Notification']['file'].'"><img src="'.@$data['Notification']['file'].'" width="80" /></a></td>
														<td><a target="_blank" href="/editAgency?id='.$data['Notification']['idAgency'].'">'.$data['Notification']['codeAgency'].'</a></td>
														<td>'.number_format($data['Notification']['money']).'đ</td>
														<td>'.$data['Notification']['date']['text'].'</td>
														<td><p>TK: '.$data['Notification']['bank']['bankAccount'].'</p><p>STK: '.$data['Notification']['bank']['bankNumber'].'</p><p>NH: '.$data['Notification']['bank']['bankName'].'</p><p>CN: '.$data['Notification']['bank']['bankBranch'].'</p></td>
														<td>'.$data['Notification']['note'].'</td>
														<td align="center">'.$active.'</td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="9" align="center">Chưa có thông báo mới nào</td>
													</tr>';
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class=" text-center p_navigation" style="">
										<nav aria-label="Page navigation">
											<ul class="pagination">
												<?php
												if ($page > 4) {
													$startPage = $page - 4;
												} else {
													$startPage = 1;
												}

												if ($totalPage > $page + 4) {
													$endPage = $page + 4;
												} else {
													$endPage = $totalPage;
												}
												?>
												<li class="<?php if($page==1) echo'disabled';?>">
													<a href="<?php echo $urlPage . $back; ?>" aria-label="Previous">
														<span aria-hidden="true">«</span>
													</a>
												</li>
												<?php 
												for ($i = $startPage; $i <= $endPage; $i++) {
													if ($i != $page) {
														echo '	<li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
													} else {
														echo '<li class="active"><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
													}
												}
												?>
												<li class="<?php if($page==$endPage) echo'disabled';?>">
													<a href="<?php echo $urlPage . $next ?>" aria-label="Next">
														<span aria-hidden="true">»</span>
													</a>
												</li>
											</ul>
										</nav>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</form>	
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

		<script>
			$("#showM").on('shown.bs.modal', function(){
				$(this).find('button').focus();
			});
			$(window).on('load',function(){
				$('#showM').modal('show');
				$('.modal-dialog').draggable({
					handle: ".modal-header"
				});
			});

			$('input, textarea').blur(function(){
				$(this).val($.trim($(this).val()));
			});
		</script>
	</div>
	<?php include "footer.php";?>

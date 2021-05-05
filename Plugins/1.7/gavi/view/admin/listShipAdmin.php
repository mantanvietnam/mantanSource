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
							<h2>Danh sách đơn hàng</h2>
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
														<input type="text" maxlength="50" class="form-control" placeholder="Mã đại lý" name="codeAgency" value="<?php echo @$_GET['codeAgency'];?>">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Mã đơn hàng" name="codeOrder" value="<?php echo @$_GET['codeOrder'];?>">
													</td>
													<td>
														<select name="idStatus" placeholder="Loại đơn hàng" class="form-control">
															<option value="">Loại yêu cầu</option>
															<?php
															foreach($statusShip as $type){
																if(empty($_GET['idStatus']) || $_GET['idStatus']!=$type['id']){
																	echo '<option value="'.$type['id'].'">'.$type['name'].'</option>';
																}else{
																	echo '<option selected value="'.$type['id'].'">'.$type['name'].'</option>';
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
													<th>Ngày tạo YC</th>
													<th>Mã YC</th>
													<th>Đại lý</th>
													<th>Số tiền</th>
													<th>Sản phẩm</th>
													<th>Loại giao dịch</th>
													<th>Hành động</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData)){
													foreach($listData as $data){
														echo '	<tr>
														<td>'.$data['Ship']['dateCreate']['text'].'</td>
														<td>'.$data['Ship']['code'].'</td>
														<td><a target="_blank" href="/editAgency?id='.$data['Ship']['idAgency'].'">'.$data['Ship']['codeAgency'].'</a></td>
														<td>'.number_format($data['Ship']['money']).'đ</td>
														<td>';
														if(!empty($data['Ship']['product'])){
															foreach($data['Ship']['product'] as $product){
																echo '<p><a target="_blank" href="/addProduct?id='.$product['id'].'">'.$product['name'].'</a> : '.$product['quantily'].'</p>';
															}
														}
														echo		'</td>
														<td>'.$statusShip[$data['Ship']['status']]['name'].'</td>
														<td><a href="/viewShipAdmin?id='.$data['Ship']['id'].'">Xem yêu cầu</a></td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="9" align="center">Chưa có yêu cầu nào</td>
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

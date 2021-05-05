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
							<h2>Lịch sử giao dịch</h2>
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
														<select name="idTypeExchange" placeholder="Loại giao dịch" class="form-control">
															<option value="">Loại giao dịch</option>
															<?php
															foreach($typeExchange as $type){
																if(empty($_GET['idTypeExchange']) || $_GET['idTypeExchange']!=$type['id']){
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
													<th>Ngày xử lý</th>
													<th>Đại lý</th>
													<th>Số tiền</th>
													<th>Loại giao dịch</th>
													<th>Ghi chú</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData)){
													foreach($listData as $data){
														echo '	<tr>
														<td>'.$data['Exchange']['dateProcess']['text'].'</td>
														<td><a target="_blank" href="/editAgency?id='.$data['Exchange']['idAgency'].'">'.$data['Exchange']['codeAgency'].'</a></td>
														<td>'.number_format($data['Exchange']['money']).'đ</td>
														<td>'.$typeExchange[$data['Exchange']['typeExchange']]['name'].'</td>
														<td>'.$data['Exchange']['note'].'</td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="6" align="center">Chưa có giao dịch</td>
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

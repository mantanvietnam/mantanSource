<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">

	<div class="">
		<form action="" data-parsley-validate="data-parsley-validate" id="add_agency_form" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8" >		
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Danh sách hàng trong kho</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="row">
								<div class="col-sm-12">
									<div class="add_p">
										<p><a href="/addProductToWarehouse?idWarehouse=<?php echo $_GET['id'];?>">Thêm hàng vào kho</a></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Mã sản phẩm</th>
													<th>Tên sản phẩm</th>
													<th>Số lượng</th>
													<th>Tồn dư</th>
													<th>Ngày nhập kho</th>
													<th>Ngày hết hạn</th>
													<th>Hành động</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData)){
													foreach($listData as $data){
														echo '	<tr>
														<td>'.$data['Import']['codeProduct'].'</td>
														<td>'.$data['Import']['nameProduct'].'</td>
														<td>'.$data['Import']['quantity'].'</td>
														<td>'.$data['Import']['quantityNow'].'</td>
														<td>'.$data['Import']['dateInput']['text'].'</td>
														<td>'.$data['Import']['dateExpiration']['text'].'</td>
														<td><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa lô hàng này không ?\');" href="/deleteProductToWarehouse?id='.$data['Import']['id'].'&idWarehouse='.$_GET['id'].'">Xóa</a>
														</td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="8" align="center">Chưa có hàng trong kho</td>
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

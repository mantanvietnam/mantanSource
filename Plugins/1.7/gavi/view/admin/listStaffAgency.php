<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Danh sách nhân viên</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<div class="row">
							<div class="col-sm-12">
								<div class="table-responsive table1">
									<form action="" id="add_agency_form" class="form-horizontal form-label-left" method="get" >
										<table class="table table-bordered">
											<tbody>
												<tr>
													<td>
														<div class="add_p">
															<a href="/addStaffAgency">Thêm nhân viên</a>
														</div>
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Tên nhân viên" name="fullName" value="<?php echo @$_GET['fullName'];?>">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Email" name="email" value="<?php echo @$_GET['email'];?>">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Số điện thoại" name="phone" value="<?php echo @$_GET['phone'];?>">
													</td>
													<td>
														<select name="idStatus" placeholder="Trạng thái" class="form-control">
															<option value="">Trạng thái</option>
															<option value="active" <?php if(!empty($_GET['idStatus']) && $_GET['idStatus']=='active') echo 'selected';?>>Kích hoạt</option>
															<option value="lock" <?php if(!empty($_GET['idStatus']) && $_GET['idStatus']=='lock') echo 'selected';?>>Khóa</option>
														</select>
													</td>
													<td>
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
											</tbody>
										</table>
									</form>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Tên nhân viên</th>
												<th>Email</th>
												<th>Số điện thoại</th>
												<th>Trạng thái</th>
												<th>Hoạt động</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(!empty($listData)){
												foreach($listData as $data){
													echo '	<tr>
													<td>'.$data['Staff']['fullName'].'</td>
													<td>'.$data['Staff']['email'].'</td>
													<td>'.$data['Staff']['phone'].'</td>
													<td>'.$data['Staff']['status'].'</td>
													<td><a href="/addStaffAgency?id='.$data['Staff']['id'].'">Sửa</a></td>
													</tr>';
												}
											}else{
												echo '	<tr>
												<td colspan="9" align="center">Chưa có nhân viên nào</td>
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

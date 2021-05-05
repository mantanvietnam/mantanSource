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
							<h2>Danh sách sản phẩm</h2>
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
														<div class="add_p">
															<a href="/addProduct">Thêm sản phẩm</a>
														</div>
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Tên sản phẩm" name="name" value="<?php echo @$_GET['name'];?>">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Mã sản phẩm" name="code" value="<?php echo @$_GET['code'];?>">
													</td>
													<td>
														<select name="idCategory" placeholder="Danh mục" class="form-control">
															<option value="">Danh mục</option>
															<?php
															if(!empty($listCategoryProduct['Option']['value']['allData'])){
																foreach($listCategoryProduct['Option']['value']['allData'] as $category){
																	if(empty($_GET['idCategory']) || $_GET['idCategory']!=$category['id']){
																		echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
																	}else{
																		echo '<option selected value="'.$category['id'].'">'.$category['name'].'</option>';
																	}
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
													<th>Tên sản phẩm</th>
													<th>Mã sản phẩm</th>
													<th>Giá bán lẻ</th>
													<th>Số lượng</th>
													<th>Hành động</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData)){
													foreach($listData as $data){
														echo '	<tr>
														<td><img src="'.$data['Product']['image'].'" width="80" /></td>
														<td>'.$data['Product']['name'].'</td>
														<td>'.$data['Product']['code'].'</td>
														<td>'.number_format($data['Product']['price']).'đ</td>
														<td>'.number_format($data['Product']['quantity']).'</td>
														<td><a href="/addProduct?id='.$data['Product']['id'].'">Sửa</a> | <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này\')" href="/deleteProduct?id='.$data['Product']['id'].'">Xóa</a></td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="6" align="center">Chưa có sản phẩm</td>
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
		
	</div>
	<?php include "footer.php";?>

<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<form action="" data-parsley-validate="data-parsley-validate" id="add_agency_form" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="">
			<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Danh mục sản phẩm</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive table1">
										<div class="add_p">
											<p><a href="/addCategory">Thêm danh mục mới</a></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>ID danh mục</th>
													<th>Tên danh mục</th>
													<th>Hoạt động</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData['Option']['value']['allData'])){
													foreach($listData['Option']['value']['allData'] as $data){
														echo '	<tr>
														<td>'.$data['id'].'</td>
														<td>'.$data['name'].'</td>
														<td><a href="/addCategory?id='.$data['id'].'">Sửa</a> | <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa danh mục này không ?\');" href="/deleteCategory?id='.$data['id'].'">Xóa</a></td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="4" align="center">Chưa có danh mục</td>
													</tr>';
												}
												?>
											</tbody>
										</table>
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

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
							<h2>Danh sách yêu cầu nâng cấp đại lý</h2>
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
														<input type="text" maxlength="50" class="form-control" placeholder="Điện thoại đại lý" name="phoneAgency" value="<?php echo @$_GET['phoneAgency'];?>">
													</td>
													<td>
														<select name="idStatus" placeholder="Loại đơn hàng" class="form-control">
															<option value="">--Trạng thái--</option>
															<?php
															$getStatusDefault= getStatusDefault();
															foreach($getStatusDefault as $type){
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
													<th>Ngày yêu cầu</th>
													<th>Đại lý</th>
													<th>Cấp hiện tại</th>
													<th>Cấp muốn lên</th>
													<th>Trạng thái</th>
													<th>Hành động</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($listData)){
													foreach($listData as $data){
														echo '	<tr>
														<td>'.date('H:i:s d/m/Y',$data['Level']['timeCreate']).'</td>
														<td><a target="_blank" href="/editAgency?id='.$data['Level']['idAgency'].'">C'.$listAgency[$data['Level']['idAgency']]['Agency']['level'].'.'.$listAgency[$data['Level']['idAgency']]['Agency']['fullName'].' - '.$listAgency[$data['Level']['idAgency']]['Agency']['phone'].' ('.$listAgency[$data['Level']['idAgency']]['Agency']['code'].')</a></td>
														<td>'.$getListAgency[$data['Level']['levelOld']]['name'].'</td>
														<td>'.$getListAgency[$data['Level']['levelNew']]['name'].'</td>
														
														<td>'.@$getStatusDefault[$data['Level']['status']]['name'].'</td>
														<td>';
														if($data['Level']['status']=='new'){
															echo '<a href="/activeRequestUpdateLevel?id='.$data['Level']['id'].'" onclick="return confirm(\'Bạn có chắc chắn duyệt yêu cầu lên cấp này không ?\');">Chấp nhận</a> | <a href="javascript:void(0);" onclick="checkDelete(\''.$data['Level']['id'].'\');">Từ chối</a>';
														}elseif($data['Level']['status']=='done'){
															echo 'Yêu cầu xử lý thành công';
														}elseif($data['Level']['status']=='cancel'){
															echo 'Yêu cầu bị từ chối<br/>'.@$data['Level']['note'];
														}
														echo		'</td>
														</tr>';
													}
												}else{
													echo '	<tr>
													<td colspan="6" align="center">Chưa có yêu cầu</td>
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
<script type="text/javascript">
	function checkDelete(id)
	{
		var check= prompt("Lý do từ chối yêu cầu nâng cấp");

		if(check!=null){
			window.location= '/cancelRequestUpdateLevel?id='+id+'&note='+check;
		}else{
			alert('Bạn chưa nhập lý do từ chối nâng cấp');
		}
	}
</script>

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

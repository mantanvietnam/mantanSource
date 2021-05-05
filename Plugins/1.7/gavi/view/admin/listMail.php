<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">

		<div class="page-title">
			<div class="title_left">
				<h3>
					<?php
					if(!empty($_GET['type'])){
						switch ($_GET['type']) {
							case 'agency': echo 'Danh sách thư gửi cho đại lý';break;
							case 'all': echo 'Danh sách thư thông báo chung';break;
							case 'system': echo 'Danh sách thông báo của hệ thống';break;
						}
					}else{
						echo 'Tất cả hộp thư';
					}
					?>
				</h3>
			</div>

			<div class="title_right">
				<div class="col-md-7 col-sm-7 col-xs-12 form-group pull-right top_search">
					<form action="" method="GET" id="simple_search_form">
						<div class="input-group">
							<input name="search_input" placeholder="Tìm kiếm" class="form-control" value="" type="text" id="search_input">						<span class="input-group-btn">
								<button class="btn btn-default letter-search-submit" type="submit">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 letter-list">
				<div class="x_panel">
					<div class="x_content">
						<div class="row">
							<div class="col-md-8 header-title"><h2>Tất cả thư</h2></div>
							<div class="col-md-4">
								<div class="dropdown btn-dropdown">
									<button class="btn btn-sm btn-success btn-block btn-add-letter" type="button" data-toggle="dropdown">
										<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
										Gửi thư			<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" style="right: 0;">
										<li>
											<a href="/sendMail?type=agency" class="text-left btn-default" style="font-size: 15px;">Gửi đại lý</a>			
										</li>
										<li class="divider"></li>
										<li>
											<a href="/sendMail" class="text-left btn-default" style="font-size: 15px;">Thông báo chung</a>			
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="table-responsive">
									<table class="table table-striped jambo_table bulk_action">
										<tbody>
											<?php
											if(!empty($listData)){
												foreach($listData as $data){
													if(empty($data['Email']['phoneAgency'])) $data['Email']['phoneAgency']= 'Thông báo chung';

													if(!in_array($_SESSION['infoStaff']['Staff']['id'], $data['Email']['listView'])){
														$subject= '<b>'.$data['Email']['subject'].'</b>';
													}else{
														$subject= $data['Email']['subject'];
													}

													echo '	<tr class="even pointer">
													<td class=" ">
													<a href="/viewMail?id='.$data['Email']['id'].'">'.$data['Email']['phoneAgency'].'</a>
													</td>
													<td class=""><a href="/viewMail?id='.$data['Email']['id'].'">'.$data['Email']['codeAgency'].'</a></td>
													<td class=""><a href="/viewMail?id='.$data['Email']['id'].'">'.$subject.'</a></td>

													<td class="">'.date('d/m/Y',$data['Email']['time']).'</td>
													</tr>';
												}
											}else{
												echo '<tr class="even pointer"><td colspan="3">Không có thư</td></tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-12 text-right letter-paginate">
								<div class="row">
									<div class="col-sm-12 pagination-group">
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
									</div>
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

<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-5 col-sm-12 col-xs-12 agency-list">
				<div class="x_panel">
					<div class="x_title agency-action">
						<h2>Danh sách đại lý</h2>
						<ul>
							<a href="/addAgency" class="btn btn-primary width-100"><i class="fa fa-plus"></i> Thêm mới</a>
						</ul>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<div class="input-group" style="max-width: 400px;">
							<input type="text" name="search_input" class="form-control search-input" id="agency_search_input" style="border: solid 1px;" value="" placeholder="Tìm kiếm ...">
							<span class="input-group-btn">
								<button id="agency_search_btn" class="btn btn-primary" style="color: white;">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
							</span>
						</div>

						
						<div class="dai_ly">
							<div class="" id="treeview_json"></div>
						</div>


					</div>
				</div>
			</div>

			<div class="col-md-7 col-sm-12 col-xs-12 agency-info">
				<div class="x_panel form-horizontal" id="agency_info">
					<div class="x_title">
						<h2>Thông tin đại lý</h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content" id="infoAgency">
						<?php
						if(isset($_GET['status'])){
							if($_GET['status']=='deleteAgencyFail2'){
								echo '<p style="color: red;">Khóa tài khoản bị lỗi do tài khoản vẫn còn chi nhánh đang hoạt động</p>';
							}elseif($_GET['status']=='deleteAgencyDone'){
								echo '<p style="color: red;">Khóa tài khoản thành công</p>';
							}elseif($_GET['status']=='deleteAgencyFail'){
								echo '<p style="color: red;">Khóa tài khoản bị lỗi</p>';
							}elseif($_GET['status']=='deleteAgencyFailPass'){
								echo '<p style="color: red;">Khóa tài khoản bị lỗi do nhập sai mật khẩu admin</p>';
							}


						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css" media="screen">
.mb_6{
	margin-bottom: 6px !important;
}
ul,ol{
	margin: 0;
	padding: 0;
}
li{
	list-style: none;
}
.headBnr{
	position: absolute;
	width: 100%;
	height: 80px;
	background-color: #ccc;
}
.form-horizontal .control-label{
	padding-top: 0;
}
.jsl-collapsed-arrow{
	margin-top: 4px;
}

#jquery-script-menu {
	position: fixed;
	height: 90px;
	width: 100%;
	top: 0;
	left: 0;
	border-top: 5px solid #316594;
	background: #fff;
	-moz-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);
	-webkit-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);
	box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);
	z-index: 999999;
	padding: 10px 0;
	-webkit-box-sizing:content-box;
	-moz-box-sizing:content-box;
	box-sizing:content-box;
}

.jquery-script-center {
	width: 960px;
	margin: 0 auto;
}
.jquery-script-center ul {
	width: 212px;
	float:left;
	line-height:45px;
	margin:0;
	padding:0;
	list-style:none;
}
.jquery-script-center a {
	text-decoration:none;
}
.jquery-script-ads {
	width: 728px;
	height:90px;
	float:right;
}
.jquery-script-clear {
	clear:both;
	height:0;
}
.admin_ava{
	position: absolute;
	top: 5px;
	right: 5px;
	width: 140px;
	height: 140px;
	overflow: hidden;
	display: flex;
	justify-content: center;
	align-items: center;
}
.admin_ava img{
	max-width: 100%;
	max-height: 100%;
}

</style>
<script type="text/javascript">
	var dataAgency;
	var infoAgency;
	function loadAgency(idAgency)
	{
		$.ajax({
			method: "POST",
			url: "/getAgencyAPI",
			data: { idAgency: idAgency }
		})
		.done(function( msg ) {
			dataAgency= jQuery.parseJSON( msg );

			infoAgency= '<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Mã đại lý:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.code+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Tên đại lý:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.fullName+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Cấp đại lý:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.level+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Đại lý cha:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.codeAgencyFather+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Email:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.email+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Điện thoại:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.phone+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Chứng minh thư:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.cmnd+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Tỉnh thành:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.idCity+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Địa chỉ:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.address+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Ngày tham gia:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.dateStart.text+'</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Số dư:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.wallet.activeNumber+'đ</div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_code">Số hợp đồng:</label><div class="col-md-9 col-sm-9 col-xs-12">'+dataAgency.agency.Agency.contractNumber+'</div></div><div class="form-group"><a target="_blank" href="'+dataAgency.agency.Agency.avatar+'">Ảnh chân dung</a> - <a target="_blank" href="'+dataAgency.agency.Agency.imageCmnd+'">Ảnh CMND</a> - <a target="_blank" href="'+dataAgency.agency.Agency.contractFile+'">File hợp đồng</a></div><div class="form-group"><a href="/editAgency?id='+dataAgency.agency.Agency.id+'" class="btn btn-primary width-100 mb_6">Chỉnh sửa</a> <a onclick="return checkConfirmLock('+"'"+dataAgency.agency.Agency.id+"'"+')" href="javascript:void(0);" class="btn btn-primary width-100 mb_6">Khóa tài khoản</a> <a href="/changeAgency?code='+dataAgency.agency.Agency.code+'" class="btn btn-primary width-100 mb_6">Điều chuyển đại lý</a> <a href="/viewWarehouseAgencyAdmin?id='+dataAgency.agency.Agency.id+'" class="btn btn-primary width-100 mb_6" target="_blank">Tồn kho</a> <a href="/viewRevenueAgencyAdmin?id='+dataAgency.agency.Agency.id+'" class="btn btn-primary width-100 mb_6" target="_blank">Doanh thu</a> <a href="/viewWalletAgencyAdmin?id='+dataAgency.agency.Agency.id+'" class="btn btn-primary width-100 mb_6" target="_blank">Ví tiền</a> <a href="/viewHistoryAgencyAdmin?id='+dataAgency.agency.Agency.id+'" class="btn btn-primary width-100 mb_6" target="_blank">Lịch sử điều chuyển</a></div><div class="form-group admin_ava"><img src="'+dataAgency.agency.Agency.avatar+'" class="img-fluid" alt=""></div>';
			$('#infoAgency').html(infoAgency);
		});
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script>
	var jsonTreeData = [
	<?php
	function showTreeSub($listSub)
	{
		if(!empty($listSub)){
			foreach($listSub as $data){
				echo '{  
					"id":"'.$data['Agency']['id'].'",
					"name":"C'.$data['Agency']['level'].'.'.$data['Agency']['fullName'].' - '.$data['Agency']['phone'].' ('.$data['Agency']['code'].')",
					"text":"C'.$data['Agency']['level'].'.'.$data['Agency']['fullName'].' - '.$data['Agency']['phone'].' ('.$data['Agency']['code'].')",
					"parent_id":"'.$data['Agency']['idAgencyFather'].'",
					"children":[';
					if(!empty($data['Agency']['sub'])) showTreeSub($data['Agency']['sub']);
					echo	'],
					"data":{  

					},
					"a_attr":{  
						"href":"#",
						"onclick":"loadAgency(\''.$data['Agency']['id'].'\')"
					}
				},';
			}
		}
	}

	showTreeSub($listData);

	?>
	];


	
</script>
<script type="text/javascript">
	$(document).ready(function(){
		// $('#header').load('../header-ads.html');
		// $('#footer').load('../footer-ads.html');

		$('#treeview_json').jstree({
			'core' : {
				'data' : jsonTreeData
			},
			"search": {
				"case_insensitive": false,
				"show_only_matches" : true
			},
			plugins: ["search"]
		}).bind("select_node.jstree", function (e, data) {
			var href = data.node.a_attr.href;
			var parentId = data.node.a_attr.parent_id;
			if(href == '#')
				return '';

			window.open(href);

		});
		$('#treeview_json').slimScroll({
			height: '400px'
		});
		$('#search').keyup(function(){
			$('#treeview_json').jstree('search', $(this).val());
		});

	});
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$(".search-input").keyup(function () {
			var searchString = $(this).val();
			$('#treeview_json').jstree('search', searchString);
		});
	});
</script>
<script type="text/javascript">
	function checkConfirmLock(idAgency)
	{
		$('#idAgencyLock').val(idAgency);
		$("#showLockAgency").on('shown.bs.modal', function(){
		  $(this).find('button').focus();
		});
		$('#showLockAgency').modal('show');
	  	$('.modal-dialog').draggable({
		   	handle: ".modal-header"
		});
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

<div id="showLockAgency" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Khóa tài khoản đại lý</h4>
			</div>
			<div class="modal-body">
				<form method="POST" action="/lockAgency">
					<input type="hidden" name="id" value="" id="idAgencyLock">
					<p class="showMess">Nhập mật khẩu admin để xác thực</p>
					<input type="password" name="pass" value="" class="form-control" autocomplete="off" required="" /> 
					<br/>
					<button type="submit" class="btn btn-default">Gửi</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
			</div>
		</div>

	</div>
</div>
	<?php include "footer.php";?>

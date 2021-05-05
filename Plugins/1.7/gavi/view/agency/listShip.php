
<?php include('header_nav.php');?>

<style type="text/css" media="screen">
.form-group{
	margin-bottom: 3px;
}
.g_search .col-xs-6{
	padding: 0;
}
.icon_del{
	display: inline-block;
	float: right;
}
</style>


<div class="container title-page">
	<a href="/dashboardAgency" class="back">
		<i class="fa fa-angle-left" aria-hidden="true"></i>
	</a>
	<p>Ship hàng</p>
</div>


<nav class="menu-item">
	<div class="container">
		<div class="collapse-item">
			<div class="nav-menu-item">
				<div class="nav-menu-item-a <?php if(!isset($_GET['idStatus'])) echo 'current-tab';?>"><a href="/listShip">Tất cả</a></div>
				<div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==1) echo 'current-tab';?>"><a href="/listShip?idStatus=1">Đã đặt lệnh</a></div>
				<div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==3) echo 'current-tab';?>"><a href="/listShip?idStatus=3">Hủy bỏ</a></div>
				<div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==2) echo 'current-tab';?>"><a href="/listShip?idStatus=2">Đã xuất kho</a></div>
				<div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==5) echo 'current-tab';?>"><a href="/listShip?idStatus=5">Đã giao</a></div>
				<div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==4) echo 'current-tab';?>"><a href="/listShip?idStatus=4">Bị hoàn lại</a></div>
			</div>
		</div>
	</div>
</nav>

<div class="container g_search">
	<form action="" method="get" accept-charset="utf-8">
		<div class="form-group col-xs-6 col-sm-4">
			<input type="text" class="form-control" placeholder="Mã yêu cầu" name="code" value="<?php echo @$_GET['code'];?>">
		</div>
		<div class="form-group col-xs-6 col-sm-4">
			<input type="text" class="form-control datepicker" placeholder="Từ ngày" name="dateStart" value="<?php echo @$_GET['dateStart'];?>">
		</div>
		<div class="form-group col-xs-6 col-sm-4">
			<input type="text" class="form-control datepicker" placeholder="Đến ngày" name="dateEnd" value="<?php echo @$_GET['dateEnd'];?>">
		</div>
		<div class="form-group col-xs-6 col-sm-4">
			<input type="text" class="form-control" placeholder="SĐT người nhận" name="phone" value="<?php echo @$_GET['phone'];?>">
		</div>
		<div class="form-group col-xs-6 col-sm-4">
			<select name="city" class="form-control">
				<option value="">Lựa chọn tỉnh/thành</option>
				<?php
					$listCity= getListCity();
					foreach($listCity as $city){
						if(empty($_GET['city']) || $_GET['city']!=$city['id']){
							echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
						}else{
							echo '<option selected value="'.$city['id'].'">'.$city['name'].'</option>';
						}
					}
				?>
			</select>
		</div>
		<div class="form-group col-xs-6 col-sm-4">
			<input type="submit" class="btn btn-gavi1" value="Tìm kiếm" name="">
		</div>

	</form>
</div>

<div class="container g_search page-content">
	<a href="/addShip" class="col-xs-12 col-sm-12 item">
		<i class="fa fa-plus"></i>
		<p>Thêm yêu cầu mới</p>
	</a>
</div>


<div class="container page-content letter-list">
	<?php
	if(!empty($listData)){
		foreach($listData as $data){
			echo '	<div class="col-xs-12 col-sm-12 item bg_1">
						<a href="/viewShipAgency?id='.$data['Ship']['id'].'">
							<p><span>'.$data['Ship']['code'].'</span> - '.$data['Ship']['address']['name'].'</p>
							<br><span style="color: #777;">'.@$listCity[$data['Ship']['city']]['name'].' - '.$statusShip[$data['Ship']['status']]['name'].'</span>
							'; 
							if(!empty($data['Ship']['product'])){
	                            foreach($data['Ship']['product'] as $product){
	                                echo '<br><span style="color: #777;">'.$product['name'].' : '.$product['quantily'].'</span>';
	                            }
	                        }
			echo		'</a>';
						if($data['Ship']['status']==1){
							echo '<a onclick="return confirm(\'Bạn có chắc chắn muốn hủy yêu cầu này không ?\');" class="icon_del" href="/deleteShipAgency?id='.$data['Ship']['id'].'"> <i class="fa fa-trash" aria-hidden="true"></i></a>';
						}else{
							echo '<p>'.@$data['Ship']['note'].'</p>';
						}
			echo	'</div>';
		}
	}
	?>
	


	<div class="col-sm-12 text-center p_navigation" style="    width: 100%;
	float: left;">
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
					echo '  <li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
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


<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

<script>
    $(document).ready(function() {
        $('.back-store').click(function(){
            $('.ul_buy').slideToggle();
        });
    });

    $(".datepicker").datepicker({
            });
            jQuery(function($){
                $.datepicker.regional['vi'] = {
                    closeText: 'Đóng',
                    prevText: '<Trước',
                    nextText: 'Tiếp>',
                    currentText: 'Hôm nay',
                    monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                    'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
                    monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
                    dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    weekHeader: 'Tu',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 0,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
                    $.datepicker.setDefaults($.datepicker.regional['vi']);
                });
</script>

<script>
	$(document).ready(function() {
		$('.back-store').click(function(){
			$('.ul_buy').slideToggle();
		});
	});
</script>
</body>
</html>

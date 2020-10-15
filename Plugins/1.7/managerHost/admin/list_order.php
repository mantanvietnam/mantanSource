<style>
.tableList{
	width: 100%;
	margin-bottom: 20px;
	border-collapse: collapse;
    border-spacing: 0;
    border-top: 1px solid #bcbcbc;
    border-left: 1px solid #bcbcbc;
}
.tableList td{
	padding: 5px;
	border-bottom: 1px solid #bcbcbc;
    border-right: 1px solid #bcbcbc;
}
</style>
<?php
	$breadcrumb= array( 'name'=>'Danh sách đơn hàng',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_order.php',
						'sub'=>array('name'=>'Đơn hàng')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
<div class="thanhcongcu">
	<div class="congcu">
		<a href="<?php echo $urlPlugins.'admin/managerHost-admin-list_order.php';?>">
			<span>
				<img src="<?php echo $webRoot;?>images/refresh.png">
			</span>
			<br>
			Refresh
		</a>
	</div>
</div>
<div class="clear"></div>
<div id="content">

<form action="" method="get">
	<table width="100%" cellspacing="0" class="tableList">
		<tr>
			<td>
				<input name="email" type="email" value="<?php if(isset($_GET['email'])) echo $_GET['email'];?>" placeholder="Email khách hàng" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<select name="payStatus">
					<option value="-1">Tất cả</option>
					<?php
						foreach($typePayStatus as $key=>$pay){
							if($key!=$payStatus){
								echo '<option value="'.$key.'">'.$pay.'</option>';
							}else{
								echo '<option selected value="'.$key.'">'.$pay.'</option>';
							}
						}
					?>
				</select>
			</td>
			<td>
				<select name="processStatus">
					<option value="-1">Tất cả</option>
					<?php
						foreach($typeProcessStatus as $key=>$pay){
							if($key!=$processStatus){
								echo '<option value="'.$key.'">'.$pay.'</option>';
							}else{
								echo '<option selected value="'.$key.'">'.$pay.'</option>';
							}
						}
					?>
				</select>
			</td>
			<td>
				<input class="input" type="submit" value="Tìm kiếm">
			</td>
		</tr>
	</table>
</form>

<br/>


    <table id="listTin" cellspacing="0" class="tableList">

        <tr>
        	<td align="center">NGÀY ĐẶT</td>
        	<td align="center">TÀI KHOẢN</td>
            <td align="center">THÔNG TIN ĐƠN HÀNG</td>
            <td align="center">MÃ GIẢM GIÁ</td>
            <td align="center">TỔNG TIỀN</td>
			<td align="center">GIẢM TRỪ</td>
            <td align="center">THANH TOÁN</td>
            <td align="center">TRẠNG THÁI</td>
            <td align="center">LỰA CHỌN</td>
        </tr>
        <?php
        	
            $confirm= 'Bạn có chắc chắn muốn xóa không';
            
            if(count($listData)>0){
	            foreach($listData as $data)
	            {  
					$totalOrder= $data['Order']['infoOrder']['totalOrder']-$data['Order']['infoOrder']['priceDiscount'];
	            	$data['Order']['created']= getdate($data['Order']['created']->sec);
					$data['Order']['created']= $data['Order']['created']['mday'].'/'.$data['Order']['created']['mon'].'/'.$data['Order']['created']['year'];
					
					$data['Order']['infoOrder']['pay']= $typePay[$data['Order']['infoOrder']['pay']];
					$data['Order']['processStatus']= $typeProcessStatus[$data['Order']['processStatus']];
					$data['Order']['payStatus']= $typePayStatus[$data['Order']['payStatus']];
					
                	echo '  <tr>
                                <td class="alignLeft">'.$data['Order']['created'].'</td>
                                <td class="alignLeft"><a target="_blank" href="'.$urlPlugins.'admin/managerHost-admin-list_user.php?email='.$data['Order']['user_email'].'">'.$data['Order']['user_email'].'</a></td>
                                <td class="alignLeft">';
								foreach($data['Order']['listOrder'] as $order){
									echo '<p><b>'.$order['Product']['title'].'</b></p>';
									echo nl2br($order['Product']['info']);
								}
					echo		'</td>
                                <td class="alignLeft">'.$data['Order']['infoOrder']['codeGift'].'</td>
                                <td class="alignLeft">';
								if($data['Order']['infoOrder']['priceDiscount']>0){
									echo '<p>Giá sau giảm trừ</p>';
								}
					echo		number_format($totalOrder).'đ</td>
								<td class="alignLeft">'.number_format($data['Order']['infoOrder']['priceDiscount']).'đ</td>
                                <td class="alignLeft">'.$data['Order']['infoOrder']['pay'].'</td>
                                <td class="alignLeft"><p>'.$data['Order']['payStatus'].'</p><p>'.$data['Order']['processStatus'].'</p></td>
                                <td align="center">
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-process_order.php/'.$data['Order']['id'].'" class="input">Xử lý</a>  
							    </td>
                            </tr>';
	            }
            }else{
	            echo '<tr><td colspan="9" align="center">Chưa có đơn hàng nào</td></tr>';
            }

        ?>


    </table>
	<p>
    <?php
		
		if(isset($_GET['page'])){
			$urlNow= str_replace('&page='.$_GET['page'], '', $urlNow);
			$urlNow= str_replace('?page='.$_GET['page'], '', $urlNow);
		}
		if(strpos($urlNow,'?')!== false)
		{
			$urlNow= $urlNow.'&page=';
		}
		else
		{
			$urlNow= $urlNow.'?page=';
		}
		
		echo '<a href="'.$urlNow.$back.'">Trang trước</a> ';
		echo $page.'/'.$totalPage;
		echo ' <a href="'.$urlNow.$next.'">Trang sau</a> ';

    ?>
	</p>





</div>
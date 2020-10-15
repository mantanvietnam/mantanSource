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
	$breadcrumb= array( 'name'=>'Dịch vụ khách thuê',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_service.php',
						'sub'=>array('name'=>'Danh sách')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
	<div class="thanhcongcu">
	
	    <div class="congcu">
	        <a href="<?php echo $urlPlugins.'admin/managerHost-admin-add_service.php';?>">
				<span>
					<img src="<?php echo $webRoot;?>images/add.png">
				</span>
				<br>
				Thêm
	        </a>
	    </div>
		
		<div class="congcu">
	        <a href="<?php echo $urlPlugins.'admin/managerHost-admin-refresh_service.php';?>">
				<span>
					<img src="<?php echo $webRoot;?>images/refresh.png">
				</span>
				<br>
				Refresh
	        </a>
	    </div>
	</div>
	<div class="clear"></div>
	<br/>
<div id="content">

<form action="" method="get">
	<table width="100%" cellspacing="0" class="tableList">
		<tr>
			<td>
				<input name="email" type="email" value="<?php if(isset($_GET['email'])) echo $_GET['email'];?>" placeholder="Email khách hàng" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<input name="key" type="text" value="<?php if(isset($_GET['key'])) echo $_GET['key'];?>" placeholder="Từ khóa" style="float:left;margin-right: 5px;"/> 
			</td>
			<td>
				<input name="phone" type="text" value="<?php if(isset($_GET['phone'])) echo $_GET['phone'];?>" placeholder="Số điện thoại" style="float:left;margin-right: 5px;"/> 
			</td>
            <td>
				<select name="typeService">
                    <option value="">Loại dịch vụ</option>
					<?php
						foreach($typeService as $key=>$type){
							if(isset($data['Service']['typeService']) && (int)$data['Service']['typeService']==$key){
								echo '<option selected value="'.$key.'">'.$type.'</option>';
							}else{
								echo '<option value="'.$key.'">'.$type.'</option>';
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
        	<td align="center" width="200">Gói dịch vụ</td>
            <td align="center">Tình trạng</td>
            <td align="center">Ngày hết hạn</td>
			<td align="center">Phí duy trì</td>
            <td align="center">Thông tin</td>
            <td align="center">Email đăng ký</td>
            <td align="center">Lựa chọn</td>
        </tr>

        <?php
        	
            $confirm= 'Bạn có chắc chắn muốn xóa không';
            
            if(count($listData)>0){
            	$today= getdate();

	            foreach($listData as $tin)
	            {  
	            	$style= '';
					$numberEnd= ($tin['Service']['timeEnd']-$today[0])/2592000;
					if($numberEnd<0){
						$style= 'style="background-color: red;color: #fff;"';
					}elseif($numberEnd<2){
						$style= 'style="background-color: yellow;"';
					}

					$tin['Service']['status']= $typeStatusDomain[$tin['Service']['status']];
					
					$numberDay= round(($tin['Service']['timeEnd']-$tin['Service']['timeStart'])/2592000);
					
					$timeStart= getdate($tin['Service']['timeStart']);
					$tin['Service']['timeStart']= $timeStart['mday'].'/'.$timeStart['mon'].'/'.$timeStart['year'];
					
					$timeEnd= getdate($tin['Service']['timeEnd']);
					$tin['Service']['timeEnd']= $timeEnd['mday'].'/'.$timeEnd['mon'].'/'.$timeEnd['year'];
					
					$info= nl2br($tin['Service']['info']);
					
	                echo '<tr '.$style.'>
							  <td>'.$tin['Service']['product_name'].'</td>
	                          <td>'.$tin['Service']['status'].'</td>
	                          <td>'.$tin['Service']['timeEnd'].'</td>
							  <td><p>'.number_format($tin['Service']['priceMainten']).'đ</p>'.$numberDay.' tháng</td>
	                          <td>'.$info.'</td>
	                          <td>'.$tin['Service']['user_email'].'</td>
	                          
	                          <td align="center">
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-add_service.php/'.$tin['Service']['id'].'" class="input"  >Sửa</a>  
							  		<br/>
							  		<a style="padding: 4px 8px;color: #bcbcbc;" href="'.$urlPlugins.'admin/managerHost-admin-send_subscribe.php/?idService='.$tin['Service']['id'].'" class="input" target="_blank" >Thông báo</a>  
                                    <br/>
                                    <a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-delete_service.php/'.$tin['Service']['id'].'" class="input" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" >Xóa</a>  
							  		
                              </td>
	
	                        </tr>';
	            }
            }else{
	            echo '<tr><td colspan="7" align="center">Khách hàng chưa thuê dịch vụ nào</td></tr>';
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
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
	$breadcrumb= array( 'name'=>'Quản lý người dùng',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_user.php',
						'sub'=>array('name'=>'Danh sách')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
<div id="content" style="clear:both;">

<form action="" method="get">
	<table width="100%" cellspacing="0" class="">
		<tr>
			<td>
				<input name="email" value="<?php if(isset($_GET['email'])) echo $_GET['email'];?>" placeholder="Email người dùng" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<input name="phone" value="<?php if(isset($_GET['phone'])) echo $_GET['phone'];?>" placeholder="Điện thoại người dùng" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<input name="name" value="<?php if(isset($_GET['name'])) echo $_GET['name'];?>" placeholder="Tên người dùng" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<input class="input" type="submit" value="Tìm kiếm">
			</td>
		</tr>
	</table>
</form>

<br/>
<div style="clear:both;"></div>

    <table id="listTin" cellspacing="0" class="tableList">

        <tr>
			<td align="center">Email</td>
        	<td align="center">Họ tên</td>
            <td align="center">Số điện thoại</td>
            <td align="center">Số dư</td>
            <td align="center">Phần trăm</td>
			<td align="center">Địa chỉ</td>
			<td align="center">Thời gian ĐK</td>
            <td align="center" width="160">Lựa chọn</td>
        </tr>

        <?php
        	
            $confirm= 'Bạn có chắc chắn muốn xóa không';
            
            if(count($listData)>0){
	            foreach($listData as $tin)
	            {  
					$create= getdate($tin['User']['created']->sec);
					$create= $create['mday'].'/'.$create['mon'].'/'.$create['year'];
					
	                echo '<tr>
	                		  <td>'.$tin['User']['email'].'</td>
							  <td>'.$tin['User']['name'].'</td>
	                          <td>'.$tin['User']['phone'].'</td>
	                          <td>'.number_format($tin['User']['coin']).'đ</td>
	                          <td>'.$tin['User']['percent'].'</td>
	                          <td>'.$tin['User']['address'].'</td>
	                          <td>'.$create.'</td>
	                          <td align="center">
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-add_user.php/'.$tin['User']['id'].'" class="input"  >Sửa</a>  
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-lock_user.php/'.$tin['User']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Khóa</a>
							  </td>
	
	                        </tr>';
	            }
            }else{
	            echo '<tr><td colspan="8" align="center">Chưa có người dùng nào</td></tr>';
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
<link href="<?php echo $urlHomes.'app/Plugin/netLoading/admin/style.css';?>" rel="stylesheet">

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>'Netloading',
						'url'=>$urlPlugins.'admin/netLoading-admin-listCustomer.php',
						'sub'=>array('name'=>'Danh sách người dùng')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 


<div class="clear"></div>
<div id="content">
	<div class="clear"></div>
	<form>
		Kiểu lọc 
		<select name="view">
			<option <?php if(isset($_GET['view']) && $_GET['view']=='all') echo 'selected';?>  value="all">Xem tất cả</option>
			<option <?php if(isset($_GET['view']) && $_GET['view']=='regDriver') echo 'selected';?>  value="regDriver">Đăng ký chủ xe</option>
		</select>

		<input type="submit" value="Tìm kiếm" />
	</form>
	<br/>
	<div class="clear"></div>
    <table id="listTin" cellspacing="0" class="tableList">
        <tr>
        	<td align="center">Họ tên</td>
            <td align="center">Email</td>
            <td align="center">Điện thoại</td>
            <td align="center">Loại tài khoản</td>
            <td align="center">Lựa chọn</td>
        </tr>

        <?php
            $confirm= 'Bạn có chắc chắn muốn xóa không';
            
            foreach($listData as $tin)
            {
            	if($tin['Customer']['chuxe']==true)
	            {
		            $typeCustomer= 'Chủ xe';
	            }
	            else
	            {
		            $typeCustomer= 'Chủ hàng';
	            }

	            echo '	<tr>
	            			<td>'.$tin['Customer']['fullName'].'</td>
	            			<td>'.$tin['Customer']['email'].'</td>
	            			<td>'.$tin['Customer']['fone'].'</td>
	            			<td>'.$typeCustomer.'</td>
	            			<td align="center"><a href="'.$urlPlugins.'admin/netLoading-admin-addCustomer.php?id='.$tin['Customer']['id'].'">Sửa</a></td>
	            		</tr>';
            }

        ?>


    </table>
	<p>
	    <?php
	    	if($page>5){
				$startPage= $page-5;
			}else{
				$startPage= 1;
			}

			if($totalPage>$page+5){
				$endPage= $page+5;
			}else{
				$endPage= $totalPage;
			}
			
			echo '<a href="'.$urlPage.$back.'">Trang trước</a> ';
			for($i=$startPage;$i<=$endPage;$i++){
				echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
			}
			echo ' <a href="'.$urlPage.$next.'">Trang sau</a> ';

			echo 'Tổng số trang: '.$totalPage;
	    ?>
	</p>
</div>
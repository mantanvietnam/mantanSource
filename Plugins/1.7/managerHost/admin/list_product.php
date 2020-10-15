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
	$breadcrumb= array( 'name'=>'Danh sách dịch vụ',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_product.php',
						'sub'=>array('name'=>'Dịch vụ')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
	<div class="thanhcongcu">
	
	    <div class="congcu">
	
	        <a href="<?php echo $urlPlugins.'admin/managerHost-admin-add_product.php';?>">
	
	          <span>
	
	            <img src="<?php echo $webRoot;?>images/add.png">
	
	          </span>
	
	            <br>
	
	            Thêm
	
	        </a>
	
	    </div>
	</div>
	
	<br/>
<div id="content" style="clear:both;">

<form action="" method="get">
	<table width="100%" cellspacing="0" class="tableList">
		<tr>
			<td>
				<input name="title" value="<?php if(isset($_GET['title'])) echo $_GET['title'];?>" placeholder="Tên sản phẩm" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<input name="id" value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>" placeholder="ID sản phẩm" style="float:left;margin-right: 5px;"/> 
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
        	<td align="center">ID</td>
            <td align="center">Tên dịch vụ</td>
            <td align="center">Loại dịch vụ</td>
            <td align="center">Phí khởi tạo</td>
            <td align="center">Phí duy trì/năm</td>
            <td align="center">VAT</td>
            <td align="center">Phí chuyển đổi</td>
            <td align="center">Mô tả</td>
            <td align="center" width="160">Lựa chọn</td>
        </tr>

        <?php
        	
            $confirm= 'Bạn có chắc chắn muốn xóa không';
            
            if(count($listData)>0){
	            foreach($listData as $tin)
	            {  
	                echo '<tr>
	                		  <td>'.$tin['Product']['id'].'</td>
	                          <td>'.$tin['Product']['title'].'</td>
	                          <td>'.$typeService[$tin['Product']['typeService']].'</td>
	                          <td>'.number_format($tin['Product']['priceInstall']).'đ</td>
	                          <td>'.number_format($tin['Product']['priceMainten']).'đ</td>
	                          <td>'.number_format($tin['Product']['priceVat']).'đ</td>
	                          <td>'.number_format($tin['Product']['priceTransfer']).'đ</td>
	                          <td>'.nl2br($tin['Product']['info']).'</td>
	                          
	                          <td align="center">
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-add_product.php/'.$tin['Product']['id'].'" class="input"  >Sửa</a>  
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-delete_product.php/'.$tin['Product']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Xóa</a>
							  </td>
	
	                        </tr>';
	            }
            }else{
	            echo '<tr><td colspan="8" align="center">Chưa có sản phẩm nào</td></tr>';
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
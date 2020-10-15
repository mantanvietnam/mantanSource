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
	$breadcrumb= array( 'name'=>'Danh sách mã giảm giá',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_gift.php',
						'sub'=>array('name'=>'Khuyến mại')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
	<div class="thanhcongcu">
	
	    <div class="congcu">
	
	        <a href="<?php echo $urlPlugins.'admin/managerHost-admin-add_gift.php';?>">
	
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
	<table width="100%" cellspacing="0" class="">
		<tr>
			<td width="155">
				<input name="code" value="<?php if(isset($_GET['code'])) echo $_GET['code'];?>" placeholder="Mã khuyến mại" style="float:left;margin-right: 5px;"/>
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
			<td align="center">Trạng thái</td>
        	<td align="center">Mã khuyến mại</td>
            <td align="center">Tên dịch vụ</td>
            <td align="center">Kiểu giảm giá</td>
            <td align="center">Giá trị giảm</td>
			<td align="center">Số lượng giảm</td>
			<td align="center">Thời gian giảm</td>
            <td align="center" width="160">Lựa chọn</td>
        </tr>

        <?php
        	
            $confirm= 'Bạn có chắc chắn muốn xóa không';
            
            if(count($listData)>0){
	            foreach($listData as $tin)
	            {  
					$timeStart= '';
					if(isset($tin['Gift']['timeStart']) && $tin['Gift']['timeStart']>0){
						$timeStart= getdate($tin['Gift']['timeStart']);
						$timeStart= $timeStart['mon'].'/'.$timeStart['mday'].'/'.$timeStart['year'];
					}
					
					$timeEnd= '';
					if(isset($tin['Gift']['timeEnd']) && $tin['Gift']['timeEnd']>0){
						$timeEnd= getdate($tin['Gift']['timeEnd']);
						$timeEnd= $timeEnd['mon'].'/'.$timeEnd['mday'].'/'.$timeEnd['year'];
					}
					
	                echo '<tr>
	                		  <td>'.$tin['Gift']['status'].'</td>
							  <td>'.$tin['Gift']['code'].'</td>
	                          <td>'.$listProduct[$tin['Gift']['product_id']]['Product']['title'].'</td>
							  <td>'.$tin['Gift']['type'].'</td>
	                          <td>'.number_format($tin['Gift']['value']).'</td>
							  <td>'.number_format((isset($tin['Gift']['numberOrderActive'])?$tin['Gift']['numberOrderActive']:0)).'/'.number_format($tin['Gift']['numberOrder']).'/'.number_format($tin['Gift']['number']).'</td>
	                          <td>'.$timeStart.' - '.$timeEnd.'</td>
	                          <td align="center">
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-add_gift.php/'.$tin['Gift']['id'].'" class="input"  >Sửa</a>  
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/managerHost-admin-delete_gift.php/'.$tin['Gift']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Xóa</a>
							  </td>
	
	                        </tr>';
	            }
            }else{
	            echo '<tr><td colspan="8" align="center">Chưa có khuyến mại nào</td></tr>';
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
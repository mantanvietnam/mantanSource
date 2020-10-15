<?php
	$breadcrumb= array( 'name'=>'Người dùng tải brochure ',
						'url'=>$urlPlugins.'admin/brochure-listBrochures.php',
						'sub'=>array('name'=>'Danh sách')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
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
<form action="" method="post" name="duan" class="taovienLimit">

    <table id="listTin" cellspacing="0" class="tableList">

        <tr>
        	<td align="center">Ngày nhận</td>
            <td align="center">Họ và tên</td>
            <td align="center">Email</td>
            <td align="center">Số điện thoại</td>
            <td align="center" width="250">Nội dung</td>
            <td align="center" width="160">Lựa chọn</td>

        </tr>

        <?php
        	
	        $confirm= 'Are you sure you want to remove ?';
            foreach($listData as $tin)
            {
            	$format = "d M Y";
				$date=date('d-m-Y h:i:s', $tin['Brochure']['created']->sec); 

				echo '<tr>
						  <td>'.$date.'</td>
						  <td>'.$tin['Brochure']['fullName'].'</td>
						  <td>'.$tin['Brochure']['email'].'</td>
						  <td>'.$tin['Brochure']['fone'].'</td>
						  <td>'.$tin['Brochure']['content'].'</td>
						  
						  <td align="center"> 
								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/brochure-deleteBrochure.php/'.$tin['Brochure']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Delete</a>
						  </td>

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
			
			echo '<a href="'.$urlNow.$back.'">Previous Page</a> ';
			for($i=$startPage;$i<=$endPage;$i++){
				echo ' <a href="'.$urlNow.$i.'">'.$i.'</a> ';
			}
			echo ' <a href="'.$urlNow.$next.'">Next Page</a> ';
	    ?>
	</p>
</form>





</div>
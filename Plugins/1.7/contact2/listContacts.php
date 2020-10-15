<?php
$breadcrumb= array( 'name'=>'Contact Management',
	'url'=>$urlPlugins.'admin/contact-listContacts.php',
	'sub'=>array('name'=>'Contact List')
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
			<td align="center">Thời gian</td>
			<td align="center">Họ tên</td>
			<td align="center">Số điện thoại</td>
			<td align="center">Email</td>
			<td align="center">Nội dung</td>
			<td align="center" width="160">Xóa</td>

		</tr>

		<?php

		$confirm= 'Bạn có chắc chắn muốn xóa ?';
		foreach($listData as $tin)
		{
			$format = "d M Y";
			$date=date('d-m-Y h:i:s', $tin['Contact']['created']->sec); 

			echo '<tr>
			<td>'.$date.'</td>
			<td>'.$tin['Contact']['fullName'].'</td>
			<td>'.$tin['Contact']['fone'].'</td>
			<td>'.$tin['Contact']['email'].'</td>
			<td>'.$tin['Contact']['content'].'</td>
			<td align="center"> 
			<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/contact-deleteContact.php/'.$tin['Contact']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Xóa</a>
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
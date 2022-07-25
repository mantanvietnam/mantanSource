<?php
	$breadcrumb= array( 'name'=> 'Quay số',
						'url'=>$urlPlugins.'admin/quayso-view-admin-listManager.php',
						'sub'=>array('name'=>'Nạp tiền')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
    
<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
  <font color='red'><?php echo $mess;?></font>
</div>

<div class="taovien">
<form action="" method="post" name="listForm">
    <p>Số tiền nạp cho tài khoản <?php echo $infoManager['Manager']['fullname'].' - '.$infoManager['Manager']['phone'];?></p>
    <input style="width: 300px;" type="number" min="50000" value="" name="coin" id="coin" />
    <input type="submit" value="Nạp tiền">
</form>
</div>

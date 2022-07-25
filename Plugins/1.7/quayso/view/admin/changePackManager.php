<?php
	$breadcrumb= array( 'name'=> 'Quay số',
						'url'=>$urlPlugins.'admin/quayso-view-admin-listManager.php',
						'sub'=>array('name'=>'Chuyển gói dịch vụ')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
    
<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
  <font color='red'><?php echo $mess;?></font>
</div>

<div class="taovien">
<form action="" method="post" name="listForm">
    <p>Chuyển gói dịch vụ cho tài khoản <?php echo $infoManager['Manager']['fullname'].' - '.$infoManager['Manager']['phone'];?></p>
    <select name="typeBuy">
    	<option value="buyTurn" <?php if($infoManager['Manager']['typeBuy']=='buyTurn') echo 'selected';?> >Thanh toán theo lần mua</option>
    	<option value="buyMonth" <?php if($infoManager['Manager']['typeBuy']=='buyMonth') echo 'selected';?> >Miễn phí trong 30 ngày</option>
    	<option value="buyForever" <?php if($infoManager['Manager']['typeBuy']=='buyForever') echo 'selected';?> >Miễn phí trọn đời</option>
    </select>
    <input type="submit" value="Chuyển">
</form>
</div>

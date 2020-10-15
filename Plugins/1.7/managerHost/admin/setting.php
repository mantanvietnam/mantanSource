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
	$breadcrumb= array( 'name'=>'Cài đăt chung',
						'url'=>$urlPlugins.'admin/managerHost-admin-setting.php',
						'sub'=>array('name'=>'Thông tin cài đặt')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
    <script type="text/javascript">
	
	function save()
	{
	    document.listForm.submit();
	}
	</script>
	  <div class="thanhcongcu">
	
	      <div class="congcu" onclick="save();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        Lưu
	      </div>
	      
	
	  </div>
	  <div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		  <?php echo "<font color='red'>".$mess."</font>";?>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
			  <tr>
	            <td align="right" width="200" >Giờ server</td>
	            <td align="left">
					<?php
						$now= getdate();
						echo $now['hours'].':'.$now['minutes'].':'.$now['seconds'].' '.$now['mday'].'/'.$now['mon'].'/'.$now['year'];
					?>
				</td>
	          </tr>
	          <tr>
	            <td align="right" width="200" >Mail gửi thông báo</td>
	            <td align="left"><input style="width: 300px;" type="email" value="<?php echo @$data['Option']['value']['email'];?>" name="email" id="email" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Tên hiển thị khi gửi mail</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['displayName'];?>" name="displayName" id="displayName" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Chữ ký trong email</td>
	            <td align="left"><?php showEditorInput('signature','signature',@$data['Option']['value']['signature'],1);?></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Thông tin chuyển khoản ngân hàng</td>
	            <td align="left"><?php showEditorInput('infoBank','infoBank',@$data['Option']['value']['infoBank'],0);?></td>
	          </tr>
	      </table>
	    </form>
	  </div>

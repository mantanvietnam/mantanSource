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
	$breadcrumb= array( 'name'=>'Static',
						'url'=>$urlPlugins.'admin/static-setting.php',
						'sub'=>array('name'=>'Setting')
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
	        <?php echo $languageMantan['save'];?>
	      </div>
	      
	
	  </div>
	  <div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		  <?php echo "<font color='red'>".$mess."</font>";?>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" width="200" >Today</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['mday'];?>" name="mday" id="mday" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Current month</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['mon'];?>" name="mon" id="mon" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Total hits</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['total'];?>" name="total" id="total" /></td>
	          </tr>
			  
	      </table>
	    </form>
	  </div>

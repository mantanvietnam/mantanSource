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
	$breadcrumb= array( 'name'=>'Drive Tool',
						'url'=>$urlPlugins.'admin/driveTool-view-settingDrive.php',
						'sub'=>array('name'=>'Drive Settings')
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
		  <font color='red'><?php echo $mess;?></font>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	
	    	
	        <p>API key</p>
	        <input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['apiKey'];?>" name="apiKey" id="apiKey" />
	        
	        
	    </form>
	  </div>

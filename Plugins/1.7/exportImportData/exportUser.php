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
	$breadcrumb= array( 'name'=>'Export Import Data',
						'url'=>$urlPlugins.'admin/exportImportData-exportUser.php',
						'sub'=>array('name'=>'Export User')
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
	
	      <div class="congcu">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	        	<a href="<?php echo $urlPlugins.'admin/exportImportData-downloadUser.php'; ?>">
	        	<input type="image" src="<?php echo $webRoot;?>images/save.png" /></a>
	        </span>
	        <br/>
	        <?php echo $languageMantan['save'];?>
	      </div>
	      
	
	  </div>
	  <div class="clear"></div>
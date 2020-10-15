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
	global $modelOption;
?>
<?php
	$breadcrumb= array( 'name'=>'Export Import Data',
						'url'=>$urlPlugins.'admin/exportImportData-exportCart.php',
						'sub'=>array('name'=>'Export Cart')
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
	
	      <div class="congcu" onclick="document.getElementById('dangtin').submit();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        <?php echo $languageMantan['save'];?>
	      </div>
	      
	
	  </div>
	  <div class="clear"></div>
	
	<div id="content">
	<form action="<?php echo $urlPlugins;?>admin/exportImportData-downloadCart.php" method="post" id="dangtin" >
	
	    <input type="hidden" value="<?php echo (isset($news['Product']['id']))?$news['Product']['id']:'';?>" name="id" />
	    		<table width="100%">
					<tr>
						<td valign="top" style="padding-left: 15px;">
							<p><b>Trạng thái</b></p>
							<p style="padding-left: 10px;"  >
							<input id="all" type="radio" checked name="lock" value="0" />&nbsp&nbspKích hoạt
							<input id="all" type="radio" name="lock" value="1" />&nbsp&nbspKhóa</p>
						</td>
					</tr>
				</table>
	</form>
</div>
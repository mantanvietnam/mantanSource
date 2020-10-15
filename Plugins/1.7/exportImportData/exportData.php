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
	$listCategory= $modelOption->getOption('productCategory');
	function listCatShow($cat,$sau,$idCM)
	{
		if($cat['id']>0)
		{
			echo '<p style="padding-left: 10px;"  >';
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}

			if(in_array($cat['id'], $idCM) )
			{
				echo '<input id="cat" onClick="document.getElementById(\'all\').checked=false;" type="checkbox" checked="checked" name="check_list[]" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			else
			{
				echo '<input id="cat" onClick="document.getElementById(\'all\').checked=false;" type="checkbox" name="check_list[]" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			echo '</p>';
		}

		if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub)
			{
				listCatShow($sub,$sau+1,$idCM);
			}
		}
	}
	
	function listCat($cat,$sau,$parent,$idSelect)
	{
		if($cat['id']>0)
		{
			if($idSelect!=$cat['id'])
			{
				echo '<option id="'.$parent.'" value="'.$cat['id'].'">';
			}
			else
			{
				echo '<option selected="" id="'.$parent.'" value="'.$cat['id'].'">';
			}
			
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp&nbsp&nbsp&nbsp';
			}
			echo $cat['name'].'</option>';
		}

		if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub)
			{
				listCat($sub,$sau+1,$cat['id'],$idSelect);
			}
		}
	}
?>
<?php
	$breadcrumb= array( 'name'=>'Export Import Data',
						'url'=>$urlPlugins.'admin/exportImportData-exportData.php',
						'sub'=>array('name'=>'Export Data')
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
	<form action="<?php echo $urlPlugins;?>admin/exportImportData-downloadData.php" method="post" id="dangtin" >
	
	    <input type="hidden" value="<?php echo (isset($news['Product']['id']))?$news['Product']['id']:'';?>" name="id" />
	    		<table width="100%">
					<tr>
						<td valign="top" style="padding-left: 15px;">
							<p><b>Danh mục sản phẩm</b></p>
							<?php
								if(isset($listCategory['Option']['value']['category']) && count($listCategory['Option']['value']['category'])>0){
									if(isset($news['Product']['category'])){
										$categorySelect= $news['Product']['category'];
									}else{
										$categorySelect= array();
									}
									echo '<p style="padding-left: 10px;"  ><input id="all"
				  type="checkbox" checked="" name="check_list[]" value="0" />&nbsp&nbspToàn bộ</p>';
									foreach($listCategory['Option']['value']['category'] as $cat){
										listCatShow($cat,0,$categorySelect);
									}
								}
					        ?>
						</td>
					</tr>
				</table>
	</form>
</div>
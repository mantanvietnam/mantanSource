<?php
	global $modelOption;
	$listCategory= $modelOption->getOption('productCategory');
?>

<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
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
				echo '<input type="checkbox" checked="checked" name="check_list[]" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			else
			{
				echo '<input type="checkbox" name="check_list[]" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
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
						'url'=>$urlPlugins.'admin/exportImportData-importData.php',
						'sub'=>array('name'=>'Import Data')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
  
    <script type="text/javascript">
	
	    function saveData()
	    {
	        var tieude= document.getElementById("title").value;
	        
	        if(tieude == '')
	        {
		        alert('<?php echo $languageProduct['YouMustFillOutTheInformationBelow'];?>');
	        }
	        else
	        {
	
	            document.dangtin.submit();
	
	        }
	
	    }
	</script>
	
	
	<div class="thanhcongcu">
	    <div class="congcu" onclick="document.getElementById('dangtin').submit();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        Lưu
	    </div>
	    <div class="congcu">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <a href="<?php echo $urlHomes; ?>Import.xls"><input type="image" src="<?php echo $webRoot;?>images/download_icon.png" width="30" height="30" /></a>
	        </span>
	        <br/>
	        Tải file
	    </div>
	
	</div>
	
	<div class="clear"></div>
	
	<div id="content">
	<form action="<?php echo $urlPlugins;?>admin/exportImportData-saveData.php" method="post" id="dangtin" >
	
	    <input type="hidden" value="<?php echo (isset($news['Product']['id']))?$news['Product']['id']:'';?>" name="id" />
	    		<table width="100%">
					<tr>
						<td valign="top">
							<div style="float:left;margin-right: 40px;margin-bottom: 10px;">
								<p><b>Upload file</b></p>
							</div>
							<div style="float:left;margin-right: 40px;margin-bottom: 10px;">
								<?php showUploadFile('file','file','',0);?>
							</div>	
						</td>
						<td valign="top" style="padding-left: 15px;">
							<p><b>Danh mục sản phẩm</b></p>
							<?php
								if(isset($listCategory['Option']['value']['category']) && count($listCategory['Option']['value']['category'])>0){
									if(isset($news['Product']['category'])){
										$categorySelect= $news['Product']['category'];
									}else{
										$categorySelect= array();
									}

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

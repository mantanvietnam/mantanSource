<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">
<?php
	global $languageProduct;

	if(!$listData)
	{
		echo $languageProduct['NoAdditionalAttributes'];
	}
	else
	{
		echo '<center><b>'.$category['name'].'</b></center>';
		echo '<form method="post" action="'.$urlPlugins.'admin/product-category-saveCategory.php">
			  	<input type="hidden" value="'.$category['id'].'" name="idCatEdit" />
			  	<input type="hidden" value="saveProperties" name="type" />
				';
		foreach($listData['Option']['value']['allData'] as $components)
		{
			$checked= '';
			if(isset($category['properties'][$components['id']]) && count($category['properties'][$components['id']])>0) $checked= 'checked';
			echo '<p class="titleProperties"><input type="checkbox" name="properties'.$components['id'].'" value="1" '.$checked.' /> <b>'.$components['name'].'</b></p>
				  <ul class="listComponents">';
				  	if(isset($components['allData']) && count($components['allData'])>0){
					  	foreach($components['allData'] as $allData)
					  	{
					  		$checked= '';
					  		if(isset($category['properties'][$components['id']]) && in_array($allData['id'], $category['properties'][$components['id']])) $checked= 'checked';
						  	echo '<li><input type="checkbox" name="value'.$components['id'].'-'.$allData['id'].'" value="1" '.$checked.' /> '.$allData['name'].'</li>';
					  	}
				  	}
			echo '</ul>';
		}
		echo '		<br/><center><input class="input" type="submit" value="'.$languageProduct['Save'].'"></center>
			  </form>';
	}
?>
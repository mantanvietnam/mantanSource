<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
  global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['SyncDatabase'],
						'url'=>$urlPlugins.'admin/product-sync-syncProduct.php',
						'sub'=>array('name'=>$languageProduct['SyncProduct'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	
<div class="taovien">
    <p style="color:red;"><?php echo $mess;?></p>
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList" width="400">
          	<tr>
            	<td align="right" width="250" ><?php echo $languageProduct['WebsiteSync'];?></td>
            	<td align="left"><input style="width: 300px;" placeholder="http://mantanshop.com/" type="text" value="<?php echo @$data['Option']['value']['syncProduct']['web'];?>" name="websiteSync" id="websiteSync" /></td>
          	</tr>
            <tr>
              <td align="right" width="200" ><?php echo $languageProduct['PasswordForDataSynchronization'];?></td>
              <td align="left"><input style="width: 300px;" placeholder="" type="password" value="<?php echo @$data['Option']['value']['syncProduct']['pass'];?>" name="passSync" id="passSync" /></td>
            </tr>
            <tr>
              <td align="right" width="200" ><?php echo $languageProduct['ProductCategory'];?></td>
              <td>
                <select name="category" id="category">
                  <option value="0"><?php echo $languageProduct['AllData'];?></option>
                <?php
                  foreach($listCategory['Option']['value']['category'] as $cat)
                  {
                    listCat($cat,1,0);
                  } 
                ?>
                </select>
              </td>
            </tr>
            <tr>
              <td align="right" width="200" ><?php echo $languageProduct['Manufacturer'];?></td>
              <td>
                <select name="manufacturer" id="manufacturer">
                  <option value="0"><?php echo $languageProduct['AllData'];?></option>
                <?php
                  foreach($listManufacturer['Option']['value']['category'] as $cat)
                  {
                    listCat($cat,1,0);
                  } 
                ?>
                </select>
              </td>
            </tr>
            <tr>
              <td align="center" colspan="2" ><input type="submit" value="<?php echo $languageProduct['SyncProduct'];?>" /></td>
            </tr>
      </table>
    </form>
</div>

<?php
  function listCat($cat,$sau,$parent)
  {
    if($cat['id']>0)
    {
      echo '<option id="'.$parent.'" value="'.$cat['id'].'">';
      for($i=1;$i<=$sau;$i++)
      {
        echo '&nbsp&nbsp&nbsp&nbsp';
      }
      echo $cat['name'].'</option>';
    }

    if(isset($cat['sub']) && count($cat['sub'])>0){
      foreach($cat['sub'] as $sub){
        listCat($sub,$sau+1,$cat['id']);
      }
    }
  }
?>

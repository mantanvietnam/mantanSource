<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
  global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['SyncDatabase'],
						'url'=>$urlPlugins.'admin/product-sync-syncProduct.php',
						'sub'=>array('name'=>$languageProduct['SyncManufacturer'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	
<div class="taovien">
    <p style="color:red;"><?php echo $mess;?></p>
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList" width="400">
          	<tr>
            	<td align="right" width="200" ><?php echo $languageProduct['WebsiteSync'];?></td>
            	<td align="left"><input style="width: 300px;" placeholder="http://mantanshop.com/" type="text" value="<?php echo @$data['Option']['value']['syncManufacturer']['web'];?>" name="websiteSync" id="websiteSync" /></td>
          	</tr>
            <tr>
              <td align="right" width="200" >ID Manufacturer</td>
              <td align="left"><input style="width: 300px;" placeholder="" type="text" value="<?php echo @$data['Option']['value']['syncManufacturer']['idManufacturer'];?>" name="idManufacturer" id="idManufacturer" /></td>
            </tr>
            <tr>
              <td align="right" width="200" ><?php echo $languageProduct['PasswordForDataSynchronization'];?></td>
              <td align="left"><input style="width: 300px;" placeholder="" type="password" value="<?php echo @$data['Option']['value']['syncManufacturer']['pass'];?>" name="passSync" id="passSync" /></td>
            </tr>
            <tr>
              <td align="center" colspan="2" ><input type="submit" value="<?php echo $languageProduct['SyncManufacturer'];?>" /></td>
            </tr>
      </table>
    </form>
</div>

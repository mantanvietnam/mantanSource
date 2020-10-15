<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
  global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['Setting'],
						'url'=>$urlPlugins.'admin/product-setting-settingProduct.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
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
        <?php echo $languageProduct['Save'];?>
    </div>
</div>

<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
	<?php
		$return= (isset($_GET['status']))?$_GET['status']:'';

        if($return==1){
          echo "<font color='red'>".$languageMantan['saveSuccess']."</font>";
        }elseif( $return==3){
          echo "<font color='red'>".$languageMantan['saveFailed']."</font>";
        }
	?>
</div>
	
<div class="taovien">
    <form action="<?php echo $urlPlugins.'admin/product-setting-saveSetting.php';?>" method="post" name="listForm">
        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
          	<tr>
            	<td align="right" width="250" ><?php echo $languageProduct['Language'];?></td>
            	<td align="left">
	            	<input type="radio" value="en.php" name="language" <?php if(isset($data['Option']['value']['language']) && $data['Option']['value']['language']=='en.php') echo 'checked=""';?> /> English 
	            	<input type="radio" value="vi.php" name="language" <?php if(isset($data['Option']['value']['language']) && $data['Option']['value']['language']=='vi.php') echo 'checked=""';?> /> Vietnamese 
            	</td>
          	</tr>
          	<tr>
            	<td align="right" width="" ><?php echo $languageProduct['NumberPostOnPage'];?></td>
            	<td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['numberPost'];?>" name="numberPost" id="numberPost" /></td>
          	</tr>
            <tr>
            	<td align="right" width="" ><?php echo $languageProduct['MassMin'];?> (kg)</td>
            	<td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['massMin'];?>" name="massMin" id="massMin" /></td>
          	</tr>
            <tr>
            	<td align="right" width="" ><?php echo $languageProduct['TransportFeeMin'];?></td>
            	<td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['transportFeeMin'];?>" name="transportFeeMin" id="transportFeeMin" /></td>
          	</tr>
            <tr>
              <td align="right" width="" ><?php echo $languageProduct['PasswordForDataSynchronization'];?></td>
              <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['passSynch'];?>" name="passSynch" id="passSynch" /></td>
            </tr>
      </table>
    </form>
</div>

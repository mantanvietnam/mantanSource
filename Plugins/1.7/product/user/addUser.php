<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
  global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['UserList'],
						'url'=>$urlPlugins.'admin/product-user-listUser.php',
						'sub'=>array('name'=>$languageProduct['InfoUser'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<script type="text/javascript">
	
	function save()
	{
	    var fullname= document.getElementById("fullname").value;
	    
	    if(fullname=='')
	    {
	        document.getElementById("status").innerHTML= "<font color='red'><?php echo $languageMantan['youMustFillOutTheInformationBelow'];?></font>";
	    }
	    else
	    {
	        document.listForm.submit();
	    }
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

        if( $return==1)
        {
          echo "<font color='red'>".$languageMantan['saveSuccess']."</font>";
        }
        else if( $return==3)
        {
          echo "<font color='red'>".$languageMantan['saveFailed']."</font>";
        }
	?>
</div>
	
<div class="taovien">
    <form action="<?php echo $urlPlugins.'admin/product-user-saveUserAdmin.php';?>" method="post" name="listForm">
    	<input type="hidden" value="<?php echo $data['User']['id'];?>" name="idUser" />
        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
          <tr>
            <td align="right" width="130"><?php echo $languageProduct['Account'];?></td>
            <td align="left"><?php echo @$data['User']['user'];?></td>
          </tr>
          
          <tr>
            <td align="right" ><?php echo $languageProduct['FullName'];?> (*)</td>
            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['User']['fullname'];?>" name="fullname" id="fullname" /></td>
          </tr>
          
          <tr>
            <td align="right" ><?php echo $languageProduct['Email'];?> (*)</td>
            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['User']['email'];?>" name="email" id="email" /></td>
          </tr>
          
          <tr>
            <td align="right" ><?php echo $languageProduct['Phone'];?> (*)</td>
            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['User']['phone'];?>" name="phone" id="phone" /></td>
          </tr>
          <tr>
            <td align="right" ><?php echo $languageProduct['Birthday'];?></td>
            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['User']['birthday'];?>" name="birthday" id="birthday" /></td>
          </tr>
          <tr>
            <td align="right" ><?php echo $languageProduct['Address'];?></td>
            <td align="left">
            	<textarea style="width: 300px;" rows="5" name="address" id="address"><?php echo @$data['User']['address'];?></textarea>
            </td>
          </tr>
          <tr>
            <td align="right" ><?php echo $languageProduct['NewPassword'];?></td>
            <td align="left"><input autocomplete="no" style="width: 300px;" type="text" value="" name="password" id="password" /></td>
          </tr>
      </table>
    </form>
</div>

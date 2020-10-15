<script type="text/javascript" src="<?php echo $webRoot;?>ckfinder/ckfinder.js"></script>
<?php
	$breadcrumb= array( 'name'=>'Theme Settings',
						'url'=>$urlPlugins.'ads-adsSetting.php',
						'sub'=>array('name'=>'Ads Setting')
					  );
	addBreadcrumbAdmin($breadcrumb);
	global $modelOption;
	$detail= $modelOption->getOption('adsSetting');
?>  
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
   <script type="text/javascript">
	var urlWeb="<?php echo $urlOptions;?>";
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
	        Save
	      </div>
	  </div>
	  <div class="clear" style="height: 10px;margin-left: 15px;" id='status'>
		  <?php
			// $return= $_GET['return'];	
	  //       if( $return==1)
	  //       {
	  //         echo "<font color='red'>".$languageMantan['saveSuccess']."</font>";
	  //       }
	  //       else if( $return==3)
	  //       {
	  //         echo "<font color='red'>".$languageMantan['saveFailed']."</font>";
	  //       }
		  ?>
	  </div>	
	  <div class="taovien">
	    <form action="<?php echo $urlPlugins.'admin/ads-saveAdsSetting.php';?>" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" cellpadding="0" class="table">
	        <style type="text/css">
	        	td{
	        		width: 300px;
	        	}
	        </style>
			<tr>
	            <td align="" ><p><b>Ẩn/hiện</b></p></td>
				<td>
					<select name="show">
						<option value="0" <?php echo (!isset($detail['Option']['value']['show']) || $detail['Option']['value']['show']==0)?'selected':''; ?>>Ẩn</option>
						<option value="1" <?php echo (isset($detail['Option']['value']['show']) && $detail['Option']['value']['show']==1)?'selected':''; ?>>Hiện</option>
					</select>
				</td>
	        </tr>
	          <tr>
	            <td align="" ><p><b>Quảng cáo bên trái</b></p></td>
	           </tr>
	           <tr>
	            <td>
	            	<p>Ảnh</p>
				  	<?php
				  		if (isset ($detail['Option']['value']['imageLeft']))
					  		showUploadFile('imageLeft','imageLeft',$detail['Option']['value']['imageLeft'],1);
					  	else
					  		showUploadFile('imageLeft','imageLeft','',1);
				  	?>
	            </td>
	            <td>
	            	<p>Đường dẫn</p>
				  	<input type='text' id='linkLeft' name="linkLeft" value='<?php if (isset ($detail['Option']['value']['linkLeft'])) echo $detail['Option']['value']['linkLeft'];?>' width="200" />
	            </td>
	          </tr>
	          <tr>
	            <td align="" ><p><b>Quảng cáo bên phải</b></p></td>
	           </tr>
	           <tr>
	            <td>
	            	<p>Ảnh</p>
				  	<?php
				  		if (isset ($detail['Option']['value']['imageRight']))
					  		showUploadFile('imageRight','imageRight',$detail['Option']['value']['imageRight'],2);
					  	else
					  		showUploadFile('imageRight','imageRight','',2);
				  	?>
	            </td>
	            <td>
	            	<p>Đường dẫn</p>
				  	<input type='text' id='linkRight' name="linkRight" value='<?php if (isset ($detail['Option']['value']['linkRight'])) echo $detail['Option']['value']['linkRight'];?>' width="200" />
	            </td>
	          </tr>
	      </table>

	    </form>

	  </div>


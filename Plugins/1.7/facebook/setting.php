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
	$breadcrumb= array( 'name'=>'Facebook',
						'url'=>$urlPlugins.'admin/facebook-setting.php',
						'sub'=>array('name'=>'Setting')
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
	        <?php echo $languageMantan['save'];?>
	      </div>
	      
	
	  </div>
	  <div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		  <?php echo "<font color='red'>".$mess."</font>";?>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" width="200" >ID App Facebook</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['idApp'];?>" name="idApp" id="idApp" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" width="200" >ID Admin Facebook</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['idAdmin'];?>" name="idAdmin" id="idAdmin" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Link Fanpage Facebook</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['linkFanpage'];?>" name="linkFanpage" id="linkFanpage" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Name Fanpage Facebook</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['nameFanpage'];?>" name="nameFanpage" id="nameFanpage" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Share Facebook</td>
	            <td align="left">
					<p>
						<input type="radio" value="url_currently" name="urlShare" <?php if(isset($data['Option']['value']['urlShare']) && $data['Option']['value']['urlShare']=='url_currently') echo 'checked';?> /> Url Currently 
						<input type="radio" value="url_other" name="urlShare" <?php if(isset($data['Option']['value']['urlShare']) && $data['Option']['value']['urlShare']=='url_other') echo 'checked';?> /> Url Other 
					</p>
					Url Other: <input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['url_share_facebook'];?>" name="url_share_facebook" id="url_share_facebook" />
				</td>
	          </tr>
	          <tr>
				<td align="right" >Image Default:</td>
				<td align="left">
					<?php                    
					    showUploadFile('image','image',@$data['Option']['value']['image'],0);
					?>
				</td>
			</tr>
			  
	      </table>
	    </form>
	  </div>

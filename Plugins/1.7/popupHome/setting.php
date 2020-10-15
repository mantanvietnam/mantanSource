<?php
	$breadcrumb= array( 'name'=>'Popup',
						'url'=>$urlPlugins.'admin/popupHome-setting.php',
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
		  <?php
			$return= (isset($_GET['status']))? $_GET['status']:'';
	
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
	    <form action="<?php echo $urlPlugins.'admin/popupHome-saveSetting.php';?>" method="post" name="listForm">
	    	Status 
	    	<select name="status">
		    	<option value="1" <?php if(isset($data['Option']['value']['status']) && $data['Option']['value']['status']==1) echo 'selected=""';?>>Active</option>
		    	<option value="0" <?php if(isset($data['Option']['value']['status']) && $data['Option']['value']['status']==0) echo 'selected=""';?>>Disable</option>
	    	</select>
	    	<br/><br/>
	    	<?php
				showEditorInput('content','content',@$data['Option']['value']['content']);
			?>
	    </form>
	  </div>

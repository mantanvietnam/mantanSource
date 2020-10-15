<?php
	$breadcrumb= array( 'name'=>'Subiz Support Online',
						'url'=>$urlPlugins.'admin/subiz-subiz.php',
						'sub'=>array('name'=>'Subiz Code')
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
	        Save
	      </div>
	      
	
	  </div>
	  <div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		  <?php
			if(isset($_GET['status'])){
				$return= $_GET['status'];
		
				if( $return==1)
				{
				  echo "<font color='red'>Save Success</font>";
				}
				else if( $return==3)
				{
				  echo "<font color='red'>Save Failed</font>";
				}
			}
		  ?>
	  </div>
	
	  <div class="taovien">
	    <form action="<?php echo $urlPlugins.'admin/subiz-saveSetting.php';?>" method="post" name="listForm">
	    	<p>Subiz Code</p>
	    	<textarea style="width: 100%;" rows="15" name="subizCode"><?php echo @$data['Option']['value'];?></textarea>
	    </form>
	  </div>

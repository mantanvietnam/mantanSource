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
	$breadcrumb= array( 'name'=>'Contact Management',
						'url'=>$urlPlugins.'admin/contact-setting.php',
						'sub'=>array('name'=>'Contact Settings')
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
		  <font color='red'><?php echo $mess;?></font>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	<p>
		    	Send email for admin: 
		    	<input value="1" type="radio" name="sendEmail" <?php if(isset($data['Option']['value']['sendEmail']) && $data['Option']['value']['sendEmail']==1) echo 'checked=""';?> /> Yes 
		    	<input value="0" type="radio" name="sendEmail" <?php if(isset($data['Option']['value']['sendEmail']) && $data['Option']['value']['sendEmail']==0) echo 'checked=""';?> /> No 
	    	</p>
	    	
	        <p>Display Name</p>
	        <input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['displayName'];?>" name="displayName" id="displayName" />
	        
	        <p>Email</p>
	        <input style="width: 300px;" type="email" value="<?php echo @$data['Option']['value']['email'];?>" name="email" id="email" />
	        
	    	
	    	<p><b>Contact Information</b></p>
	    	<?php
				showEditorInput('info','info',@$data['Option']['value']['info']);
			?>
			<br/>
			<p><b>Map</b></p>
	    	<?php
				showEditorInput('map','map',@$data['Option']['value']['map'],0);
			?>
	    </form>
	  </div>

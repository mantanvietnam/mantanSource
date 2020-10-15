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
	$breadcrumb= array( 'name'=>'Booking Management',
						'url'=>$urlPlugins.'admin/booking-setting.php',
						'sub'=>array('name'=>'Booking Settings')
					  );
	addBreadcrumbAdmin($breadcrumb);
	
	
	$data= $modelOption->getOption('bookingSettings');
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
			$return= $_GET['status'];
	
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
	    <form action="<?php echo $urlPlugins.'admin/booking-saveSetting.php';?>" method="post" name="listForm">
	    	<p>
		    	Send email for admin: 
		    	<input value="1" type="radio" name="sendEmail" <?php if($data['Option']['value']['sendEmail']==1) echo 'checked=""';?> /> Yes 
		    	<input value="0" type="radio" name="sendEmail" <?php if($data['Option']['value']['sendEmail']==0) echo 'checked=""';?> /> No 
	    	</p>
	    	
	    	<p><b>Contact Information</b></p>
	    	<?php
				showEditorInput('info','info',$data['Option']['value']['info']);
			?>
			<br/>
			<p><b>Map</b></p>
	    	<?php
				showEditorInput('map','map',$data['Option']['value']['map'],0);
			?>
	    </form>
	  </div>

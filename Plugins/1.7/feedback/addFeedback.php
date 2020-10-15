<?php
	$breadcrumb= array( 'name'=>'Customer feedback',
						'url'=>$urlPlugins.'admin/feedback-listFeedback.php',
						'sub'=>array('name'=>'Add feedback')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<script type="text/javascript">
	
	function save()
	{
	    document.listForm.submit();
	}
</script>

<style>
.tableList{
	width: 100%;
	margin-bottom: 20px;
	border-collapse: collapse;
    border-spacing: 0;
}
.tableList td{
	padding: 5px;
}
</style>

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
	
	  <div class="taovien clear">
	    <form action="" method="post" name="listForm">
	    	<input type="hidden" value="<?php echo @$data['Feedback']['id'];?>" name="id" />
	    	<table class="tableList">
		    	<tr>
			    	<td width="50%">
				    	<p>Full Name</p>
				    	<input style="width: 400px;" type="text" name="fullName" value="<?php echo @$data['Feedback']['fullName'];?>" />
			    	</td>
			    	<td>
				    	<p>Avatar</p>
				    	<?php
						  	showUploadFile('avatar','avatar',@$data['Feedback']['avatar']);
					  	?>
			    	</td>
		    	</tr>
		    	<tr>
			    	<td colspan="2">
				    	<p>Positions</p> 
				    	<input style="width: 600px;" type="text" name="positions" value="<?php echo @$data['Feedback']['positions'];?>" />
			    	</td>
		    	</tr>
                        <tr>
			    	<td colspan="2">
				    	<p>Link</p> 
				    	<input style="width: 600px;" type="text" name="link" value="<?php echo @$data['Feedback']['link'];?>" />
			    	</td>
		    	</tr>
                        
		    	<tr>
			    	<td colspan="2">
				    	<p>Content</p>
				    	<?php
							showEditorInput('content','content',$data['Feedback']['content']);
						?>
			    	</td>
		    	</tr>
		    	
	    	</table>
	    	 
	    </form>
	  </div>

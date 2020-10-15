<?php
	$breadcrumb= array( 'name'=>'Nhân sự',
						'url'=>$urlPlugins.'admin/manager-view-addManager.php',
						'sub'=>array('name'=>'Thêm nhân sự')
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
	
	  <div class="taovien">
	    <form action="<?php echo $urlPlugins.'admin/manager-saveManager.php';?>" method="post" name="listForm">
	    	<input type="hidden" value="<?php if(!empty($data['Manager']['id']))  echo $data['Manager']['id'];?>" name="id" />
	    	<table class="tableList">
		    	<tr>
			    	<td width="50%">
				    	<p>Tên nhân viên</p>
				    	<input style="width: 400px;" type="text" name="name" value="<?php if(!empty($data['Manager']['name'])) echo $data['Manager']['name'];?>" />
			    	</td>
			    	<td>
				    	<p>Ảnh đại diện</p>
				    	<?php
				    		if(empty($data['Manager']['avatar'])){
				    			$data['Manager']['avatar']=null;
				    		}
						  	showUploadFile('avatar','avatar',$data['Manager']['avatar'],0);
					  	?>
			    	</td>
		    	</tr>
		    	<tr>
		    		<td>
				    	<p>Chức vụ</p>
				    	<input style="width: 400px;" type="text" name="chucvu" value="<?php if(!empty($data['Manager']['chucvu'])) echo $data['Manager']['chucvu'];?>" />
			    	</td>

		    		
			    	<td>
				    	<p>Phòng ban</p> 
				    	<select name="category" id='category'> 
						  	<?php
						  		if(!empty($listDataCategory['Option']['value']['allData'])){
						  			foreach($listDataCategory['Option']['value']['allData'] as $components)
							  		{
							  			if($components['id']!=$data['Manager']['category']){
								  			echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
								  		}else{
								  			echo '<option selected value="'.$components['id'].'">'.$components['name'].'</option>';
								  		}
							  		}
						  		}
						  		
						  	?>
					  	</select>
			    	</td>
		    	</tr>
		    	<tr>
		    		<td colspan="2">
				    	<p>Hàng hiển thị</p>
				    	<input style="width: 400px;" type="text" name="row" value="<?php if(!empty($data['Manager']['row'])) echo $data['Manager']['row'];?>" />
			    	</td>
		    	</tr>
		    	
		    	<tr>
			    	<td colspan="2">
				    	<p>Mô tả</p>
				    	<?php
				    		if(empty($data['Manager']['content'])){
				    			$data['Manager']['content']='';
				    		}
							showEditorInput('content','content',$data['Manager']['content']);
						?>
			    	</td>
		    	</tr>
	    	</table>
	    	 
	    </form>
	  </div>



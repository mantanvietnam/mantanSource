<?php
	$breadcrumb= array( 'name'=>'Document',
						'url'=>$urlPlugins.'admin/document-view-listDocument.php',
						'sub'=>array('name'=>'Them tai lieu')
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
	    <form action="<?php echo $urlPlugins.'admin/document-saveDocument.php';?>" method="post" name="listForm">
	    	<input type="hidden" value="<?php if(!empty($data['Document']['id']))  echo $data['Document']['id'];?>" name="id" />
	    	<table class="tableList">
		    	<tr>
			    	<td width="50%">
				    	<p>Tên tài liệu</p>
				    	<input style="width: 400px;" type="text" name="name" value="<?php if(!empty($data['Document']['name'])) echo $data['Document']['name'];?>" />
			    	</td>
			    	<td>
				    	<p>File</p>
				    	<?php
				    		if(empty($data['Document']['file'])){
				    			$data['Document']['file']=null;
				    		}
						  	showUploadFile('file','file',$data['Document']['file'],0);
					  	?>
			    	</td>
		    	</tr>
		    	<tr>
		    		<td>
				        <p><b><?php echo @$languageMantan['datePosted'];?></b></p>
				        <p id="ngayDang">
					        <?php
						        
						        if(!empty($data['Document']['time']))
						        {
							        $today= getdate($data['Document']['time']);
							        $str= '<select name="ngay">';
								    for($i=1;$i<=31;$i++)
								    {
									    if($i!=$today['mday'])
									    {
										    $str= $str.'<option value="'.$i.'">'.@$languageMantan['date'].' '.$i.'</option>';
									    }
									    else
									    {
										    $str= $str.'<option selected="selected" value="'.$i.'">'.@$languageMantan['date'].' '.$i.'</option>';
									    }
								    }
								    $str= $str.'</select>&nbsp;&nbsp;';
								    
								    $str= $str. '<select name="thang">';
								    for($i=1;$i<=12;$i++)
								    {
									    if($i!=$today['mon'])
									    {
										    $str= $str.'<option value="'.$i.'">'.@$languageMantan['month'].' '.$i.'</option>';
									    }
									    else
									    {
										    $str= $str.'<option selected="selected" value="'.$i.'">'.@$languageMantan['month'].' '.$i.'</option>';
									    }
								    }
								    $str= $str.'</select>&nbsp;&nbsp;';
								    
								    $str= $str. '<select name="nam">';
								    for($i=$today['year']-10;$i<=$today['year']+10;$i++)
								    {
									    if($i!=$today['year'])
									    {
										    $str= $str.'<option value="'.$i.'">'.@$languageMantan['year'].' '.$i.'</option>';
									    }
									    else
									    {
										    $str= $str.'<option selected="selected" value="'.$i.'">'.@$languageMantan['year'].' '.$i.'</option>';
									    }
								    }
								    $str= $str.'</select>&nbsp;&nbsp;';
								    
								    echo $str;
						        }
						        else
						        {
							        $today= getdate();
							        echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];
							        echo '  &nbsp;&nbsp;&nbsp;
									        <a href="javascript:void(0)" onclick="editDate('.$today['mday'].','.$today['mon'].','.$today['year'].');" style="text-decoration: underline;">'.@$languageMantan['edit'].'</a>';
						        }
						        
					        ?>
					        
				        </p>
			        </td>
			    	<td>
				    	<p>Chuyên mục</p> 
				    	<select name="category" id='category'> 
						  	<?php
						  		if(!empty($listDataCategory['Option']['value']['allData'])){
						  			foreach($listDataCategory['Option']['value']['allData'] as $components)
							  		{
							  			if($components['id']!=$data['Document']['category']){
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
				    	<p>Ảnh minh họa</p>
				    	<?php
				    		if(empty($data['Document']['image'])){
				    			$data['Document']['image']=null;
				    		}
						  	showUploadFile('image','image',$data['Document']['image'],1);
					  	?>
			    	</td>
		    	</tr>
		    	<tr>
			    	<td colspan="2">
				    	<p>Content</p>
				    	<?php
				    		if(empty($data['Document']['content'])){
				    			$data['Document']['content']='';
				    		}
							showEditorInput('content','content',$data['Document']['content']);
						?>
			    	</td>
		    	</tr>
	    	</table>
	    	 
	    </form>
	  </div>


<script type="text/javascript">

	    var urlWeb="<?php echo $urlNotices;?>";
	
	    function editDate(ngay,thang,nam)
	    {
		    
		    var i,str;
		    str= '<select name="ngay">';
		    for(i=1;i<=31;i++)
		    {
			    if(i!=ngay)
			    {
				    str= str+'<option value="'+i+'"><?php echo $languageMantan['date'];?> '+i+'</option>';
			    }
			    else
			    {
				    str= str+'<option selected="selected" value="'+i+'"><?php echo $languageMantan['date'];?> '+i+'</option>';
			    }
		    }
		    str= str+'</select>&nbsp;&nbsp;';
		    
		    str= str+ '<select name="thang">';
		    for(i=1;i<=12;i++)
		    {
			    if(i!=thang)
			    {
				    str= str+'<option value="'+i+'"><?php echo $languageMantan['month'];?> '+i+'</option>';
			    }
			    else
			    {
				    str= str+'<option selected="selected" value="'+i+'"><?php echo $languageMantan['month'];?> '+i+'</option>';
			    }
		    }
		    str= str+'</select>&nbsp;&nbsp;';
		    
		    str= str+ '<select name="nam">';
		    for(i=nam-10;i<=nam+10;i++)
		    {
			    if(i!=nam)
			    {
				    str= str+'<option value="'+i+'"><?php echo $languageMantan['year'];?> '+i+'</option>';
			    }
			    else
			    {
				    str= str+'<option selected="selected" value="'+i+'"><?php echo $languageMantan['year'];?> '+i+'</option>';
			    }
		    }
		    str= str+'</select>&nbsp;&nbsp;';
		    
		    document.getElementById("ngayDang").innerHTML= str;
	    }
	

	</script>
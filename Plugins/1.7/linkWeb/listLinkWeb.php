<script type="text/javascript" src="<?php echo $webRoot;?>ckfinder/ckfinder.js"></script>
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
	$breadcrumb= array( 'name'=>'Quản lý link liên kết',
						'url'=>$urlPlugins.'admin/linkWeb-listLinkWeb.php',
						'sub'=>array('name'=>'Danh sách liên kết')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
    
	  <div class="thanhcongcu">
	      <div class="congcu" onclick="addDataNew();">
	        <span>
	          <input type="image"  src="<?php echo $webRoot;?>images/add.png" />
	        </span>
	        <br/>
	        Thêm
	      </div>
	      
	  </div>
	  <div class="clear"></div>
	  <br />
	  
	  <div class="taovien" >
        <table id="listTable" cellspacing="0" class="tableList">

                <tr>
                  <td align="center" width="30">ID</td>
                  <td align="center" >Nhóm liên kết</td>
                  <td align="center" >Tên hiển thị</td>
                  <td align="center" >Liên kết</td>
                  <td align="center" width="50">Logo</td>
                  <td align="center" width="130">Chọn</td>
                </tr>
                <?php
                	if(isset($listData['Option']['value']['allData']) && count($listData['Option']['value']['allData'])>0){
	                    foreach($listData['Option']['value']['allData'] as $components)
	                    { 
                ?>
	                        <tr>
	                          <td align="center" ><?php echo $components['id'];?></td>
	                          <td><?php echo @$listDataCategory['Option']['value']['allData'][ $components['category'] ]['name'];?></td>
	                          <td><?php echo $components['name'];?></td>
	                          <td><a target="_blank" href="<?php echo $components['link'];?>"><?php echo $components['link'];?></a></td>
	                          <td>
	                          	<?php
		                          	if($components['image'])
		                          	{
			                          	echo '<img width="50" src="'.$components['image'].'" />';
		                          	}
	                          	?>
	                          </td>
	                          <td align="center" >
	                            <input class="input" type="button" value="Sửa" onclick="changeName(<?php echo $components['id'];?>,<?php echo (isset($components['category']))?$components['category']:0;?>,'<?php echo $components['name'];?>','<?php echo $components['image'];?>','<?php echo $components['link'];?>' );">
								&nbsp;
								<input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $components['id'];?>');">
	                          </td>
	                        </tr>
                    <?php 
                    	}
                    }
                ?>

        </table>
	  </div>
	  <div id="themData">
	      <form method="post" action="" name="listForm">
	      	<input type="hidden" value="" name="id" id="idData" />
	      	<input type="hidden" value="save" name="type" />
	      	<input type="hidden" value="1" name="redirect" />
		  	<p>Nhóm liên kết</p>
		  	<select name="category" id='category'> 
		  	<?php
		  		foreach($listDataCategory['Option']['value']['allData'] as $components)
		  		{
			  		echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
		  		}
		  	?>
		  	</select>
		  	<p>Tên liên kết</p>
		  	<input type='text' id='nameData' name="name" value='' />
		  	<p>Link liên kết</p>
		  	<input type='text' id='linkData' name="link" value='' />
		  	<p>Logo liên kết</p>
		  	<?php
			  	showUploadFile('image','image','');
		  	?>
		  	<br/><br/>
		  	<p><input type='submit' value='Lưu' class='input' /></p>
	      </form>
	  </div>
	
<script type="text/javascript">
	var urlDelete="<?php echo $urlPlugins.'admin/linkWeb-deleteLinkWeb.php';?>";
	var urlNow="<?php echo $urlNow;?>";
	
	function setCheckedValue(radioObj) {
		if(!radioObj)
	    {
			return;
	    }
		var radioLength = radioObj.length;
	
		for(var i = 0; i < radioLength; i++)
	    {
			radioObj[i].checked = false;
		}
	}

	function changeName(id,category,name,image,link)
	{
		setCheckedValue(document.forms['listForm'].elements['category']);

		var i,j;
		var x=document.getElementById("category");
		for (j=0;j<x.length;j++)
		{
			if(category == x.options[j].value)
			{
				x.options[j].selected= "selected";
				break;
			}
		}

		document.getElementById("idData").value= id;
		document.getElementById("nameData").value= name;
		document.getElementById("image").value= image;
		document.getElementById("linkData").value= link;
		
		$('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	
	function addDataNew()
	{
		document.getElementById("idData").value= '';
		document.getElementById("nameData").value= '';
		document.getElementById("image").value= '';
		document.getElementById("linkData").value= '';
		
	    $('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	
	function deleteData(id)
	{
	      var r= confirm("Bạn có chắc chắn muốn xóa không ?");
	      if(r==true)
	      {
	          $.ajax({
			      type: "POST",
			      url: urlDelete,
			      data: { id:id,type:'delete',redirect:0}
			    }).done(function( msg ) { 	
				  		window.location= urlNow;	
				 })
				 .fail(function() {
						window.location= urlNow;
					});  
	      }
	
	}
	</script>
</div>
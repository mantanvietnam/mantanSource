<link href="<?php echo $urlHomes.'app/Plugin/mantanHotel/style.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>

<?php
	$breadcrumb= array( 'name'=>'Quản lý tiện nghi',
						'url'=>$urlPlugins.'admin/mantanHotel-admin-furniture-listFurnitureAdmin.php',
						'sub'=>array('name'=>'Toàn bộ tiện nghi')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<div class="clear"></div>
<br />
<div class="taovien" >
	<!-- main page -->
	<div style="width: 600px; float: left; margin-right: 10px;">
		<table cellspacing="0" class="tableList">
			<tr>
				<td align="center" width="30">STT</td>
				<td align="center">Tên tiện nghi</td>
                <td align="center">Minh họa</td>
				<td align="center" width="100">Hiển thị</td>
				<td align="center" width="100">Chọn</td>
			</tr>
			<?php
			$dem=0;
			if (isset($listData['Option']['value']['allData']))
				foreach ($listData['Option']['value']['allData'] as $data)
				{
					$dem++;
					echo '
					<tr>
						<td>'.$dem.'</td>
						<td align="left"><p style="overflow: hidden; width: 340px; text-overflow: ellipsis;">'.$data['name'].'</p></td>
                        <td><img src="'.$data['image'].'" width="50" /></td>
                        ';
					    
                    if ($data['show']==1)
						echo '
							<td align="center"><img src="'.$webRoot.'images/Actions-dialog-ok-icon.png" /></td>';
					else
						echo '<td align="center"><img src="'.$webRoot.'images/Actions-edit-delete-icon.png" /></td>';
					echo '
							<td align="center" width="130">
								<a href="#" onclick="suaData(\''.$data['id'].'\',\''.$data['name'].'\',\''.$data['show'].'\',\''.$data['image'].'\',\''.$data['description'].'\',\''.$data['key'].'\');">Sửa</a>&nbsp;
								<a href="#" onclick="deleteData(\''.$data['id'].'\')">Xóa</a>
							</td>
						</tr>
						';
				}
			?>
		</table>
	</div>
	<div style="width: 400px; float: left;">
		<form name="dangtin" method="post" action="">
			<input type="hidden" value="" name="id" id="id" />
			<input type="hidden" value="save" name="type" id="type" />
			
			<table cellspacing="0" class="tableList">									
				<tr>
					<td>
						<p>Tên tiện nghi</p>
					</td>
					<td>
						<input type="text" name="name" id="name" value="" style="width:100%;" required/>
					</td>
				</tr>
				<tr>
					<td>
						<p>Miêu tả</p>
					</td>
					<td>
						<textarea name="description" id="description"  rows="5" style="width: 100%;"></textarea>
					</td>
				</tr>
				<tr>
					<td width="100">Hiển thị</td>
					<td>
						<select name="show" id="show">
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<p>Từ khóa</p>
					</td>
					<td>
						<input type="text" name="key" id="key" value="" style="width:100%;" />
					</td>
				</tr>
				<tr>
					<td width="100">Hình ảnh</td>
					<td>
						<?php showUploadFile('image','image','');?>
					</td>
				</tr>
			   <tr>
					<td colspan="2">
						<input type="submit" value="Lưu" class="input" onclick="return checkSpaceInSubmit('name');"  />                                         
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="themData"></div>
	<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins;?>admin/mantanHotel-admin-furniture-listFurnitureAdmin.php";
	var urlNow="<?php echo $urlNow;?>";

	function suaData(id,name,show,image,description,key)
	{
		document.getElementById("id").value= id;
	    document.getElementById("name").value= name;
		document.getElementById("show").value= show;
		document.getElementById("image").value= image;
		document.getElementById("description").value= description;
		document.getElementById("key").value= key;
	}



	function deleteData(idDelete)
	{
	    var check= confirm('Bạn có chắc chắn muốn xóa!');
		if(check)
		{
			$.ajax({
		      type: "POST",
		      url: urlWeb,
		      data: { idDelete:idDelete,type:'delete'}
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
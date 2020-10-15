<link href="<?php echo $urlHomes.'app/Plugin/mantanHotel/style.css';?>" rel="stylesheet">

<?php
	$breadcrumb= array( 'name'=>'Quản lý vị trí',
						'url'=>$urlPlugins.'admin/mantanHotel-admin-location-listLocationAdmin.php',
						'sub'=>array('name'=>'Toàn bộ vị trí')
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
				<td align="center" width="50">STT</td>
				<td align="center">Tên vị trí</td>
				<td align="center" width="100">Hiển thị</td>
				<td align="center" width="100">Chọn</td>
			</tr>
			<?php
			$dem=0;
			if (!empty($listData))
				foreach ($listData as $data)
				{
					$dem++;
					echo '
					<tr>
						<td>'.$dem.'</td>
						<td align="left"><p style="overflow: hidden; width: 340px; text-overflow: ellipsis;">'.$data['Localtion']['name'].'</p></td>';
					if ($data['Localtion']['show']==1)
						echo '
							<td align="center"><img src="'.$webRoot.'images/Actions-dialog-ok-icon.png" /></td>';
					else
						echo '<td align="center"><img src="'.$webRoot.'images/Actions-edit-delete-icon.png" /></td>';
					echo '
							<td align="center" width="130">
								<a href="#" onclick="suaData(\''.$data['Localtion']['id'].'\',\''.$data['Localtion']['name'].'\',\''.$data['Localtion']['show'].'\',\''.$data['Localtion']['description'].'\',\''.$data['Localtion']['key'].'\',\''.$data['Localtion']['city'].'\',\''.$data['Localtion']['district'].'\');">Sửa</a>&nbsp;
								<a href="#" onclick="deleteData(\''.$data['Localtion']['id'].'\')">Xóa</a>
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
						<p>Tên vị trí</p>
					</td>
					<td>
						<input type="text" name="name" id="name" value="" style="width:100%;" required />
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
					<td width="100">Tỉnh thành</td>
					<td>
						<select id="city" name="city" class="form-control" required onchange="getDistrict();">
							<option value="0">Chọn tỉnh/thành phố</option>
							<?php
								foreach ($listCity as $city)
								{
									echo '<option ';
									if (isset($data['Hotel']['city']) && $data['Hotel']['city']==$city['id'])
										echo 'select ';
									echo 'value="'.$city['id'].'">'.$city['name'].'</option>';
								}
							?>
						</select>
						<script>
							var allCity=[];
							<?php
								
								foreach ($listCity as $key => $value) {
									echo 'allCity[\''.$value['id'].'\']=[];';
									$dem=0;
									if (isset($value['district']) && count($value['district'])>0)
									foreach ($value['district'] as $key2 => $value2) {
										$dem++;
										echo 'allCity[\''.$value['id'].'\'][\''.$dem.'\']=[];';
										echo 'allCity[\''.$value['id'].'\'][\''.$dem.'\'][\'1\']='.$value2['id'].';';
										echo 'allCity[\''.$value['id'].'\'][\''.$dem.'\'][\'2\']=\''.$value2['name'].'\';';
									}
								}
							?>
							function getDistrict()
							{
								var city=document.getElementById('city').value;
								var mangDistrict=allCity[city];
								var dem=1;
								var chuoi="<option value=\"0\">Chọn quận/huyện</option>";
								
								while (typeof (mangDistrict[dem])!= 'undefined')
								{
									chuoi+="<option value=\""+mangDistrict[dem][1]+"\">"+mangDistrict[dem][2]+"</option>";
									dem++;
								}
								
								$('#district').html(chuoi);

							}
							
							
						</script>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<p>Quận huyện</p>
					</td>
					<td>
						<select id="district" name="district" class="form-control" required>
							<option value="0">Chọn quận/huyện</option>
						</select>
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
	var urlWeb="<?php echo $urlPlugins;?>admin/mantanHotel-admin-localtion-listLocationAdmin.php";
	var urlNow="<?php echo $urlNow;?>";
	
	function suaData(id,name,show,description,key,city,district)
	{
		document.getElementById("id").value= id;
	    document.getElementById("name").value= name;
		document.getElementById("show").value= show;
		document.getElementById("description").value= description;
		document.getElementById("key").value= key;
		document.getElementById("city").value= city;
		var mangDistrict=allCity[city];
		var dem=1;
		var chuoi="<option value=\"0\">Chọn quận/huyện</option>";
		while (typeof (mangDistrict[dem])!= 'undefined')
		{
			chuoi+="<option value=\""+mangDistrict[dem][1]+"\">"+mangDistrict[dem][2]+"</option>";
			dem++;
		}
		
		$('#district').html(chuoi);
		document.getElementById("district").value= district;
		
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
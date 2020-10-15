<?php
	function listCat($cat,$sau,$parent)
	{
		if($cat['id']>0)
		{
			echo '<option id="'.$parent.'" value="'.$cat['id'].'">';
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp&nbsp&nbsp&nbsp';
			}
			echo $cat['name'].'</option>';
		}

		if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub){
				listCat($sub,$sau+1,$cat['id']);
			}
		}
	}
	
	function listCatShow($cat,$sau,$webRoot)
	{
		global $urlHomes;
		echo '<tr>
				<td>
					<p style="padding-left: 10px;"  >';
						for($i=1;$i<=$sau;$i++)
						{
							echo '&nbsp&nbsp&nbsp&nbsp';
						}
						?>
						<img src="<?php echo $webRoot;?>images/bg-list-item.png" />
						&nbsp&nbsp
						<a target="_blank" href="<?php echo getLinkCat().$cat['slug'].'.html';?>"><span id="content<?php echo $cat['id'];?>"><?php echo $cat['name'];?></span></a>
					</p>
				</td>
				<td align="center">
					<?php 
						if($cat['show']==1)echo '<img src="'.$webRoot.'images/Actions-dialog-ok-icon.png" />'; 
						else  if($cat['show']==0) echo '<img src="'.$webRoot.'images/Actions-edit-delete-icon.png" />';
					?>
				</td>
				<td>
					<?php 
						echo $cat['slug'];
					?>
				</td>
				<td align="center">
						          
		          <a href="javascript: voind(0);" class="topIcon"  onclick="diChuyen('top',<?php echo $cat['id'];?>)">
			          <img src="<?php echo $webRoot;?>images/topIcon.png">
		          </a>
		         
		          <a href="javascript: voind(0);" class="bottomIcon"  onclick="diChuyen('bottom',<?php echo $cat['id'];?>)">
			          <img src="<?php echo $webRoot;?>images/bottomIcon.png">
		          </a>
	            </td>
	            <td align="center">
		            <input class="input" type="button" value="Cài đặt" onclick="settingFindCategory('<?php echo $cat['id'];?>');">
	            </td>
				<td align="center">
					<input class="input" type="button" value="Sửa" onclick="suaData('<?php echo @$cat['id'];?>','<?php echo @$cat['slug'];?>',<?php echo @(int)$cat['show'];?>,'<?php echo @$cat['image'];?>','<?php echo @$cat['description'];?>','<?php echo @$cat['nameSeo'];?>','<?php echo @$cat['key'];?>');window.scrollTo(0,0);">
					&nbsp;&nbsp;
					<input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $cat['id'];?>');">
				</td>
			</tr>
		<?php

		if(isset($cat['sub']) && count($cat['sub'])){
			foreach($cat['sub'] as $sub)
			{
				listCatShow($sub,$sau+1,$webRoot);
			}
		}
	}

?>
<link href="<?php echo $urlHomes.'app/Plugin/testSystem/style.css';?>" rel="stylesheet">
<?php
	$breadcrumb= array( 'name'=>'Quản lý bài thi',
						'url'=>$urlPlugins.'admin/testSystem-admin-listTypeTest.php',
						'sub'=>array('name'=>'Loại đề thi')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<div class="clear"></div>
<br />
<div class="taovien" >
	<!-- main page -->
	
	<form name="dangtin" method="post" action="<?php echo $urlPlugins;?>admin/testSystem-admin-saveTypeTest.php">
		<input type="hidden" value="" name="idCatEdit" id="idCatEdit" />
		<input type="hidden" value="save" name="type" />
		
		<table cellspacing="0" class="tableList">									
			<tr>
				<td>Loại đề thi</td>
				<td>
					<input type="text" name="name" id="name" value="" onkeyup="createSlug();" onchange="createSlug();" /> 
					Tên cho Seo
					<input type="text" name="nameSeo" id="nameSeo" value="" />
				</td>
				<td rowspan="4" valign="top">
					<p>Mô tả ngắn</p>
					<textarea name="description" id="description"  rows="15" style="width: 100%;"></textarea>
				</td>
			</tr>
            <tr>
				<td>Chuyên mục cha</td>
				<td>
					<select name="parent" id="parent">
						<option value="0">Chuyên mục gốc</option>
					<?php
						foreach($listData['Option']['value']['category'] as $cat)
						{
							listCat($cat,1,0);

						}	
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="100">Đường dẫn tĩnh</td>
				<td>
					<input type="text" name="slug" id="slug" value=""  />
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
				<td width="100">Ảnh</td>
				<td>
					<?php showUploadFile('image','image','');?>
				</td>
				<td rowspan="2" valign="top">
					<p>Từ khóa</p>
					<input type="text" name="key" id="key" value="" style="width:100%;" />
				</td>
			</tr>
           <tr>
                <td colspan="2">
                    <input type="submit" value="Lưu" class="input"  />                                         
                </td>
            </tr>
		</table>
	</form>
	
	
	<table cellspacing="0" class="tableList">
		<tr>
			<td align="center">Loại đề thi</td>
			<td align="center">Hiển thị</td>
			<td align="center">Đường dẫn tĩnh</td>
			<td align="center" width="100">Di chuyển</td>
			<td align="center" width="100">Tìm kiếm</td>
			<td align="center" width="130">Chọn</td>
		</tr>
		<?php
			if(isset($listData['Option']['value']['category']) && count($listData['Option']['value']['category'])>0){
				foreach($listData['Option']['value']['category'] as $cat){
					listCatShow($cat,0,$webRoot);
				}	
			}
		?>
	</table>
						
	<div id="themData"></div>
	<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins;?>admin/testSystem-admin-saveTypeTest.php";
	var urlNow="<?php echo $urlNow;?>";

	function createSlug()
	{
	  var str= document.getElementById("name").value;
	  str = str.replace(/^\s+|\s+$/g, ''); // trim
	  str = str.toLowerCase();

	  // remove accents, swap ñ for n, etc
	  var from = "đuúùũụủưứừữựửeéèẽẹẻêếềễệểoóòõọỏôồốỗộổơớờỡợởaàáãạảăằắặẵẳâấầậẫẩiíìĩịỉyýỳỹỵỷ·/_,:;";
	  var to   = "duuuuuuuuuuuueeeeeeeeeeeeooooooooooooooooooaaaaaaaaaaaaaaaaaaiiiiiiyyyyyy------";
	  for (var i=0, l=from.length ; i<l ; i++) {
	    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	  }

	  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
	    .replace(/\s+/g, '-') // collapse whitespace and replace by -
	    .replace(/-+/g, '-'); // collapse dashes

	  document.getElementById("slug").value= str;
	}

	function suaData(idCat,slug,show,image,description,nameSeo,key)
	{
	    var nameCat= document.getElementById("content"+idCat).innerHTML;
	    document.getElementById("name").value= nameCat;
		document.getElementById("idCatEdit").value= idCat;
		document.getElementById("slug").value= slug;
		document.getElementById("image").value= image;
		document.getElementById("description").value= description;
		document.getElementById("nameSeo").value= nameSeo;
		document.getElementById("key").value= key;
		
		var x=document.getElementById("parent");
		var i,j,idParent,truoc= 0;
		for (i=0;i<x.length;i++)
		{
			if(idCat == x.options[i].value)
			{
				idParent= x.options[i].id;
				for (j=0;j<x.length;j++)
				{
					if(idParent == x.options[j].value)
					{
						x.options[j].selected= "selected";
						break;
					}
				}
				break;
				
			}
			
		}
		
		x=document.getElementById("show");
		for (j=0;j<x.length;j++)
		{
			if(show == x.options[j].value)
			{
				x.options[j].selected= "selected";
				break;
			}
		}
	}

	function deleteData(idDelete)
	{
	    var check= confirm('Bạn có chắc chắn muốn xóa?');
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

	function diChuyen(type, idMenu)
	{
		$.ajax({
	      type: "POST",
	      url: urlWeb,
	      data: { typeChange:type, idMenu:idMenu,type:'change'}
	    }).done(function( msg ) { 	
		  		window.location= urlNow;	
		 })
		 .fail(function() {
				window.location= urlNow;
			});  
	}
	
	</script>
</div>
<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['Manufacturer'],
						'url'=>$urlPlugins.'admin/product-manufacturer-listManufacturer.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<div class="clear"></div>
<br />
<div class="taovien" >
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
			foreach($cat['sub'] as $sub)
			{
				listCat($sub,$sau+1,$cat['id']);
			}
		}
		
		function listCatShow($cat,$sau,$webRoot,$languageProduct)
		{
			echo '<tr>
					<td align="center" width="100">';
					if($cat['image'])
					{
						echo '<img src="'.$cat['image'].'" width="100" /></td>';
					}
			echo	'<td>
						<p style="padding-left: 10px;"  >';
							for($i=1;$i<=$sau;$i++)
							{
								echo '&nbsp&nbsp&nbsp&nbsp';
							}
							?>
							<img src="<?php echo $webRoot;?>images/bg-list-item.png" />
							&nbsp&nbsp
							<span id="content<?php echo $cat['id'];?>"><?php echo $cat['name'];?></span>
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
							          
			          <a href="javascript: voind(0);" class="topIcon" title="Lên" onclick="diChuyen('top',<?php echo $cat['id'];?>)">
				          <img src="<?php echo $webRoot;?>images/topIcon.png">
			          </a>
			         
			          <a href="javascript: voind(0);" class="bottomIcon" title="Xuống" onclick="diChuyen('bottom',<?php echo $cat['id'];?>)">
				          <img src="<?php echo $webRoot;?>images/bottomIcon.png">
			          </a>
		            </td>
					<td align="center">
						<input class="input" type="button" value="<?php echo $languageProduct['Edit'];?>" onclick="suaData('<?php echo @$cat['id'];?>','<?php echo @$cat['slug'];?>',<?php echo @(int)$cat['show'];?>,'<?php echo @$cat['image'];?>','<?php echo @$cat['description'];?>','<?php echo @$cat['address'];?>','<?php echo @$cat['email'];?>','<?php echo @$cat['phone'];?>','<?php echo @$cat['fax'];?>','<?php echo @$cat['ownerName'];?>','<?php echo @$cat['taxCode'];?>');window.scrollTo(0,0);">
						&nbsp;&nbsp;
						<input class="input" type="button" value="<?php echo $languageProduct['Delete'];?>" onclick="deleteData('<?php echo $cat['id'];?>');">
					</td>
				</tr>
			<?php

			if(isset($cat['sub']) && count($cat['sub'])>0){
				foreach($cat['sub'] as $sub)
				{
					listCatShow($sub,$sau+1,$webRoot,$languageProduct);
				}
			}
		}
	
	?>
		
			
	<!-- main page -->
	
	<form name="dangtin" method="post" action="<?php echo $urlPlugins;?>admin/product-manufacturer-saveManufacturer.php">
		<input type="hidden" value="" name="idCatEdit" id="idCatEdit" />
		<input type="hidden" value="save" name="type" />
		
		<table cellspacing="0" class="tableList">									
			<tr>
				<td width="150"><?php echo $languageProduct['Manufacturer'];?></td>
				<td><input type="text" name="name" id="name" value="" onkeyup="createSlug();" onchange="createSlug();" /></td>
				<td rowspan="7" valign="top">
					<p><?php echo $languageProduct['ShortDescription'];?></p>
					<textarea name="description" id="description"  rows="10" style="width: 100%;"></textarea>
					<br/>
					<p><?php echo $languageProduct['Keywords'];?></p>
					<textarea name="key" id="key"  rows="5" style="width: 100%;"></textarea>
				</td>
			</tr>
            <tr>
				<td><?php echo $languageProduct['ParentCategory'];?></td>
				<td>
					<select name="parent" id="parent">
						<option value="0"><?php echo $languageProduct['RootCategory'];?></option>
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
				<td><?php echo $languageProduct['Permalinks'];?></td>
				<td>
					<input type="text" name="slug" id="slug" value="" />
				</td>
			</tr>
            <tr>
				<td><?php echo $languageProduct['Show'];?></td>
				<td>
					<select name="show" id="show">
						<option value="1"><?php echo $languageProduct['Yes'];?></option>
						<option value="0"><?php echo $languageProduct['No'];?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $languageProduct['Image'];?></td>
				<td>
					<?php showUploadFile('image','image','');?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="noBorder">
						<tr>
							<td><?php echo $languageProduct['Address'];?></td>
							<td>
								<input type="text" name="address" id="address" value="" />
							</td>
							<td><?php echo $languageProduct['Email'];?></td>
							<td>
								<input type="text" name="email" id="email" value="" />
							</td>
						</tr>
						<tr>
							<td><?php echo $languageProduct['Phone'];?></td>
							<td>
								<input type="text" name="phone" id="phone" value="" />
							</td>
							<td><?php echo $languageProduct['Fax'];?></td>
							<td>
								<input type="text" name="fax" id="fax" value="" />
							</td>
						</tr>
						<tr>
							<td><?php echo $languageProduct['OwnerName'];?></td>
							<td>
								<input type="text" name="ownerName" id="ownerName" value="" />
							</td>
							<td><?php echo $languageProduct['TaxCode'];?></td>
							<td>
								<input type="text" name="taxCode" id="taxCode" value="" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
           <tr>
                <td colspan="2">
                    <input type="submit" value="<?php echo $languageProduct['SaveCategory'];?>" class="input"  />   
                    &nbsp;&nbsp;   
                    <input type="reset" value="<?php echo $languageProduct['AddNew'];?>" class="input"  />                                         
                </td>
            </tr>
		</table>
	</form>
			
			
	<table cellspacing="0" class="tableList">
		<tr>
			<td align="center"><?php echo $languageProduct['Image'];?></td>
			<td align="center"><?php echo $languageProduct['NameCategory'];?></td>
			<td align="center"><?php echo $languageProduct['Show'];?></td>
			<td align="center"><?php echo $languageProduct['Permalinks'];?></td>
			<td align="center" width="100"><?php echo $languageProduct['Move'];?></td>
			<td align="center" width="130"><?php echo $languageProduct['Choose'];?></td>
		</tr>
		<?php
			if(isset($listData['Option']['value']['category']) && count($listData['Option']['value']['category'])>0){
				foreach($listData['Option']['value']['category'] as $cat)
				{
					listCatShow($cat,0,$webRoot,$languageProduct);

				}	
			}
		?>
	</table>
								
    
	<script type="text/javascript">
		var urlWeb="<?php echo $urlPlugins;?>admin/product-manufacturer-saveManufacturer.php";
		var urlNow="<?php echo $urlNow;?>";

		setCheckedValue(document.forms['listForm'].elements['idXoa']);


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

		function suaData(idCat,slug,show,image,description,address,email,phone,fax,ownerName,taxCode)
		{
		    var nameCat= document.getElementById("content"+idCat).innerHTML;
		    document.getElementById("name").value= nameCat;
			document.getElementById("idCatEdit").value= idCat;
			document.getElementById("slug").value= slug;
			document.getElementById("image").value= image;
			document.getElementById("description").value= description;
			document.getElementById("address").value= address;
			document.getElementById("email").value= email;
			document.getElementById("phone").value= phone;
			document.getElementById("fax").value= fax;
			document.getElementById("ownerName").value= ownerName;
			document.getElementById("taxCode").value= taxCode;
			
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
		    var check= confirm('<?php echo $languageProduct['AreYouSureYouWantToRemove'];?>');
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


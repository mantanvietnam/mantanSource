<?php 
	global $languageProduct;
	function listCat($listCategory,$sau,$parent =0)
	{
		if(!empty($listCategory)){
			foreach ($listCategory as $cate) {
			$idCate = $cate['id'];
			if($parent == $idCate){
				$selected ="selected";
			}else{
				$selected ="";
			}
			echo '<option '.$selected.' value="'.$cate['id'].'">'.$cate['name'].'</option>';
			if(!empty($cate['sub'])){
				foreach ($cate['sub'] as $sub1) {
					$idSub1 = $sub1['id'];
					if($parent == $idSub1){
						$selected ="selected";
					}else{
						$selected ="";
					}
					echo '<option '.$selected.' value="'.$sub1['id'].'">';
					for($i=1;$i<=$sau+1;$i++)
					{
						echo '&nbsp&nbsp&nbsp&nbsp&nbsp';
					}
					echo $sub1['name'].'</option>';
					if(!empty($sub1['sub'])){
						foreach ($sub1['sub'] as $sub2) {
							$idSub2 = $sub2['id'];
							if($parent == $idSub2){
								$selected ="selected";
							}else{
								$selected ="";
							}
							echo '<option '.$selected.' value="'.$sub2['id'].'">';
							for($i=1;$i<=$sau+2;$i++)
							{
								echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
							}
							echo $sub2['name'].'</option>';
						if(!empty($sub2['sub'])){
							foreach ($sub2['sub'] as $sub3) {
								$idSub3 = $sub3['id'];
								if($parent == $idSub3){
									$selected ="selected";
								}else{
									$selected ="";
								}
								echo '<option '.$selected.' value="'.$sub3['id'].'">';
								for($i=1;$i<=$sau+3;$i++)
								{
									echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
								}
								echo $sub3['name'].'</option>';
							}
						}

						}
					}


				}
			}



			}
		}

		
	}
	
?>
<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	$breadcrumb= array( 'name'=>$languageProduct['ProductCategory'],
						'url'=>$urlPlugins.'admin/product-category-listCategory.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<div class="clear"></div>
<br />
<div class="taovien" >
	<!-- main page -->
	<script LANGUAGE="JavaScript">
		function countCharacter(field,count){
		var dodai = field.value.length;
		count.value = field.value.length
		}
	</script>
	<form name="dangtin" method="post" action="">
		<input type="hidden" value="<?php if(!empty($_GET['idCatEdit'])){echo $_GET['idCatEdit'];}else{echo "";}?>" name="idCatEdit" id="idCatEdit" />
		<input type="hidden" value="save" name="type" />
		
		<table cellspacing="0" class="tableList">									
			<tr>
				<td><?php echo $languageProduct['NameCategory'];?></td>
				<td>
					<input type="text" name="name" id="name" value="<?php if(!empty($dataEdit['name'])) echo $dataEdit['name'];?>" onkeyup="createSlug();" onchange="createSlug();" /> 
					<?php echo $languageProduct['NameForSeo'];?> 
					<input type="text" name="nameSeo" id="nameSeo" value="<?php if(!empty($dataEdit['nameSeo'])) echo $dataEdit['nameSeo'];?>" />
				</td>
				<td rowspan="6" valign="top">
					<p><?php echo $languageProduct['ShortDescription'];?></b><span style="color:#bbb;"> - Số ký : <input readonly type="text" name="ShortDescription" size=3 maxlength=3 value="0" disabled="disabled" style="border: 0;background: #fff;"></span></p>
					
					<textarea name="description" id="description" onKeyDown="countCharacter(this.form.description, this.form.ShortDescription);" onKeyUp="countCharacter(this.form.description,this.form.ShortDescription);"   rows="15" style="width: 100%;"><?php if(!empty($dataEdit['description'])) echo $dataEdit['description'];?></textarea>
				</td>
			</tr>
            <tr>
				<td><?php echo $languageProduct['ParentCategory'];?></td>
				<td>
					<select name="parent" id="parent">
						<option value="0"><?php echo $languageProduct['RootCategory'];?></option>
						<?php 
						listCat($listData['Option']['value']['category'],0,$dataEdit['parent']);
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="100"><?php echo $languageProduct['Permalinks'];?></td>
				<td>
					<input type="text" name="slug" id="slug" value="<?php if(!empty($dataEdit['slug'])) echo $dataEdit['slug'];?>"  />
				</td>
			</tr>
            <tr>
				<td width="100"><?php echo $languageProduct['Show'];?></td>
				<td>
					<select name="show" id="show">
						<option <?php if(isset($dataEdit['show']) &&($dataEdit['show'] == 1)){echo "selected";}?> value="1" ><?php echo $languageProduct['Yes'];?></option>
						<option <?php if(isset($dataEdit['show']) && ($dataEdit['show'] == 0) ){echo "selected";}?> value="0"><?php echo $languageProduct['No'];?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="100"><?php echo $languageProduct['Image'];?></td>
				<td >
					<?php showUploadFile('image','image',@$dataEdit['image']);?>
				</td>
				
			</tr>
			<tr>
				<td width="100"><?php echo $languageProduct['Keywords'];?></td>
				<td >
					<input type="text" name="key" id="key" value="<?php if(!empty($dataEdit['key'])) echo $dataEdit['key'];?>"  />
				</td>
			</tr>

           <tr>
           		<td width="100"><?php echo $languageProduct['infoCategory'];?></td>
                <td colspan="2">
                	<?php showEditorInput('infoCategory','infoCategory',@$dataEdit['infoCategory']);?>
                </td>
            </tr>
            <tr align="center">
            	<td colspan="3">
                    <input type="submit" value="<?php echo $languageProduct['SaveCategory'];?>" class="input"  />
                </td>
            </tr>
		</table>
	</form>
	<script type="text/javascript">
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

	</script>
</div>	
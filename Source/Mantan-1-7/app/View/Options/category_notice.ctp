 
<?php
	$breadcrumb= array( 'name'=>$languageMantan['news'],
						'url'=>$urlOptions.'categoryNotice',
						'sub'=>array('name'=>$languageMantan['newsCategories'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>   
<div class="clear"></div>
  <br />
  <div class="taovien">
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
		function listCatShow($cat,$sau,$webRoot,$languageMantan)
		{
			global $urlNotices;
			
			echo '<tr><td><p style="padding-left: 10px;"  >';
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp&nbsp&nbsp&nbsp';
			}
			?>
			<img src="<?php echo $webRoot;?>images/bg-list-item.png" />&nbsp&nbsp<a target="_blank" href="<?php echo getUrlNoticeCategory($cat['id'],$cat['slug']);?>"><span id="name<?php echo $cat['id'];?>"><?php echo $cat['name'];?></span></a>
			
			</p>
			</td>
			<td id="key<?php echo $cat['id'];?>"><?php echo $cat['key'];?></td>
			<td id="description<?php echo $cat['id'];?>"><?php echo $cat['description'];?></td>
			</td>
			<td>
				<?php 
                    if(!empty($cat['image'])) {
                        echo '<img src="'.$cat['image'].'" width="100" />';
                    }
				?>
			</td>
			<td align="center">
					          
	          <a href="javascript: voind(0);" class="topIcon" title="<?php echo $languageMantan['move'];?>" onclick="diChuyen('top',<?php echo $cat['id'];?>)">
		          <img src="<?php echo $webRoot;?>images/topIcon.png">
	          </a>
	         
	          <a href="javascript: voind(0);" class="bottomIcon" title="<?php echo $languageMantan['move'];?>" onclick="diChuyen('bottom',<?php echo $cat['id'];?>)">
		          <img src="<?php echo $webRoot;?>images/bottomIcon.png">
	          </a>
            </td>
			<td align="center">
				<input type="hidden" id="content<?php echo $cat['id'];?>" value="<?php echo @htmlspecialchars_decode($cat['content']);?>">
				<input class="input" type="button" value="<?php echo $languageMantan['edit'];?>" onclick="suaData('<?php echo @$cat['id'];?>','<?php echo @$cat['image'];?>');">
				&nbsp;&nbsp;
				<input class="input" type="button" value="<?php echo $languageMantan['delete'];?>" onclick="deleteData('<?php echo $cat['id'];?>','<?php echo $cat['slug'];?>');">
			</td>
			</tr>
			<?php
			if(isset($cat['sub']) && count($cat['sub'])>0){
				foreach($cat['sub'] as $sub)
				{
					listCatShow($sub,$sau+1,$webRoot,$languageMantan);
				}
			}
		}
	
	?>
		
			
			<!-- main page -->
			
			<form name="dangtin" method="post" action="<?php echo $urlOptions;?>saveCategoryNotice" role="form">
				<div class="form-group">
					<input type="hidden" value="" name="idCatEdit" id="idCatEdit" />
					
					<table cellspacing="0" class="table" style="width: 100%;" >									
						<tr>
							<td width="150"><?php echo $languageMantan['nameCategories'];?></td>
							<td><input class="form-control" type="text" name="name" id="name" value="" /></td>
							<td width="150" align="right"><?php echo $languageMantan['keyWord'];?></td>
							<td><input class="form-control" type="text" name="key" id="key" value="" /></td>
						</tr>
	                    <tr>
							<td><?php echo $languageMantan['parentCategories'];?></td>
							<td>
								<select name="parent" id="parent" class="form-control">
									<option value="0"><?php echo $languageMantan['rootCategories'];?></option>
								<?php
									foreach($group as $cat)
									{
										listCat($cat,1,0);
	
									}	
								?>
								</select>
							</td>
							<td rowspan="2" align="right"><?php echo $languageMantan['description'];?></td>
							<td rowspan="2">
								<textarea id="description" class="form-control" name="description" rows="5"></textarea>
							</td>
						</tr>
						<tr>
							<td width="100"><?php echo $languageMantan['ilustration'];?></td>
							<td>
                                <?php showUploadFile('image','image');?>
							</td>
						</tr>
	                    <tr>
	                    	<td><?php echo $languageMantan['content'];?></td>
	                        <td colspan="3">
	                            <?php
	                            	showEditorInput('content','content','');
	                            ?>                                       
	                        </td>
	                    </tr>
	                   <tr>
	                        <td colspan="4">
	                            <input type="submit" value="<?php echo $languageMantan['saveCategories'];?>" class="btn btn-default"  />                                          
	                        </td>
	                    </tr>
					</table>
				</div>
			</form>
			
			<br/><br/>
			<table cellspacing="0" class="table table-striped">
			<tr>
				<td align="center"><?php echo $languageMantan['nameCategories'];?></td>
				<td align="center"><?php echo $languageMantan['keyWord'];?></td>
				<td align="center" width="200"><?php echo $languageMantan['description'];?></td>
				<td align="center"><?php echo $languageMantan['ilustration'];?></td>
				<td align="center" width="80"><?php echo $languageMantan['move'];?></td>
				<td align="center" width="130"><?php echo $languageMantan['choose'];?></td>
			</tr>
			<?php
				if(isset($group) && count($group)>0){
					foreach($group as $cat)
					{
						listCatShow($cat,0,$webRoot,$languageMantan);
					}	
				}
			?>
			</table>
							
    
<script type="text/javascript">

var urlWeb="<?php echo $urlOptions;?>";

setCheckedValue(document.forms['listForm'].elements['idXoa']);

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

function suaData(idCat,image)
{
    var nameCat= document.getElementById("name"+idCat).innerHTML;
    var contentCat= document.getElementById("content"+idCat).value;
    document.getElementById("name").value= nameCat;
	document.getElementById("idCatEdit").value= idCat;
	document.getElementById("image").value= image;
	document.getElementById("key").value= document.getElementById("key"+idCat).innerHTML;
	document.getElementById("description").value= document.getElementById("description"+idCat).innerHTML;

	CKEDITOR.instances['content'].setData(contentCat);
	
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
	
	window.scrollTo(500,0);
}



function deleteData(idDelete,slugDelete)
{
    var check= confirm('<?php echo $languageMantan['areYouSureYouWantToRemove'];?>');
	if(check)
	{
		$.ajax({
	      type: "POST",
	      url: urlWeb+"deleteCatagery",
	      data: { idDelete:idDelete,slugDelete:slugDelete}
	    }).done(function( msg ) { 	
		  		window.location= urlWeb+"categoryNotice";	
		 })
		 .fail(function() {
				window.location= urlWeb+"categoryNotice";
			});  
	}
}

function diChuyen(type, idMenu)
{
	$.ajax({
      type: "POST",
      url: urlWeb+"changeCategoryNotice",
      data: { type:type, idMenu:idMenu}
    }).done(function( msg ) { 	
	  		window.location= urlWeb+"categoryNotice";	
	 })
	 .fail(function() {
			window.location= urlWeb+"categoryNotice";
		});  
}
</script>



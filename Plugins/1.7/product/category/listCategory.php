<?php
	global $languageProduct;

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
	
	function listCatShow($cat,$sau,$webRoot,$languageProduct)
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
		            <input class="input" type="button" value="<?php echo $languageProduct['Setting'];?>" onclick="settingFindCategory('<?php echo $cat['id'];?>');">
	            </td>
				<td align="center">
					<a  href="<?php global $urlPlugins;  echo $urlPlugins.'admin/product-category-addCategory.php?idCatEdit='.$cat['id'];?>"><input style="color: black;" type="button" value="<?php echo $languageProduct['Edit'];?>"></a>
					&nbsp;&nbsp;
					<input class="input" type="button" value="<?php echo $languageProduct['Delete'];?>" onclick="deleteData('<?php echo $cat['id'];?>');">
				</td>
			</tr>
		<?php

		if(isset($cat['sub']) && count($cat['sub'])){
			foreach($cat['sub'] as $sub)
			{
				listCatShow($sub,$sau+1,$webRoot,$languageProduct);
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
<div class="thanhcongcu">

    <div class="congcu">
        <a href="<?php echo $urlPlugins; ?>admin/product-category-addCategory.php">
          <span>

            <img src="<?php echo $webRoot;?>images/add.png">

          </span>

            <br>

            <?php echo $languageProduct['Add'];?>

        </a>

    </div>
</div>
<div class="taovien" >
	<!-- main page -->
	
	<table cellspacing="0" class="tableList">
		<tr>
			<td align="center"><?php echo $languageProduct['NameCategory'];?></td>
			<td align="center"><?php echo $languageProduct['Show'];?></td>
			<td align="center"><?php echo $languageProduct['Permalinks'];?></td>
			<td align="center" width="100"><?php echo $languageProduct['Move'];?></td>
			<td align="center" width="100"><?php echo $languageProduct['Search'];?></td>
			<td align="center" width="130"><?php echo $languageProduct['Choose'];?></td>
		</tr>
		<?php
			if(isset($listData['Option']['value']['category']) && count($listData['Option']['value']['category'])>0){
				foreach($listData['Option']['value']['category'] as $cat){
					listCatShow($cat,0,$webRoot,$languageProduct);
				}	
			}
		?>
	</table>
						
	<div id="themData"></div>
	<script type="text/javascript">
        var urlPluginCart = "<?php echo getLinkCart(); ?>";
        var urlHomes = "<?php echo $urlHomes; ?>";
        function editData(idProductShow)
        {
            $.ajax({
                type: "POST",
                url: urlHomes + "saveOrderProduct_addProduct",
                data: {id: idProductShow}
            }).done(function (msg) {
                window.location = urlPluginCart;
            });
        }
    </script>
	<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins;?>admin/product-category-saveCategory.php";
	var urlNow="<?php echo $urlNow;?>";
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
	function settingFindCategory(idCategory)
	{
		$.ajax({
	      type: "POST",
	      url: "<?php echo $urlPlugins;?>admin/product-category-settingFindCategory.php?layout=default",
	      data: { idCategory:idCategory}
	    }).done(function( msg ) {
	    	$('#themData').html(msg); 	
	  		$('#themData').lightbox_me({
		    centered: true, 
		    onLoad: function() { 
		        $('#themData').find('input:first').focus()
		        }
		    });
		 })
		 .fail(function() {
				alert('Load error')
			});  
	}
	</script>
</div>
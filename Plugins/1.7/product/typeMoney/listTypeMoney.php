<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['Currency'],
						'url'=>$urlPlugins.'admin/product-typeMoney-listTypeMoney.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>

    
<div class="thanhcongcu">
    <div class="congcu" onclick="addDataNew();">
        <span>
          <input type="image"  src="<?php echo $webRoot;?>images/add.png" />
        </span>
        <br/>
        <?php echo $languageProduct['Add'];?>
    </div>
</div>
<div class="clear"></div>
<br />
	  
<div class="taovien" >
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

                <tr>
                  <td align="center" width="30">ID</td>
                  <td align="center" width="150"><?php echo $languageProduct['Currency'];?></td>
                  <td align="center" width="30"><?php echo $languageProduct['Choose'];?></td>
                </tr>
                <?php
                	if(isset($listData['Option']['value']['allData']) && count($listData['Option']['value']['allData'])>0){
                    	foreach($listData['Option']['value']['allData'] as $components)
                    	{ 
                	?>
	                        <tr id="trList<?php echo $components['id'];?>">
	                          <td align="center" ><?php echo $components['id'];?></td>
	                          <td height="40" id="name<?php echo $components['id'];?>"><?php echo $components['name'];?></td>
	                          <td align="center" width="165" >
	                            <input class="input" type="button" value="<?php echo $languageProduct['Edit'];?>" onclick="changeName(<?php echo $components['id'];?>,'<?php echo $components['name'];?>');">
								&nbsp;
								<input class="input" type="button" value="<?php echo $languageProduct['Delete'];?>" onclick="deleteData('<?php echo $components['id'];?>');">
	                          </td>
	                        </tr>
                    <?php 
                    	}
                	}
                ?>

        </table>
    </form>
</div>

<div id="themData">
    <form method="post" action="<?php echo $urlPlugins;?>admin/product-typeMoney-saveTypeMoney.php">
      	<input type="hidden" value="" name="id" id="idData" />
      	<input type="hidden" value="save" name="type" />
      	<input type="hidden" value="1" name="redirect" />
	  	<?php echo $languageProduct['EnterTheNew'];?><br /><br /><input type='text' id='nameData' name="name" value='' />&nbsp;&nbsp;<input type='submit' value='<?php echo $languageProduct['Save'];?>' class='input' />
    </form>
</div>
	
<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins.'admin/product-typeMoney-saveTypeMoney.php';?>";
	var urlNow="<?php echo $urlNow;?>";
	
	function changeName(id,name)
	{
		document.getElementById("idData").value= id;
		document.getElementById("nameData").value= name;
		
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
		
	    $('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	
	function deleteData(id)
	{
	      var r= confirm("<?php echo $languageProduct['AreYouSureYouWantToRemove'];?>");
	      if(r==true)
	      {
	          $.ajax({
			      type: "POST",
			      url: urlWeb,
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
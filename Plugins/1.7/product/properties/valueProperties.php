<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['AdditionalAttributes'],
						'url'=>$urlPlugins.'admin/product-properties-listProperties.php',
						'sub'=>array('name'=>$listData['Option']['value']['allData'][$idProperties]['name'])
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
	  
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" class="tableList">
	
	                <tr>
	                  <td align="center" width="30">ID</td>
	                  <td align="center" ><?php echo $languageProduct['Value'];?></td>
	                  <td align="center" width="130"><?php echo $languageProduct['Choose'];?></td>
	                </tr>
	                <?php
	                	if(isset($listData['Option']['value']['allData'][$idProperties]['allData']) && count($listData['Option']['value']['allData'][$idProperties]['allData'])>0){
	                    	foreach($listData['Option']['value']['allData'][$idProperties]['allData'] as $components)
	                    	{ 
	                ?>
		                        <tr>
		                          <td align="center" ><?php echo $components['id'];?></td>
		                          <td><?php echo $components['name'];?></td>
		                          <td align="center" >
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
	      <form method="post" action="<?php echo $urlPlugins;?>admin/product-properties-saveProperties.php">
	      	<input type="hidden" value="<?php echo $idProperties;?>" name="idProperties" id="idProperties" />
	      	<input type="hidden" value="" name="id" id="idData" />
	      	<input type="hidden" value="saveValue" name="type" />
	      	<input type="hidden" value="0" name="redirect" />
		  	<p><?php echo $languageProduct['Value'];?></p>
		  	<input type='text' id='name' name="name" value='' />
		  	
		  	<br/><br/>
		  	<p><input type='submit' value='<?php echo $languageProduct['Save'];?>' class='input' /></p>
	      </form>
	  </div>
	
<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins.'admin/product-properties-saveProperties.php';?>";
	var urlNow="<?php echo $urlNow;?>";

	function changeName(id,name)
	{
		document.getElementById("idData").value= id;
		document.getElementById("name").value= name;
		
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
		document.getElementById("name").value= '';
		
		
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
			      data: { id:id,type:'deleteValue',redirect:0,idProperties: '<?php echo $idProperties;?>'}
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
<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['AdditionalAttributes'],
						'url'=>$urlPlugins.'admin/product-properties-listProperties.php',
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

<div class="taovien">
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

            <tr>
              <td align="center" width="30">ID</td>
              <td align="center" ><?php echo $languageProduct['PropertiesName'];?></td>
              <td align="center" ><?php echo $languageProduct['PropertiesCode'];?></td>
              <td align="center" ><?php echo $languageProduct['TypeShow'];?></td>
              <td align="center" ><?php echo $languageProduct['AddValue'];?></td>
              <td align="center" width="130"><?php echo $languageProduct['Choose'];?></td>
            </tr>
            <?php
            	if(isset($listData['Option']['value']['allData']) && count($listData['Option']['value']['allData'])>0){
                	foreach($listData['Option']['value']['allData'] as $components)
                	{ 
            ?>
	                    <tr>
	                      <td align="center" ><?php echo $components['id'];?></td>
	                      <td><?php echo $components['name'];?></td>
	                      <td><?php echo $components['code'];?></td>
	                      <td>
	                      	<?php 
	                          	switch($components['typeShow'])
	                          	{
		                          	case 1: echo 'Single Checkbox';break;
		                          	case 2: echo 'Multiple Checkbox';break;
		                          	case 3: echo 'Text';break;
	                          	}
	                      	?>
	                      </td>
	                      <td align="center">
	                      	<?php if($components['typeShow']==1 || $components['typeShow']==2){ ?>
	                          <a href="<?php echo $urlPlugins;?>admin/product-properties-valueProperties.php/<?php echo $components['id'];?>"><?php echo $languageProduct['AddValue'];?></a>
	                      	<?php }?>
	                      </td>
	                      <td align="center" >
	                        <input class="input" type="button" value="<?php echo $languageProduct['Edit'];?>" onclick="changeName(<?php echo $components['id'];?>,'<?php echo $components['name'];?>','<?php echo $components['code'];?>','<?php echo $components['typeShow'];?>');">
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
      	<input type="hidden" value="" name="id" id="idData" />
      	<input type="hidden" value="save" name="type" />
      	<input type="hidden" value="1" name="redirect" />
	  	<p><?php echo $languageProduct['PropertiesName'];?></p>
	  	<input type='text' id='name' name="name" value='' placeholder="Eg: Color" />
	  	<p><?php echo $languageProduct['PropertiesCode'];?></p>
	  	<input type='text' id='code' name="code" value='' placeholder="Eg: color" />
	  	<p><?php echo $languageProduct['TypeShow'];?></p>
	  	<select name="typeShow" id="typeShow">
		  	<option value="1">Single Checkbox</option>
		  	<option value="2">Multiple Checkbox</option>
		  	<option value="3">Text</option>
	  	</select>
	  	
	  	<br/><br/>
	  	<p><input type='submit' value='<?php echo $languageProduct['Save'];?>' class='input' /></p>
    </form>
</div>
	
<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins.'admin/product-properties-saveProperties.php';?>";
	var urlNow="<?php echo $urlNow;?>";
	
	function setCheckedValue(radioObj) {
		if(!radioObj)
	    {
			return;
	    }
		var radioLength = radioObj.length;
	
		for(var i = 0; i < radioLength; i++)
	    {
			radioObj[i].selected = false;
		}
	}

	function changeName(id,name,code,type)
	{
		document.getElementById("idData").value= id;
		document.getElementById("name").value= name;
		document.getElementById("code").value= code;
		
		var x=document.getElementById("typeShow");
		var j;
		for(j=0;j<x.length;j++)
		{
			if(type == x.options[j].value)
			{
				x.options[j].selected= "selected";
				break;
			}
		}
		
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
		document.getElementById("code").value= '';
		
		setCheckedValue(document.getElementById("typeShow"));
		
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
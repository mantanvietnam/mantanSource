<link href="<?php echo $urlHomes.'app/Plugin/questionAnswer/style.css';?>" rel="stylesheet">

<?php
	$breadcrumb= array( 'name'=>'Question Answer',
						'url'=>$urlPlugins.'admin/questionAnswer-listCategoryQuestion.php',
						'sub'=>array('name'=>'List Category Question')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>    
	  <div class="thanhcongcu">
	      <div class="congcu" onclick="addDataNew();">
	        <span>
	          <input type="image"  src="<?php echo $webRoot;?>images/add.png" />
	        </span>
	        <br/>
	        Thêm
	      </div>
	      
	  </div>
	  <div class="clear"></div>
	  <br />
	  
	  <div class="taovien" >
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" class="tableList">
	
	                <tr>
	                  <td align="center" width="30">ID</td>
	                  <td align="center" width="150">Chuyên mục</td>
	                  <td align="center" width="30">Chọn</td>
	                </tr>
	                <?php
                    if(!empty($listData['Option']['value']['allData'])){
	                    foreach($listData['Option']['value']['allData'] as $components)
	                    { 
	                ?>
	                        <tr id="trList<?php echo $components['id'];?>">
	                          <td align="center" ><?php echo $components['id'];?></td>
	                          <td height="40" id="name<?php echo $components['id'];?>"><a href="<?php echo $urlHomes.'question/'.$components['slug'].'.html';?>"><?php echo $components['name'];?></a></td>
	                          <td align="center" width="165" >
	                            <input class="input" type="button" value="Sửa" onclick="changeName(<?php echo $components['id'];?>,'<?php echo $components['name'];?>');">
								&nbsp;
								<input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $components['id'];?>');">
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
	      <form method="post" action="<?php echo $urlPlugins;?>admin/questionAnswer-saveCategory.php">
	      	<input type="hidden" value="" name="id" id="idData" />
	      	<input type="hidden" value="save" name="type" />
	      	<input type="hidden" value="1" name="redirect" />
		  	Tên chuyên mục<br /><br />
		  	<input type='text' id='nameData' name="name" value='' />
		  	&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
	      </form>
	  </div>
	
<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins.'admin/questionAnswer-saveCategory.php';?>";
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
	      var r= confirm("Bạn có chắc chắn muốn xóa không ?");
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
</div>
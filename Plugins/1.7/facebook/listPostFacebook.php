
<style>
.tableList{
	width: 100%;
	margin-bottom: 20px;
	border-collapse: collapse;
    border-spacing: 0;
    border-top: 1px solid #bcbcbc;
    border-left: 1px solid #bcbcbc;
}
.tableList td{
	padding: 5px;
	border-bottom: 1px solid #bcbcbc;
    border-right: 1px solid #bcbcbc;
}
</style>

<?php
	$breadcrumb= array( 'name'=>'Facebook',
						'url'=>$urlPlugins.'admin/facebook-listPostFacebook.php',
						'sub'=>array('name'=>'Danh sách bài đăng')
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
			<p style="color: red;"><?php echo @$mess;?></p>
	        <table id="listTable" cellspacing="0" class="tableList">
	
	                <tr>
	                  <td align="center" width="150">Link bài đăng</td>
	                  <td align="center" width="30">Chọn</td>
	                </tr>
	                <?php
						if(isset($listData['Option']['value']['allData']) && count($listData['Option']['value']['allData'])>0){
							foreach($listData['Option']['value']['allData'] as $components)
							{ 
	                ?>
	                        <tr id="trList<?php echo $components['id'];?>">
	                          <td id="link<?php echo $components['id'];?>"><?php echo $components['link'];?></td>
	                          <td align="center" width="165" >
	                            <input class="input" type="button" value="Sửa" onclick="changeName(<?php echo $components['id'];?>,'<?php echo $components['link'];?>');">
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
	      <form method="post" action="">
	      	<input type="hidden" value="" name="id" id="idData" />
	      	<input type="hidden" value="save" name="type" />
	      	<input type="hidden" value="1" name="redirect" />
		  	Link bài đăng<br /><br /><input type='text' required id='linkData' name="link" value='' />&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
	      </form>
	  </div>
	
<script type="text/javascript">
	var urlNow="<?php echo $urlNow;?>";
	
	function changeName(id,link)
	{
		document.getElementById("idData").value= id;
		document.getElementById("linkData").value= link;
		
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
		document.getElementById("linkData").value= '';
		
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
			      url: urlNow,
			      data: { id:id,type:'delete'}
			    }).done(function( msg ) { 	
						alert('Xóa dữ liệu thành công');
				  		window.location= urlNow;
				 })
				 .fail(function() {
						window.location= urlNow;
					});  
	      }
	
	}
	</script>
</div>